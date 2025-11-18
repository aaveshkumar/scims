<?php
/**
 * Create only the missing advanced tables (019-029)
 * Skip already existing tables
 */

$host = getenv('DB_HOST');
$port = getenv('DB_PORT') ?: '3306';
$dbname = trim(getenv('DB_NAME'));
$username = trim(getenv('DB_USER'));
$password = getenv('DB_PASSWORD');

echo "Creating missing advanced tables...\n\n";

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    
    // Only run migrations for missing tables (019-029)
    $migrationsToRun = [
        '019_create_library_tables.sql',
        '020_create_transport_tables.sql',
        '021_create_hostel_tables.sql',
        '022_create_inventory_tables.sql',
        '023_create_leave_tables.sql',
        '024_create_finance_extensions.sql',
        '025_create_departments.sql',
        '026_create_academic_extensions.sql',
        '027_create_advanced_lms.sql',
        '028_create_communication.sql',
        '029_create_system_admin.sql',
    ];
    
    $successful = 0;
    $failed = 0;
    
    foreach ($migrationsToRun as $filename) {
        echo "Running: $filename ... ";
        
        try {
            $sql = file_get_contents(__DIR__ . '/migrations/' . $filename);
            
            // Split by semicolon to handle multiple CREATE TABLE statements
            $statements = array_filter(array_map('trim', explode(';', $sql)));
            
            foreach ($statements as $statement) {
                if (!empty($statement)) {
                    try {
                        $pdo->exec($statement . ';');
                    } catch (PDOException $e) {
                        // Skip if table already exists
                        if (strpos($e->getMessage(), 'already exists') === false) {
                            throw $e;
                        }
                    }
                }
            }
            
            echo "✓\n";
            $successful++;
        } catch (PDOException $e) {
            echo "✗\n";
            echo "   Error: " . $e->getMessage() . "\n";
            $failed++;
        }
    }
    
    echo "\n========================================\n";
    echo "Summary:\n";
    echo "✓ Successful: $successful\n";
    echo "✗ Failed: $failed\n";
    echo "========================================\n";
    
    if ($failed === 0) {
        echo "\n✅ All missing tables created successfully!\n";
    }
    
    // Show all tables
    echo "\nFinal table count:\n";
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "Total tables: " . count($tables) . "\n";
    
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
}
