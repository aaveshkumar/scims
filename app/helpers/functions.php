<?php

function db()
{
    return Database::getInstance();
}

function request()
{
    static $request = null;
    
    if ($request === null) {
        $request = new Request();
    }
    
    return $request;
}

function response($content = '', $statusCode = 200)
{
    return new Response($content, $statusCode);
}

function view($path, $data = [], $statusCode = 200)
{
    return (new Response())->view($path, $data, $statusCode);
}

function redirect($url, $statusCode = 302)
{
    return (new Response())->redirect($url, $statusCode);
}

function back()
{
    return (new Response())->back();
}

function responseJSON($data, $statusCode = 200)
{
    return (new Response())->json($data, $statusCode);
}

function old($key, $default = '')
{
    return $_SESSION['_old'][$key] ?? $default;
}

function session($key = null, $value = null)
{
    if ($key === null) {
        return $_SESSION;
    }
    
    if ($value === null) {
        return $_SESSION[$key] ?? null;
    }
    
    $_SESSION[$key] = $value;
    return $value;
}

function flash($key, $value = null)
{
    if ($value === null) {
        $data = $_SESSION['_flash'][$key] ?? null;
        unset($_SESSION['_flash'][$key]);
        return $data;
    }
    
    $_SESSION['_flash'][$key] = $value;
}

function csrf_token()
{
    if (!isset($_SESSION['_token'])) {
        $_SESSION['_token'] = bin2hex(random_bytes(32));
    }
    
    return $_SESSION['_token'];
}

function csrf_field()
{
    $token = csrf_token();
    return '<input type="hidden" name="_token" value="' . $token . '">';
}

function verify_csrf_token($token)
{
    return isset($_SESSION['_token']) && hash_equals($_SESSION['_token'], $token);
}

function validate($data, $rules)
{
    $errors = [];
    
    foreach ($rules as $field => $ruleSet) {
        $ruleArray = is_string($ruleSet) ? explode('|', $ruleSet) : $ruleSet;
        $value = $data[$field] ?? null;
        
        foreach ($ruleArray as $rule) {
            $ruleName = $rule;
            $ruleParam = null;
            
            if (strpos($rule, ':') !== false) {
                list($ruleName, $ruleParam) = explode(':', $rule, 2);
            }
            
            switch ($ruleName) {
                case 'required':
                    if (empty($value) && $value !== '0') {
                        $errors[$field][] = ucfirst($field) . ' is required.';
                    }
                    break;
                    
                case 'email':
                    if (!empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $errors[$field][] = ucfirst($field) . ' must be a valid email address.';
                    }
                    break;
                    
                case 'min':
                    if (!empty($value) && strlen($value) < $ruleParam) {
                        $errors[$field][] = ucfirst($field) . " must be at least {$ruleParam} characters.";
                    }
                    break;
                    
                case 'max':
                    if (!empty($value) && strlen($value) > $ruleParam) {
                        $errors[$field][] = ucfirst($field) . " must not exceed {$ruleParam} characters.";
                    }
                    break;
                    
                case 'numeric':
                    if (!empty($value) && !is_numeric($value)) {
                        $errors[$field][] = ucfirst($field) . ' must be a number.';
                    }
                    break;
                    
                case 'alpha':
                    if (!empty($value) && !ctype_alpha($value)) {
                        $errors[$field][] = ucfirst($field) . ' must contain only letters.';
                    }
                    break;
                    
                case 'alphanumeric':
                    if (!empty($value) && !ctype_alnum($value)) {
                        $errors[$field][] = ucfirst($field) . ' must contain only letters and numbers.';
                    }
                    break;
                    
                case 'in':
                    $allowedValues = explode(',', $ruleParam);
                    if (!empty($value) && !in_array($value, $allowedValues)) {
                        $errors[$field][] = ucfirst($field) . ' must be one of: ' . implode(', ', $allowedValues);
                    }
                    break;
            }
        }
    }
    
    if (!empty($errors)) {
        $_SESSION['_errors'] = $errors;
        $_SESSION['_old'] = $data;
        return false;
    }
    
    unset($_SESSION['_errors']);
    unset($_SESSION['_old']);
    return true;
}

function errors($field = null)
{
    $errors = $_SESSION['_errors'] ?? [];
    
    if ($field === null) {
        return $errors;
    }
    
    return $errors[$field] ?? [];
}

function hasErrors($field = null)
{
    if ($field === null) {
        return !empty($_SESSION['_errors']);
    }
    
    return isset($_SESSION['_errors'][$field]);
}

function asset($path)
{
    $baseUrl = Config::get('app.url');
    return $baseUrl . '/assets/' . ltrim($path, '/');
}

function url($path = '')
{
    $baseUrl = Config::get('app.url');
    return $baseUrl . '/' . ltrim($path, '/');
}

function dd(...$vars)
{
    echo '<pre style="background: #1e1e1e; color: #fff; padding: 20px; border-radius: 5px; overflow: auto;">';
    foreach ($vars as $var) {
        var_dump($var);
    }
    echo '</pre>';
    die();
}

function e($value)
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function auth()
{
    return $_SESSION['user'] ?? null;
}

function isAuth()
{
    return isset($_SESSION['user']);
}

function hasRole($role)
{
    if (!isAuth()) {
        return false;
    }
    
    $user = auth();
    return isset($user['role']) && $user['role'] === $role;
}

function uploadFile($file, $directory = 'uploads')
{
    if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }

    $uploadPath = PUBLIC_PATH . '/' . $directory;
    
    if (!is_dir($uploadPath)) {
        mkdir($uploadPath, 0755, true);
    }

    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '_' . time() . '.' . $extension;
    $destination = $uploadPath . '/' . $filename;

    if (move_uploaded_file($file['tmp_name'], $destination)) {
        return '/' . $directory . '/' . $filename;
    }

    return false;
}
