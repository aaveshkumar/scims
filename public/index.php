<?php

require_once dirname(__DIR__) . '/bootstrap.php';

$router = new Router();

require_once ROUTES_PATH . '/web.php';

$request = request();
$response = $router->dispatch($request);
$response->send();
