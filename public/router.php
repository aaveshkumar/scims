<?php

// Router script for PHP Development Server
// This file handles URL routing for the development server

$file = __DIR__ . $_SERVER['REQUEST_URI'];

// If the file/directory exists, serve it directly
if (is_file($file)) {
    return false;
}

if (is_dir($file)) {
    return false;
}

// Otherwise, route to index.php
require __DIR__ . '/index.php';
