<?php

define('BASE_PATH', __DIR__);
define('APP_PATH', BASE_PATH . '/app');
define('CONFIG_PATH', BASE_PATH . '/config');
define('ROUTES_PATH', BASE_PATH . '/routes');
define('PUBLIC_PATH', BASE_PATH . '/public');
define('DATABASE_PATH', BASE_PATH . '/database');

require_once APP_PATH . '/helpers/Env.php';
require_once APP_PATH . '/helpers/Config.php';
require_once APP_PATH . '/helpers/Request.php';
require_once APP_PATH . '/helpers/Response.php';
require_once APP_PATH . '/helpers/Router.php';
require_once APP_PATH . '/helpers/Database.php';
require_once APP_PATH . '/helpers/functions.php';
require_once APP_PATH . '/models/Model.php';

require_once APP_PATH . '/middlewares/AuthMiddleware.php';
require_once APP_PATH . '/middlewares/GuestMiddleware.php';
require_once APP_PATH . '/middlewares/RoleMiddleware.php';
require_once APP_PATH . '/middlewares/CsrfMiddleware.php';

spl_autoload_register(function ($class) {
    $paths = [
        APP_PATH . '/controllers/' . $class . '.php',
        APP_PATH . '/models/' . $class . '.php',
        APP_PATH . '/middlewares/' . $class . '.php',
        APP_PATH . '/helpers/' . $class . '.php',
    ];
    
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

$envPath = BASE_PATH . '/.env';
if (file_exists($envPath)) {
    Env::load($envPath);
} else {
    Env::load(BASE_PATH . '/.env.example');
}

date_default_timezone_set(Config::get('app.timezone', 'UTC'));

$sessionConfig = Config::get('app.session');
if ($sessionConfig) {
    ini_set('session.gc_maxlifetime', $sessionConfig['lifetime']);
    
    $isReplit = isset($_SERVER['REPL_SLUG']) || isset($_SERVER['REPLIT_DEV_DOMAIN']);
    $sessionParams = [
        'lifetime' => $sessionConfig['lifetime'],
        'path' => $sessionConfig['path'],
        'domain' => $sessionConfig['domain'],
        'httponly' => $sessionConfig['httponly'],
    ];
    
    if ($isReplit) {
        $sessionParams['secure'] = true;
        $sessionParams['samesite'] = 'None';
    } else {
        $sessionParams['secure'] = $sessionConfig['secure'];
        $sessionParams['samesite'] = $sessionConfig['samesite'];
    }
    
    session_set_cookie_params($sessionParams);
}

if (session_status() === PHP_SESSION_NONE) {
    session_name(Config::get('app.session.name', 'SCIMS_SESSION'));
    session_start();
}

set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    if (!(error_reporting() & $errno)) {
        return false;
    }
    
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});

set_exception_handler(function ($exception) {
    $debug = Config::get('app.debug', false);
    
    if (php_sapi_name() !== 'cli') {
        http_response_code(500);
    }
    
    if (php_sapi_name() === 'cli') {
        echo "\n❌ Error: " . $exception->getMessage() . "\n";
        echo "   File: " . $exception->getFile() . " (Line: " . $exception->getLine() . ")\n";
        if ($debug) {
            echo "\nStack trace:\n" . $exception->getTraceAsString() . "\n";
        }
    } elseif ($debug) {
        echo "<h1>Error</h1>";
        echo "<p><strong>Message:</strong> " . htmlspecialchars($exception->getMessage()) . "</p>";
        echo "<p><strong>File:</strong> " . htmlspecialchars($exception->getFile()) . " (Line: " . $exception->getLine() . ")</p>";
        echo "<pre>" . htmlspecialchars($exception->getTraceAsString()) . "</pre>";
    } else {
        echo "<h1>500 - Internal Server Error</h1>";
        echo "<p>Something went wrong. Please try again later.</p>";
    }
    
    error_log($exception->getMessage() . " in " . $exception->getFile() . " on line " . $exception->getLine());
});

register_shutdown_function(function () {
    $error = error_get_last();
    if ($error !== null && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        if (php_sapi_name() !== 'cli') {
            http_response_code(500);
        }
        
        $debug = Config::get('app.debug', false);
        
        if (php_sapi_name() === 'cli') {
            echo "\n❌ Fatal Error: " . $error['message'] . "\n";
            echo "   File: " . $error['file'] . " (Line: " . $error['line'] . ")\n";
        } elseif ($debug) {
            echo "<h1>Fatal Error</h1>";
            echo "<p><strong>Message:</strong> " . htmlspecialchars($error['message']) . "</p>";
            echo "<p><strong>File:</strong> " . htmlspecialchars($error['file']) . " (Line: " . $error['line'] . ")</p>";
        } else {
            echo "<h1>500 - Internal Server Error</h1>";
            echo "<p>Something went wrong. Please try again later.</p>";
        }
    }
});
