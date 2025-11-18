<?php
/**
 * Verify and Create Roles & Departments Tables
 */

echo "========================================\n";
echo "Verifying Roles & Departments Tables\n";
echo "========================================\n\n";

$host = getenv('DB_HOST');
$port = getenv('DB_PORT');
$dbname = trim(getenv('DB_NAME'));
$username = trim(getenv('DB_USER'));
$password = getenv('DB_PASSWORD');

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    
    echo "✓ Connected to database\n\n";
} catch (PDOException $e) {
    echo "✗ Connection failed: " . $e->getMessage() . "\n";
    exit(1);
}

// Check and create roles table
echo "Checking roles table...\n";
try {
    $result = $pdo->query("SHOW TABLES LIKE 'roles'");
    if ($result->rowCount() > 0) {
        echo "  ✓ roles table exists\n";
        $count = $pdo->query("SELECT COUNT(*) as count FROM roles")->fetch();
        echo "    - {$count['count']} roles found\n";
    } else {
        echo "  ! roles table not found, creating...\n";
        $pdo->exec("
            CREATE TABLE roles (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(50) NOT NULL UNIQUE,
                display_name VARCHAR(100) NOT NULL,
                description TEXT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                INDEX idx_name (name)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
        echo "  ✓ roles table created\n";
    }
} catch (PDOException $e) {
    echo "  ✗ Error: " . $e->getMessage() . "\n";
}

// Check and create departments table
echo "\nChecking departments table...\n";
try {
    $result = $pdo->query("SHOW TABLES LIKE 'departments'");
    if ($result->rowCount() > 0) {
        echo "  ✓ departments table exists\n";
        $count = $pdo->query("SELECT COUNT(*) as count FROM departments")->fetch();
        echo "    - {$count['count']} departments found\n";
    } else {
        echo "  ! departments table not found, creating...\n";
        $pdo->exec("
            CREATE TABLE departments (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL UNIQUE,
                code VARCHAR(20) UNIQUE,
                description TEXT NULL,
                head_id INT UNSIGNED NULL,
                status VARCHAR(20) DEFAULT 'active',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                INDEX idx_name (name),
                INDEX idx_code (code),
                INDEX idx_status (status)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
        echo "  ✓ departments table created\n";
    }
} catch (PDOException $e) {
    echo "  ✗ Error: " . $e->getMessage() . "\n";
}

echo "\n========================================\n";
echo "Verification completed!\n";
echo "========================================\n";
