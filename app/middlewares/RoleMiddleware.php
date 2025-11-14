<?php

class RoleMiddleware
{
    public function handle($request, $next, ...$roles)
    {
        if (!isAuth()) {
            flash('error', 'Please login to continue');
            return redirect('/login');
        }

        if (empty($roles)) {
            return $next($request);
        }

        $hasRole = false;
        foreach ($roles as $role) {
            if (hasRole($role)) {
                $hasRole = true;
                break;
            }
        }

        if (!$hasRole) {
            if ($request->isAjax()) {
                return responseJSON([
                    'success' => false,
                    'message' => 'Access denied. Insufficient permissions.'
                ], 403);
            }
            
            flash('error', 'Access denied. You do not have permission to access this page.');
            return redirect('/dashboard');
        }

        return $next($request);
    }
}
