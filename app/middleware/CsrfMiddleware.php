<?php

class CsrfMiddleware
{
    public function handle($request, $next)
    {
        if (in_array($request->method(), ['POST', 'PUT', 'DELETE'])) {
            $token = null;
            
            $token = $request->post('_token');
            
            if (!$token) {
                $token = $request->header('X-CSRF-TOKEN');
            }
            
            if (!$token && $request->isAjax()) {
                $jsonData = $request->json();
                if (isset($jsonData['_token'])) {
                    $token = $jsonData['_token'];
                }
            }
            
            if (!$token || !isset($_SESSION['_token']) || $token !== $_SESSION['_token']) {
                if ($request->isAjax()) {
                    header('Content-Type: application/json');
                    http_response_code(403);
                    echo json_encode(['success' => false, 'message' => 'CSRF token validation failed. Please refresh the page and try again.']);
                    exit;
                }
                
                flash('error', 'CSRF token validation failed. Please try again.');
                return back();
            }
        }
        
        return $next($request);
    }
}
