<?php

class GuestMiddleware
{
    public function handle($request, $next)
    {
        if (isAuth()) {
            return redirect('/dashboard');
        }

        return $next($request);
    }
}
