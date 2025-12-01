<?php

// Router script for PHP Development Server
$requested = $_SERVER['REQUEST_URI'];
$file = __DIR__ . $requested;

// If requesting a file from backups, serve it directly
if (strpos($requested, '/backups/') === 0 && is_file($file)) {
    return false;
}

// If requesting a real static file with extension, serve it
if (is_file($file) && preg_match('/\.\w+$/', $file)) {
    return false;
}

// For directories, check index files
if (is_dir($file)) {
    if (file_exists($file . '/index.html')) return false;
    if (file_exists($file . '/index.php')) return false;
}

// Route everything else through index.php
require __DIR__ . '/index.php';
