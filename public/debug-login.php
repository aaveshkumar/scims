<?php
require_once dirname(__DIR__) . '/bootstrap.php';

header('Content-Type: text/html; charset=utf-8');

echo "<h1>Debug Login Issue</h1>";
echo "<pre>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "=== POST REQUEST DETECTED ===\n\n";
    
    echo "POST Data:\n";
    print_r($_POST);
    
    echo "\n\nSESSION Data:\n";
    print_r($_SESSION);
    
    echo "\n\nCSRF Token in POST: " . ($_POST['_token'] ?? 'MISSING') . "\n";
    echo "CSRF Token in SESSION: " . ($_SESSION['_token'] ?? 'MISSING') . "\n";
    
    if (isset($_POST['_token']) && isset($_SESSION['_token'])) {
        echo "Tokens Match: " . ($_POST['_token'] === $_SESSION['_token'] ? 'YES' : 'NO') . "\n";
    }
    
    // Test actual login
    echo "\n\n=== ATTEMPTING LOGIN ===\n";
    
    $userModel = new User();
    $user = $userModel->findByEmail($_POST['email'] ?? '');
    
    echo "User found: " . ($user ? 'YES' : 'NO') . "\n";
    if ($user) {
        print_r($user);
        
        $passwordMatch = password_verify($_POST['password'] ?? '', $user['password']);
        echo "\nPassword match: " . ($passwordMatch ? 'YES' : 'NO') . "\n";
    }
    
} else {
    echo "=== GET REQUEST ===\n\n";
    echo "SESSION Data:\n";
    print_r($_SESSION);
}

echo "</pre>";

if (!isset($_SESSION['_token'])) {
    $_SESSION['_token'] = bin2hex(random_bytes(32));
}
?>

<form method="POST">
    <input type="hidden" name="_token" value="<?= $_SESSION['_token'] ?>">
    <input type="email" name="email" value="admin@school.com" placeholder="Email"><br><br>
    <input type="password" name="password" value="108d37f1de19b3bb" placeholder="Password"><br><br>
    <button type="submit">Test Login</button>
</form>
