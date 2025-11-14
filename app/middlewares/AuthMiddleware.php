<?php

class AuthMiddleware
{
    public function handle($request, $next)
    {
        if (!isAuth()) {
            if ($request->isAjax()) {
                return responseJSON([
                    'success' => false,
                    'message' => 'Unauthorized. Please login.'
                ], 401);
            }
            
            flash('error', 'Please login to continue');
            return redirect('/login');
        }

        return $next($request);
    }
}
