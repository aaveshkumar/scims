<?php

$router->get('/', function($request) {
    return view('welcome');
});

$router->get('/test', function($request) {
    return responseJSON([
        'message' => 'Router is working!',
        'method' => $request->method(),
        'uri' => $request->uri(),
        'timestamp' => date('Y-m-d H:i:s')
    ]);
});

$router->get('/user/{id}', function($request, $id) {
    return responseJSON([
        'user_id' => $id,
        'message' => 'Dynamic routing works!'
    ]);
});

$router->get('/db-test', function($request) {
    try {
        $database = db();
        $pdo = $database->getPdo();
        
        $version = $pdo->query('SELECT VERSION() as version')->fetch();
        
        return responseJSON([
            'status' => 'success',
            'message' => 'Database connection successful!',
            'mysql_version' => $version['version'] ?? 'Unknown',
            'database' => Config::get('database.database'),
            'host' => Config::get('database.host')
        ]);
    } catch (Exception $e) {
        return responseJSON([
            'status' => 'error',
            'message' => 'Database connection failed',
            'error' => $e->getMessage()
        ], 500);
    }
});
