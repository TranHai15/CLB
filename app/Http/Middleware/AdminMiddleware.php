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
        if (Auth::check()) {
            $user = Auth::user();

            // Nếu là admin
            if ($user->hasRole('admin')) {
                return $next($request);
            }

            // Nếu là trưởng phòng hoặc nhân viên của bất kỳ phòng ban nào
            if ($user->hasAnyRole([
                'head-truyen-thong',
                'head-nhan-su',
                'head-tai-nguyen',
                'staff-truyen-thong',
                'staff-nhan-su',
                'staff-tai-nguyen',
            ])) {
                return $next($request);
            }
        }

        return redirect()->route('home')->with('error', 'Bạn không có quyền truy cập trang quản trị.');
    }
}
