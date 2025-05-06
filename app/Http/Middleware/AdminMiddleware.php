<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated and is an admin
        if (Auth::check()) {
            return $next($request);
        }

        // Redirect to home page if not admin
        return redirect()->route('home')->with('error', 'Bạn không có quyền truy cập trang quản trị.');
    }
}
