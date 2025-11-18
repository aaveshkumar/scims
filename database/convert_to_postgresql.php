<?php
/**
 * MySQL to PostgreSQL Migration Converter
 * Converts all MySQL migration files to PostgreSQL syntax
 */

$migrationsDir = __DIR__ . '/migrations';
$outputDir = __DIR__ . '/migrations_postgresql';

// Create output directory if it doesn't exist
if (!is_dir($outputDir)) {
    mkdir($outputDir, 0755, true);
}

// Get all SQL files
$files = glob($migrationsDir . '/*.sql');

echo "Converting " . count($files) . " migration files...\n\n";

foreach ($files as $file) {
    $filename = basename($file);
    echo "Processing: $filename\n";
    
    $sql = file_get_contents($file);
    
    // 1. Convert AUTO_INCREMENT to SERIAL
    $sql = preg_replace('/INT\s+UNSIGNED\s+AUTO_INCREMENT\s+PRIMARY\s+KEY/i', 'SERIAL PRIMARY KEY', $sql);
    $sql = preg_replace('/BIGINT\s+UNSIGNED\s+AUTO_INCREMENT\s+PRIMARY\s+KEY/i', 'BIGSERIAL PRIMARY KEY', $sql);
    
    // 2. Convert INT UNSIGNED to INTEGER
    $sql = preg_replace('/INT\s+UNSIGNED/i', 'INTEGER', $sql);
    $sql = preg_replace('/BIGINT\s+UNSIGNED/i', 'BIGINT', $sql);
    
    // 3. Convert ENUM to VARCHAR with CHECK constraint
    $sql = preg_replace_callback(
        '/(\w+)\s+ENUM\((.*?)\)(\s+(?:NOT\s+)?NULL)?(\s+DEFAULT\s+\'(.*?)\')?/i',
        function($matches) {
            $column = $matches[1];
            $values = $matches[2];
            $nullable = isset($matches[3]) ? $matches[3] : '';
            $default = isset($matches[4]) ? $matches[4] : '';
            
            // Clean up values
            $values = str_replace("'", "'", $values);
            
            return "$column VARCHAR(50)$nullable$default CHECK ($column IN ($values))";
        },
        $sql
    );
    
    // 4. Remove ENGINE, CHARSET, COLLATE
    $sql = preg_replace('/ENGINE\s*=\s*\w+/i', '', $sql);
    $sql = preg_replace('/DEFAULT\s+CHARSET\s*=\s*\w+/i', '', $sql);
    $sql = preg_replace('/COLLATE\s*=?\s*\w+/i', '', $sql);
    
    // 5. Convert TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    // PostgreSQL doesn't support ON UPDATE, we'll use triggers later
    $sql = preg_replace('/TIMESTAMP\s+DEFAULT\s+CURRENT_TIMESTAMP\s+ON\s+UPDATE\s+CURRENT_TIMESTAMP/i', 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP', $sql);
    
    // 6. Convert UNIQUE KEY to CONSTRAINT
    $sql = preg_replace('/UNIQUE\s+KEY\s+(\w+)\s+\((.*?)\)/i', 'CONSTRAINT $1 UNIQUE ($2)', $sql);
    
    // 7. Convert INDEX to CREATE INDEX (PostgreSQL prefers separate statements)
    // We'll keep them inline for now, PostgreSQL supports this
    
    // 8. Clean up extra commas and whitespace
    $sql = preg_replace('/,\s*\)/m', "\n)", $sql);
    
    // 9. Add trigger for updated_at if exists
    if (preg_match('/updated_at\s+TIMESTAMP/i', $sql)) {
        // Extract table name
        if (preg_match('/CREATE\s+TABLE\s+(?:IF\s+NOT\s+EXISTS\s+)?(\w+)/i', $sql, $tableMatch)) {
            $tableName = $tableMatch[1];
            
            $trigger = "\n\n-- Trigger for updated_at\n";
            $trigger .= "CREATE OR REPLACE FUNCTION update_{$tableName}_updated_at()\n";
            $trigger .= "RETURNS TRIGGER AS \$\$\n";
            $trigger .= "BEGIN\n";
            $trigger .= "    NEW.updated_at = CURRENT_TIMESTAMP;\n";
            $trigger .= "    RETURN NEW;\n";
            $trigger .= "END;\n";
            $trigger .= "\$\$ LANGUAGE plpgsql;\n\n";
            $trigger .= "DROP TRIGGER IF EXISTS trigger_update_{$tableName}_updated_at ON $tableName;\n";
            $trigger .= "CREATE TRIGGER trigger_update_{$tableName}_updated_at\n";
            $trigger .= "    BEFORE UPDATE ON $tableName\n";
            $trigger .= "    FOR EACH ROW\n";
            $trigger .= "    EXECUTE FUNCTION update_{$tableName}_updated_at();\n";
            
            $sql .= $trigger;
        }
    }
    
    // 10. Convert TINYINT to SMALLINT
    $sql = preg_replace('/TINYINT/i', 'SMALLINT', $sql);
    
    // 11. Convert DATETIME to TIMESTAMP
    $sql = preg_replace('/DATETIME/i', 'TIMESTAMP', $sql);
    
    // Write converted file
    $outputFile = $outputDir . '/' . $filename;
    file_put_contents($outputFile, $sql);
    echo "✓ Converted: $filename\n";
}

echo "\n✅ Conversion complete! Files saved to: $outputDir\n";
echo "\nNext steps:\n";
echo "1. Review converted files in $outputDir\n";
echo "2. Run migrations against PostgreSQL database\n";
echo "3. Verify all tables are created successfully\n";
