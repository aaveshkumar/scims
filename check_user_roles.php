<?php
require_once __DIR__ . '/bootstrap.php';

$db = db();

echo "=== Checking for user_roles or role_user table ===\n";
try {
    $stmt = $db->query("SHOW TABLES LIKE '%role%'");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    foreach ($tables as $table) {
        echo "Found table: $table\n";
    }
    
    if (in_array('user_roles', $tables) || in_array('role_user', $tables)) {
        $tableName = in_array('user_roles', $tables) ? 'user_roles' : 'role_user';
        echo "\n=== $tableName TABLE SCHEMA ===\n";
        $stmt = $db->query("SHOW COLUMNS FROM $tableName");
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($columns as $col) {
            echo $col['Field'] . " (" . $col['Type'] . ")\n";
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
