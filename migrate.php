<?php

require_once __DIR__ . '/bootstrap.php';

$db = Database::getInstance();

$migrationsPath = __DIR__ . '/database/migrations';
$migrationFiles = glob($migrationsPath . '/*.sql');

sort($migrationFiles);

echo "Starting migrations...\n\n";

try {
    $db->query("CREATE TABLE IF NOT EXISTS migrations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        migration VARCHAR(255) NOT NULL UNIQUE,
        executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    $executedMigrations = $db->fetchAll("SELECT migration FROM migrations");
    $executedMigrationNames = array_column($executedMigrations, 'migration');

    $successCount = 0;
    $skippedCount = 0;

    foreach ($migrationFiles as $file) {
        $migrationName = basename($file);
        
        if (in_array($migrationName, $executedMigrationNames)) {
            echo "⏭️  Skipping: {$migrationName} (already executed)\n";
            $skippedCount++;
            continue;
        }

        echo "⚙️  Running: {$migrationName}... ";
        
        $sql = file_get_contents($file);
        
        try {
            $db->getPdo()->exec($sql);
            $db->query("INSERT INTO migrations (migration) VALUES (?)", [$migrationName]);
        } catch (PDOException $e) {
            throw new Exception("Migration {$migrationName} failed: " . $e->getMessage());
        }
        
        echo "✅ Done\n";
        $successCount++;
    }

    echo "\n" . str_repeat("=", 50) . "\n";
    echo "Migration Summary:\n";
    echo "✅ Executed: {$successCount}\n";
    echo "⏭️  Skipped: {$skippedCount}\n";
    echo "📊 Total: " . count($migrationFiles) . "\n";
    echo str_repeat("=", 50) . "\n";

} catch (Exception $e) {
    echo "\n❌ Migration failed: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
    exit(1);
}
