<?php
/**
 * PostgreSQL Migration Runner
 * Executes all PostgreSQL migrations in order
 */

echo "========================================\n";
echo "PostgreSQL Migration Runner\n";
echo "========================================\n\n";

// Get database credentials from environment
$host = getenv('DB_HOST') ?: 'localhost';
$port = getenv('DB_PORT') ?: '5432';
$dbname = getenv('DB_NAME') ?: 'scims_db';
$username = getenv('DB_USER') ?: 'postgres';
$password = getenv('DB_PASSWORD') ?: '';

// Create PostgreSQL connection
try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    
    echo "✓ Connected to PostgreSQL database at $host:$port/$dbname\n\n";
} catch (PDOException $e) {
    echo "✗ Database connection failed: " . $e->getMessage() . "\n";
    exit(1);
}

// Get all migration files
$migrationsDir = __DIR__ . '/migrations_postgresql';
$files = glob($migrationsDir . '/*.sql');
sort($files);

echo "Found " . count($files) . " migration files\n\n";

$successful = 0;
$failed = 0;

foreach ($files as $file) {
    $filename = basename($file);
    echo "Running: $filename ... ";
    
    try {
        $sql = file_get_contents($file);
        
        // Fix INDEX syntax for PostgreSQL (convert inline INDEX to CREATE INDEX)
        // Extract table name
        if (preg_match('/CREATE\s+TABLE\s+(?:IF\s+NOT\s+EXISTS\s+)?(\w+)/i', $sql, $tableMatch)) {
            $tableName = $tableMatch[1];
            
            // Extract all INDEX definitions
            $indexes = [];
            preg_match_all('/INDEX\s+(idx_\w+)\s+\((.*?)\)/i', $sql, $indexMatches, PREG_SET_ORDER);
            
            foreach ($indexMatches as $match) {
                $indexName = $match[1];
                $columns = $match[2];
                $indexes[] = "CREATE INDEX IF NOT EXISTS $indexName ON $tableName ($columns);";
            }
            
            // Remove inline INDEX definitions from CREATE TABLE
            $sql = preg_replace('/,?\s*INDEX\s+idx_\w+\s+\(.*?\)/i', '', $sql);
            
            // Append CREATE INDEX statements after the table creation
            if (!empty($indexes)) {
                // Find the position after the table creation but before triggers
                if (preg_match('/(CREATE TABLE.*?;)/s', $sql, $tableCreate)) {
                    $sql = str_replace(
                        $tableCreate[1],
                        $tableCreate[1] . "\n\n-- Indexes\n" . implode("\n", $indexes),
                        $sql
                    );
                }
            }
        }
        
        // Execute the SQL
        $pdo->exec($sql);
        
        echo "✓\n";
        $successful++;
    } catch (PDOException $e) {
        echo "✗\n";
        echo "   Error: " . $e->getMessage() . "\n";
        $failed++;
    }
}

echo "\n========================================\n";
echo "Migration Summary:\n";
echo "✓ Successful: $successful\n";
echo "✗ Failed: $failed\n";
echo "========================================\n";

if ($failed === 0) {
    echo "\n✅ All migrations completed successfully!\n";
    
    // Verify tables
    echo "\nVerifying tables...\n";
    $stmt = $pdo->query("SELECT tablename FROM pg_tables WHERE schemaname = 'public' ORDER BY tablename");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "Created " . count($tables) . " tables:\n";
    foreach ($tables as $table) {
        echo "  - $table\n";
    }
} else {
    echo "\n⚠️  Some migrations failed. Please review the errors above.\n";
    exit(1);
}
