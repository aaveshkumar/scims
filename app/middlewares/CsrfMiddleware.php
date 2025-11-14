<?php

class CsrfMiddleware
{
    public function handle($request, $next)
    {
        if (in_array($request->method(), ['POST', 'PUT', 'DELETE', 'PATCH'])) {
            if ($request->isAjax()) {
                return $next($request);
            }

            $token = $request->post('_token');
            
            if (!$token || !$this->verifyToken($token)) {
                flash('error', 'CSRF token validation failed');
                return back();
            }
        }

        return $next($request);
    }

    private function verifyToken($token)
    {
        if (!isset($_SESSION['csrf_token'])) {
            return false;
        }

        return hash_equals($_SESSION['csrf_token'], $token);
    }

    public static function generateToken()
    {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['csrf_token'];
    }
}
