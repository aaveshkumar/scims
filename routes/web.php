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
