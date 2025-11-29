<?php

class Request
{
    private $method;
    private $uri;
    private $get = [];
    private $post = [];
    private $files = [];
    private $server = [];
    private $headers = [];
    private $body;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        
        // Support _method override for REST operations (POST with _method=DELETE/PUT)
        if ($this->method === 'POST' && isset($_POST['_method'])) {
            $this->method = strtoupper($_POST['_method']);
        }
        
        $this->uri = $this->parseUri();
        $this->get = $_GET;
        $this->post = $_POST;
        $this->files = $_FILES;
        $this->server = $_SERVER;
        $this->headers = $this->parseHeaders();
        $this->body = file_get_contents('php://input');
    }

    private function parseUri()
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }

        return rtrim($uri, '/') ?: '/';
    }

    private function parseHeaders()
    {
        $headers = [];
        foreach ($_SERVER as $key => $value) {
            if (strpos($key, 'HTTP_') === 0) {
                // Store with uppercase and underscores for easy lookup
                $headerKey = strtoupper(substr($key, 5)); // Remove HTTP_ prefix
                $headers[$headerKey] = $value;
            }
        }
        return $headers;
    }

    public function method()
    {
        return $this->method;
    }

    public function uri()
    {
        return $this->uri;
    }

    public function get($key = null, $default = null)
    {
        if ($key === null) {
            return $this->get;
        }
        return $this->get[$key] ?? $default;
    }

    public function post($key = null, $default = null)
    {
        if ($key === null) {
            return $this->post;
        }
        return $this->post[$key] ?? $default;
    }

    public function input($key = null, $default = null)
    {
        $all = array_merge($this->get, $this->post);
        
        if ($key === null) {
            return $all;
        }
        
        return $all[$key] ?? $default;
    }

    public function file($key)
    {
        return $this->files[$key] ?? null;
    }

    public function hasFile($key)
    {
        return isset($this->files[$key]) && $this->files[$key]['error'] === UPLOAD_ERR_OK;
    }

    public function all()
    {
        return $this->input();
    }

    public function only($keys)
    {
        $result = [];
        $all = $this->input();
        
        foreach ((array) $keys as $key) {
            if (isset($all[$key])) {
                $result[$key] = $all[$key];
            }
        }
        
        return $result;
    }

    public function except($keys)
    {
        $all = $this->input();
        
        foreach ((array) $keys as $key) {
            unset($all[$key]);
        }
        
        return $all;
    }

    public function has($key)
    {
        $all = $this->input();
        return isset($all[$key]);
    }

    public function header($key, $default = null)
    {
        $key = strtoupper(str_replace('-', '_', $key));
        return $this->headers[$key] ?? $default;
    }

    public function isMethod($method)
    {
        return strtoupper($method) === $this->method;
    }

    public function isGet()
    {
        return $this->isMethod('GET');
    }

    public function isPost()
    {
        return $this->isMethod('POST');
    }

    public function isAjax()
    {
        return $this->header('X-REQUESTED-WITH') === 'XMLHttpRequest';
    }

    public function ip()
    {
        return $this->server['REMOTE_ADDR'] ?? null;
    }

    public function userAgent()
    {
        return $this->server['HTTP_USER_AGENT'] ?? null;
    }

    public function body()
    {
        return $this->body;
    }

    public function json()
    {
        return json_decode($this->body, true);
    }
}
