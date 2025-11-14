<?php

class Response
{
    private $content;
    private $statusCode = 200;
    private $headers = [];

    public function __construct($content = '', $statusCode = 200, $headers = [])
    {
        $this->content = $content;
        $this->statusCode = $statusCode;
        $this->headers = $headers;
    }

    public function send()
    {
        http_response_code($this->statusCode);

        foreach ($this->headers as $name => $value) {
            header("{$name}: {$value}");
        }

        echo $this->content;
        
        if (function_exists('fastcgi_finish_request')) {
            fastcgi_finish_request();
        }
    }

    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function setHeader($name, $value)
    {
        $this->headers[$name] = $value;
        return $this;
    }

    public function json($data, $statusCode = 200)
    {
        $this->statusCode = $statusCode;
        $this->headers['Content-Type'] = 'application/json';
        $this->content = json_encode($data);
        return $this;
    }

    public function redirect($url, $statusCode = 302)
    {
        $this->statusCode = $statusCode;
        $this->headers['Location'] = $url;
        $this->content = '';
        return $this;
    }

    public function back()
    {
        $referer = $_SERVER['HTTP_REFERER'] ?? '/';
        return $this->redirect($referer);
    }

    public function html($html, $statusCode = 200)
    {
        $this->statusCode = $statusCode;
        $this->headers['Content-Type'] = 'text/html; charset=UTF-8';
        $this->content = $html;
        return $this;
    }

    public function view($path, $data = [], $statusCode = 200)
    {
        $this->statusCode = $statusCode;
        $this->headers['Content-Type'] = 'text/html; charset=UTF-8';
        
        $viewPath = APP_PATH . '/views/' . str_replace('.', '/', $path) . '.php';
        
        if (!file_exists($viewPath)) {
            throw new Exception("View not found: {$path}");
        }

        extract($data);
        
        ob_start();
        require $viewPath;
        $this->content = ob_get_clean();
        
        return $this;
    }

    public function download($filePath, $filename = null)
    {
        if (!file_exists($filePath)) {
            throw new Exception("File not found: {$filePath}");
        }

        $filename = $filename ?? basename($filePath);
        
        $this->headers['Content-Type'] = 'application/octet-stream';
        $this->headers['Content-Disposition'] = 'attachment; filename="' . $filename . '"';
        $this->headers['Content-Length'] = filesize($filePath);
        
        $this->content = file_get_contents($filePath);
        
        return $this;
    }
}
