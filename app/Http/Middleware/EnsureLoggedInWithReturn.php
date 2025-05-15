<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class EnsureLoggedInWithReturn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {

            if ($request->isMethod('get')) {
                Session::put('url.intended', $request->fullUrl());
            } elseif ($request->isMethod('post')) {
                Session::put('post.action', [
                    'url' => $request->url(),
                    'data' => $request->all(),
                    'from' => url()->previous(),
                ]);
            }

            return redirect()->route('login');
        }
        if (Auth::user()->status == 'not_active') {
            Auth::guard('web')->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();
            return redirect('/login')->withErrors(['msg' => 'Tài khoản của bạn đã bị khóa.']);
        }
        return $next($request);
    }
}
