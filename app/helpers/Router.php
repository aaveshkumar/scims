<?php

class Router
{
    private $routes = [];
    private $middlewares = [];
    private $groupMiddleware = [];
    
    public function get($uri, $action, $middleware = [])
    {
        return $this->addRoute('GET', $uri, $action, $middleware);
    }

    public function post($uri, $action, $middleware = [])
    {
        return $this->addRoute('POST', $uri, $action, $middleware);
    }

    public function put($uri, $action, $middleware = [])
    {
        return $this->addRoute('PUT', $uri, $action, $middleware);
    }

    public function delete($uri, $action, $middleware = [])
    {
        return $this->addRoute('DELETE', $uri, $action, $middleware);
    }

    public function any($uri, $action, $middleware = [])
    {
        $methods = ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'];
        foreach ($methods as $method) {
            $this->addRoute($method, $uri, $action, $middleware);
        }
    }

    private function addRoute($method, $uri, $action, $middleware = [])
    {
        $uri = '/' . trim($uri, '/');
        if ($uri !== '/') {
            $uri = rtrim($uri, '/');
        }

        $middleware = array_merge($this->groupMiddleware, (array) $middleware);

        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'action' => $action,
            'middleware' => $middleware,
        ];

        return $this;
    }

    public function group($attributes, $callback)
    {
        $previousMiddleware = $this->groupMiddleware;
        
        if (isset($attributes['middleware'])) {
            $this->groupMiddleware = array_merge(
                $this->groupMiddleware,
                (array) $attributes['middleware']
            );
        }

        call_user_func($callback, $this);

        $this->groupMiddleware = $previousMiddleware;
    }

    public function registerMiddleware($name, $class)
    {
        $this->middlewares[$name] = $class;
    }

    public function dispatch(Request $request)
    {
        $method = $request->method();
        $uri = $request->uri();

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            $pattern = $this->convertToRegex($route['uri']);
            
            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches);
                
                $middlewareResult = $this->runMiddleware($route['middleware'], $request);
                
                if ($middlewareResult instanceof Response) {
                    return $middlewareResult;
                }

                return $this->callAction($route['action'], $matches, $request);
            }
        }

        return $this->notFound();
    }

    private function convertToRegex($uri)
    {
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $uri);
        return '#^' . $pattern . '$#';
    }

    private function runMiddleware($middlewares, $request)
    {
        foreach ($middlewares as $middleware) {
            if (strpos($middleware, ':') !== false) {
                list($name, $params) = explode(':', $middleware, 2);
                $params = explode(',', $params);
            } else {
                $name = $middleware;
                $params = [];
            }

            if (!isset($this->middlewares[$name])) {
                throw new Exception("Middleware not found: {$name}");
            }

            $middlewareClass = $this->middlewares[$name];
            $instance = new $middlewareClass();

            $result = $instance->handle($request, ...$params);

            if ($result instanceof Response) {
                return $result;
            }
        }

        return true;
    }

    private function callAction($action, $params, $request)
    {
        $params = array_filter($params, function($key) {
            return is_numeric($key);
        }, ARRAY_FILTER_USE_KEY);
        $params = array_values($params);
        
        if (is_callable($action)) {
            $response = call_user_func_array($action, array_merge([$request], $params));
        } elseif (is_string($action)) {
            list($controller, $method) = explode('@', $action);
            
            $controllerClass = $controller;
            
            if (!class_exists($controllerClass)) {
                throw new Exception("Controller not found: {$controllerClass}");
            }

            $instance = new $controllerClass();

            if (!method_exists($instance, $method)) {
                throw new Exception("Method not found: {$method} in {$controllerClass}");
            }

            $response = call_user_func_array([$instance, $method], array_merge([$request], $params));
        } else {
            throw new Exception("Invalid route action");
        }

        if (is_string($response)) {
            return (new Response())->html($response);
        }

        if (!$response instanceof Response) {
            return (new Response())->html((string) $response);
        }

        return $response;
    }

    private function notFound()
    {
        return (new Response())->html('
            <!DOCTYPE html>
            <html>
            <head>
                <title>404 - Not Found</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background: #f5f5f5;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        height: 100vh;
                        margin: 0;
                    }
                    .error-container {
                        text-align: center;
                        background: white;
                        padding: 40px;
                        border-radius: 10px;
                        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                    }
                    h1 {
                        font-size: 72px;
                        margin: 0;
                        color: #e74c3c;
                    }
                    p {
                        font-size: 18px;
                        color: #7f8c8d;
                    }
                    a {
                        color: #3498db;
                        text-decoration: none;
                    }
                </style>
            </head>
            <body>
                <div class="error-container">
                    <h1>404</h1>
                    <p>Page Not Found</p>
                    <a href="/">Go Home</a>
                </div>
            </body>
            </html>
        ', 404);
    }
}
