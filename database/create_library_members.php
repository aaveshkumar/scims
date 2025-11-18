<?php
/**
 * Create library_members table
 */

echo "========================================\n";
echo "Creating library_members Table\n";
echo "========================================\n\n";

$host = getenv('DB_HOST');
$port = getenv('DB_PORT');
$dbname = trim(getenv('DB_NAME'));
$username = trim(getenv('DB_USER'));
$password = getenv('DB_PASSWORD');

echo "Connecting to: $username@$host:$port/$dbname\n\n";

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    
    echo "✓ Connected to MySQL database\n\n";
} catch (PDOException $e) {
    echo "✗ Connection failed: " . $e->getMessage() . "\n";
    exit(1);
}

echo "Creating library_members table...\n";
try {
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS library_members (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id INT UNSIGNED NOT NULL,
            member_number VARCHAR(50) UNIQUE NOT NULL,
            membership_type VARCHAR(50) DEFAULT 'student',
            join_date DATE NOT NULL,
            expiry_date DATE,
            max_books INT DEFAULT 3,
            status VARCHAR(20) DEFAULT 'active',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_user (user_id),
            INDEX idx_member_number (member_number),
            INDEX idx_status (status)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    
    echo "  ✓ library_members table created successfully\n";
} catch (PDOException $e) {
    echo "  ✗ Error: " . $e->getMessage() . "\n";
    exit(1);
}

echo "\n========================================\n";
echo "Table creation completed!\n";
echo "========================================\n";
