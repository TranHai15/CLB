<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckDeptPermission
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string    $action     // ví dụ 'read','create','update','delete'
     * @param  string    $department // ví dụ 'phong-nhan-su'
     */
    public function handle(Request $request, Closure $next, string $action, string $department): Response
    {
        $user = $request->user();

        // 1) Nếu là admin → cho qua
        if ($user->hasRole('admin')) {
            return $next($request);
        }

        // 2) Kiểm tra permission cụ thể
        $permName = "{$action}-{$department}";
        if ($user->hasPermissionTo($permName)) {
            return $next($request);
        }

        // 3) Không hợp lệ → 403
        abort(403, 'Bạn không có quyền thực hiện thao tác này.');
    }
}
