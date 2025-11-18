<?php
// Check existing tables in MySQL database
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
    
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "Tables in database ($dbname):\n";
    echo "Total: " . count($tables) . "\n\n";
    
    if (!empty($tables)) {
        foreach ($tables as $table) {
            echo "  - $table\n";
        }
    } else {
        echo "  (no tables)\n";
    }
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
