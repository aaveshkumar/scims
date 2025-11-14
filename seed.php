<?php

require_once __DIR__ . '/bootstrap.php';

$db = Database::getInstance();

echo "Starting database seeding...\n\n";

try {
    $adminRole = $db->fetchOne("SELECT id FROM roles WHERE name = 'admin'");
    
    if (!$adminRole) {
        throw new Exception("Admin role not found in database. Please run migrations first.");
    }
    
    $adminRoleId = $adminRole['id'];
    
    $existingAdmin = $db->fetchOne("SELECT id FROM users WHERE email = 'admin@school.com'");
    
    if ($existingAdmin) {
        echo "⏭️  Skipping: Admin user already exists (admin@school.com)\n\n";
        echo "⚠️  SECURITY WARNING: Please change the default password immediately!\n";
    } else {
        echo "👤 Creating default admin user...\n";
        
        $randomPassword = bin2hex(random_bytes(8));
        $hashedPassword = password_hash($randomPassword, PASSWORD_BCRYPT);
        
        $db->query("INSERT INTO users (first_name, last_name, email, phone, password, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())", [
            'Admin',
            'User',
            'admin@school.com',
            '1234567890',
            $hashedPassword,
            'active'
        ]);
        
        $userId = $db->lastInsertId();
        
        $db->query("INSERT INTO user_roles (user_id, role_id, created_at) VALUES (?, ?, NOW())", [
            $userId,
            $adminRoleId
        ]);
        
        echo "✅ Admin user created successfully\n";
        echo "   Email: admin@school.com\n";
        echo "   Password: {$randomPassword}\n\n";
        echo "⚠️  IMPORTANT: Save this password securely and change it after first login!\n";
    }
    
    echo "\n" . str_repeat("=", 50) . "\n";
    echo "Seeding Summary:\n";
    echo "✅ Default admin user ready\n";
    echo "📧 Login: admin@school.com\n";
    echo "⚠️  Change password on first login!\n";
    echo str_repeat("=", 50) . "\n";

} catch (Exception $e) {
    echo "\n❌ Seeding failed: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
    exit(1);
}
