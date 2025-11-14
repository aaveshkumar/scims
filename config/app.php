<?php

return [
    'name' => Env::get('APP_NAME', 'School Management System'),
    'url' => Env::get('APP_URL', 'http://localhost'),
    'env' => Env::get('APP_ENV', 'production'),
    'debug' => Env::get('APP_DEBUG', 'false') === 'true',
    
    'session' => [
        'name' => Env::get('SESSION_NAME', 'SCIMS_SESSION'),
        'lifetime' => (int) Env::get('SESSION_LIFETIME', 3600),
        'path' => '/',
        'domain' => '',
        'secure' => false,
        'httponly' => true,
        'samesite' => 'Lax',
    ],

    'timezone' => Env::get('APP_TIMEZONE', 'UTC'),
    
    'uploads' => [
        'path' => PUBLIC_PATH . '/uploads',
        'max_size' => 5 * 1024 * 1024,
        'allowed_types' => ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx'],
    ],
];
