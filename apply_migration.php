<?php
require_once 'bootstrap.php';

// Get the actual connection
$db = Database::getInstance();

// Check if it's the connection object directly
$stmt = $db->prepare("ALTER TABLE users ADD COLUMN IF NOT EXISTS temporary_password_plaintext VARCHAR(255) NULL");
$stmt->execute();

$result = $db->query("PRAGMA table_info(users)");
$cols = $result->fetchAll(PDO::FETCH_ASSOC);

$found = false;
foreach ($cols as $col) {
    if ($col['name'] === 'temporary_password_plaintext') {
        $found = true;
        break;
    }
}

echo $found ? "✅ Column added\n" : "❌ Column not found\n";
