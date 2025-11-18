<?php
/**
 * Fix Module Tables - Create missing tables without foreign keys
 */

echo "========================================\n";
echo "Fixing Module Tables\n";
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

// Library Tables
echo "Creating Library tables...\n";
try {
    // Books table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS books (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            isbn VARCHAR(20) UNIQUE,
            title VARCHAR(255) NOT NULL,
            author VARCHAR(255) NOT NULL,
            publisher VARCHAR(255),
            publication_year INT UNSIGNED,
            category VARCHAR(100),
            total_copies INT DEFAULT 1,
            available_copies INT DEFAULT 1,
            location VARCHAR(100),
            price DECIMAL(10,2),
            description TEXT,
            cover_image VARCHAR(255),
            status VARCHAR(20) DEFAULT 'active',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_isbn (isbn),
            INDEX idx_title (title),
            INDEX idx_category (category),
            INDEX idx_status (status)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    
    // Book Issues table (without foreign keys for now)
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS book_issues (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            book_id INT UNSIGNED NOT NULL,
            user_id INT UNSIGNED NOT NULL,
            issue_date DATE NOT NULL,
            due_date DATE NOT NULL,
            return_date DATE,
            status VARCHAR(20) DEFAULT 'issued',
            fine_amount DECIMAL(10,2) DEFAULT 0,
            fine_paid BOOLEAN DEFAULT FALSE,
            remarks TEXT,
            issued_by INT UNSIGNED,
            returned_to INT UNSIGNED,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_user (user_id),
            INDEX idx_book (book_id),
            INDEX idx_status (status),
            INDEX idx_issue_date (issue_date)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    
    echo "  ✓ Books and Book Issues tables created\n";
} catch (PDOException $e) {
    echo "  ✗ Error: " . $e->getMessage() . "\n";
}

// Transport Tables
echo "Creating Transport tables...\n";
try {
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS vehicles (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            vehicle_number VARCHAR(50) UNIQUE NOT NULL,
            vehicle_type VARCHAR(50),
            model VARCHAR(100),
            manufacturer VARCHAR(100),
            year INT,
            capacity INT,
            fuel_type VARCHAR(50),
            registration_date DATE,
            insurance_expiry DATE,
            fitness_expiry DATE,
            status VARCHAR(20) DEFAULT 'active',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_vehicle_number (vehicle_number),
            INDEX idx_status (status)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS routes (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            route_name VARCHAR(100) NOT NULL,
            route_number VARCHAR(50) UNIQUE,
            start_point VARCHAR(255),
            end_point VARCHAR(255),
            distance DECIMAL(10,2),
            fare DECIMAL(10,2),
            vehicle_id INT UNSIGNED,
            driver_id INT UNSIGNED,
            status VARCHAR(20) DEFAULT 'active',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_route_number (route_number),
            INDEX idx_status (status)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS route_stops (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            route_id INT UNSIGNED NOT NULL,
            stop_name VARCHAR(255) NOT NULL,
            stop_order INT NOT NULL,
            pickup_time TIME,
            drop_time TIME,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_route (route_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS transport_assignments (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            student_id INT UNSIGNED NOT NULL,
            route_id INT UNSIGNED NOT NULL,
            stop_id INT UNSIGNED,
            start_date DATE NOT NULL,
            end_date DATE,
            status VARCHAR(20) DEFAULT 'active',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_student (student_id),
            INDEX idx_route (route_id),
            INDEX idx_status (status)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    
    echo "  ✓ Transport tables created\n";
} catch (PDOException $e) {
    echo "  ✗ Error: " . $e->getMessage() . "\n";
}

// Hostel Tables
echo "Creating Hostel tables...\n";
try {
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS hostels (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            hostel_type VARCHAR(50),
            address TEXT,
            warden_id INT UNSIGNED,
            total_rooms INT DEFAULT 0,
            occupied_rooms INT DEFAULT 0,
            status VARCHAR(20) DEFAULT 'active',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_status (status)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS hostel_rooms (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            hostel_id INT UNSIGNED NOT NULL,
            room_number VARCHAR(50) NOT NULL,
            room_type VARCHAR(50),
            capacity INT DEFAULT 1,
            occupied_beds INT DEFAULT 0,
            floor_number INT,
            room_fee DECIMAL(10,2),
            amenities TEXT,
            status VARCHAR(20) DEFAULT 'available',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_hostel (hostel_id),
            INDEX idx_status (status)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS hostel_residents (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            student_id INT UNSIGNED NOT NULL,
            hostel_id INT UNSIGNED NOT NULL,
            room_id INT UNSIGNED NOT NULL,
            admission_date DATE NOT NULL,
            checkout_date DATE,
            guardian_contact VARCHAR(20),
            emergency_contact VARCHAR(20),
            status VARCHAR(20) DEFAULT 'active',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_student (student_id),
            INDEX idx_hostel (hostel_id),
            INDEX idx_room (room_id),
            INDEX idx_status (status)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    
    echo "  ✓ Hostel tables created\n";
} catch (PDOException $e) {
    echo "  ✗ Error: " . $e->getMessage() . "\n";
}

// Inventory Tables
echo "Creating Inventory tables...\n";
try {
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS assets (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            asset_name VARCHAR(255) NOT NULL,
            asset_code VARCHAR(100) UNIQUE NOT NULL,
            category VARCHAR(100),
            purchase_date DATE,
            purchase_cost DECIMAL(10,2),
            current_value DECIMAL(10,2),
            location VARCHAR(255),
            assigned_to INT UNSIGNED,
            condition_status VARCHAR(50) DEFAULT 'good',
            status VARCHAR(20) DEFAULT 'active',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_asset_code (asset_code),
            INDEX idx_category (category),
            INDEX idx_status (status)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS stock_items (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            item_name VARCHAR(255) NOT NULL,
            item_code VARCHAR(100) UNIQUE NOT NULL,
            category VARCHAR(100),
            unit VARCHAR(50),
            quantity INT DEFAULT 0,
            min_stock_level INT DEFAULT 0,
            unit_price DECIMAL(10,2),
            location VARCHAR(255),
            status VARCHAR(20) DEFAULT 'active',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_item_code (item_code),
            INDEX idx_category (category),
            INDEX idx_status (status)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    
    echo "  ✓ Inventory tables created\n";
} catch (PDOException $e) {
    echo "  ✗ Error: " . $e->getMessage() . "\n";
}

// Verify tables
echo "\n========================================\n";
echo "Verifying tables...\n";
$stmt = $pdo->query("SHOW TABLES");
$tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

$moduleTables = ['books', 'book_issues', 'vehicles', 'routes', 'hostels', 'hostel_rooms', 'assets', 'stock_items', 'fee_templates', 'payroll', 'assignments', 'quizzes'];

echo "\nModule Tables Status:\n";
foreach ($moduleTables as $table) {
    $exists = in_array($table, $tables) ? '✓ EXISTS' : '✗ MISSING';
    echo "  $exists: $table\n";
}

echo "\n✅ Table creation complete!\n";
echo "Total tables in database: " . count($tables) . "\n";
