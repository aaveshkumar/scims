<?php
echo "========================================\n";
echo "PostgreSQL Migration Runner (Fixed)\n";
echo "========================================\n\n";

$host = getenv('DB_HOST') ?: 'localhost';
$port = getenv('DB_PORT') ?: '5432';
$dbname = getenv('DB_NAME') ?: 'scims_db';
$username = getenv('DB_USER') ?: 'postgres';
$password = getenv('DB_PASSWORD') ?: '';

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    
    echo "✓ Connected to PostgreSQL database\n\n";
} catch (PDOException $e) {
    echo "✗ Database connection failed: " . $e->getMessage() . "\n";
    exit(1);
}

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
        
        $sql = preg_replace('/,\s*INDEX\s+\w+\s+\([^)]+\)/i', '', $sql);
        $sql = preg_replace('/INDEX\s+\w+\s+\([^)]+\),?/i', '', $sql);
        
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
    
    $stmt = $pdo->query("SELECT tablename FROM pg_tables WHERE schemaname = 'public' ORDER BY tablename");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "\nCreated " . count($tables) . " tables:\n";
    foreach ($tables as $table) {
        echo "  - $table\n";
    }
} else {
    echo "\n⚠️  Some migrations failed. Please review the errors above.\n";
}

exit($failed > 0 ? 1 : 0);
