<?php

require_once dirname(__DIR__) . '/bootstrap.php';

$router = new Router();

$router->registerMiddleware('auth', AuthMiddleware::class);
$router->registerMiddleware('guest', GuestMiddleware::class);
$router->registerMiddleware('role', RoleMiddleware::class);
$router->registerMiddleware('csrf', CsrfMiddleware::class);

require_once ROUTES_PATH . '/web.php';

$request = request();
$response = $router->dispatch($request);
$response->send();
