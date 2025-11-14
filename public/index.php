<?php

session_start();

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
define('CONFIG_PATH', BASE_PATH . '/config');
define('ROUTES_PATH', BASE_PATH . '/routes');
define('PUBLIC_PATH', BASE_PATH . '/public');

echo "<!DOCTYPE html>
<html>
<head>
    <title>SCIMS - School Management System</title>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
</head>
<body>
    <div style='text-align: center; margin-top: 100px; font-family: Arial, sans-serif;'>
        <h1>School/College/Institution Management System (SCIMS)</h1>
        <p>Core PHP 8+ Custom MVC Framework</p>
        <p style='color: green; font-weight: bold;'>✓ Step 1 Complete: Folder structure initialized</p>
        <p style='color: gray; font-size: 12px;'>Next: Config loader + env handling</p>
    </div>
</body>
</html>";
