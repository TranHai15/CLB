<?php



namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

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
            // Lấy tất cả role bắt đầu với "head-" hoặc "staff-" từ bảng roles
            $roles = Role::where('name', 'like', '%head-%')
                ->orWhere('name', 'like', '%staff-%')
                ->get()
                ->pluck('name')
                ->toArray(); // Lấy tên các role

            // Kiểm tra xem user có bất kỳ role nào trong danh sách trên không
            if ($user->hasAnyRole($roles)) {
                return $next($request);
            }
        }

        return redirect()->route('home')->with('error', 'Bạn không có quyền truy cập trang quản trị.');
    }
}
