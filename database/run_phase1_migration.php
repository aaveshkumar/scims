<?php
// Run Phase 1 infrastructure migration

$host = getenv('DB_HOST');
$port = getenv('DB_PORT') ?: '3306';
$dbname = trim(getenv('DB_NAME'));
$username = trim(getenv('DB_USER'));
$password = getenv('DB_PASSWORD');

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    
    echo "Running Phase 1 infrastructure migration...\n";
    
    $sql = file_get_contents(__DIR__ . '/migrations/030_create_phase1_infrastructure.sql');
    $pdo->exec($sql);
    
    echo "✅ Phase 1 infrastructure tables created successfully!\n\n";
    
    // Verify tables
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "Total tables in database: " . count($tables) . "\n";
    
    // Check for new tables
    $newTables = ['notification_queue', 'event_log', 'school_calendar', 'holidays', 'announcements', 'hr_events', 'hr_event_participants'];
    echo "\nPhase 1 tables status:\n";
    foreach ($newTables as $table) {
        if (in_array($table, $tables)) {
            echo "  ✓ $table\n";
        } else {
            echo "  ✗ $table (not found)\n";
        }
    }
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
