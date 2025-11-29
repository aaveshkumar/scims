<?php

class CsrfMiddleware
{
    public function handle($request, $next)
    {
        if (in_array($request->method(), ['POST', 'PUT', 'DELETE'])) {
            $token = null;
            
            // For AJAX requests, check JSON body first
            if ($request->isAjax()) {
                $jsonData = $request->json();
                if (is_array($jsonData) && isset($jsonData['_token'])) {
                    $token = $jsonData['_token'];
                }
            }
            
            // Check POST data
            if (!$token) {
                $token = $request->post('_token');
            }
            
            // Check header
            if (!$token) {
                $token = $request->header('X-CSRF-TOKEN');
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
