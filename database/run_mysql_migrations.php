<?php
/**
 * MySQL Migration Runner
 * Executes all MySQL migrations in order
 */

echo "========================================\n";
echo "MySQL Migration Runner\n";
echo "========================================\n\n";

// Get database credentials from environment
$host = getenv('DB_HOST') ?: 'localhost';
$port = getenv('DB_PORT') ?: '3306';
$dbname = trim(getenv('DB_NAME') ?: 'scims_db');
$username = trim(getenv('DB_USER') ?: 'root');
$password = getenv('DB_PASSWORD') ?: '';

echo "Connecting to: $username@$host:$port/$dbname\n\n";

// Create MySQL connection
try {
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    
    echo "✓ Connected to MySQL database\n\n";
} catch (PDOException $e) {
    echo "✗ Database connection failed: " . $e->getMessage() . "\n";
    exit(1);
}

// Get all migration files
$migrationsDir = __DIR__ . '/migrations';
$files = glob($migrationsDir . '/*.sql');
sort($files);

echo "Found " . count($files) . " migration files\n\n";

$successful = 0;
$failed = 0;
$errors = [];

foreach ($files as $file) {
    $filename = basename($file);
    echo "Running: $filename ... ";
    
    try {
        $sql = file_get_contents($file);
        
        // Execute the SQL (can contain multiple statements)
        $pdo->exec($sql);
        
        echo "✓\n";
        $successful++;
    } catch (PDOException $e) {
        echo "✗\n";
        $errorMsg = "   Error: " . $e->getMessage();
        echo "$errorMsg\n";
        $errors[] = "$filename: " . $e->getMessage();
        $failed++;
    }
}

echo "\n========================================\n";
echo "Migration Summary:\n";
echo "✓ Successful: $successful\n";
echo "✗ Failed: $failed\n";
echo "========================================\n";

if ($failed > 0) {
    echo "\n⚠️  Some migrations failed:\n";
    foreach ($errors as $error) {
        echo "  - $error\n";
    }
}

if ($failed === 0) {
    echo "\n✅ All migrations completed successfully!\n";
    
    // Verify tables
    echo "\nVerifying tables...\n";
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "Created " . count($tables) . " tables:\n";
    foreach ($tables as $table) {
        echo "  - $table\n";
    }
} else {
    echo "\n⚠️  Migration completed with some errors.\n";
}
