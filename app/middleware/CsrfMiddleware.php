<?php

class CsrfMiddleware
{
    public function handle($request, $next)
    {
        if (in_array($request->method(), ['POST', 'PUT', 'DELETE'])) {
            $token = $request->post('_token');
            
            if (!$token || !isset($_SESSION['_token']) || $token !== $_SESSION['_token']) {
                flash('error', 'CSRF token validation failed. Please try again.');
                return back();
            }
        }
        
        return $next($request);
    }
}
