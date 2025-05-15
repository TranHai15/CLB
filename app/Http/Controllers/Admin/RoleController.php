<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function index()
    {
        // Lấy danh sách người dùng đã được gán vai trò
        $users = User::role(Role::all())->with(['roles', 'permissions'])->get();

        // Lấy danh sách người dùng chưa được gán vai trò
        $usersWithoutRoles = User::whereDoesntHave('roles')->get();

        // Lấy danh sách vai trò và quyền
        $roles = Role::all();
        $permissions = Permission::all();

        return view('admin.role.index', compact('users', 'usersWithoutRoles', 'roles', 'permissions'));
    }
    public function show($id)
    {    // Lấy user kèm theo roles và permissions trực tiếp
        $user = User::with(['roles', 'permissions'])->findOrFail($id);

        return view('admin.role.show', compact('user'));
    }
    public function search(Request $request)
    {
        $email = $request->query('email');

        if (!empty($email)) {
            $users = User::where('email', 'like', '%' . $email . '%')
                ->doesntHave('roles')
                ->get();

            return response()->json(['user' => $users], 200);
        }

        return response()->json(['users' => []], 200);
    }


    public function create()
    {
        $roles = Role::all();
        $usersWithoutRoles = User::whereDoesntHave('roles')->get();
        $permissions = Permission::all();
        return view('admin.role.create', compact('roles', 'usersWithoutRoles', 'permissions'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        try {
            DB::beginTransaction();

            $user = User::findOrFail($request->user_id);

            // Gán vai trò mới (radio button nên chỉ có 1 giá trị)
            $roleId = $request->roles[0];
            $role = Role::findOrFail($roleId); // lấy tên từ id

            $user->syncRoles([$role->name]);

            // Gán quyền nếu có

            if ($request->has('permissions')) {

                // Lấy tất cả Permission model theo ID

                $permissionModels = Permission::whereIn('id', $request->permissions)->get();

                // Trích ra mảng name
                $permissionNames = $permissionModels->pluck('name')->toArray();

                // Đồng bộ theo name
                $user->syncPermissions($permissionNames);
            } else {
                // Nếu không có permissions gửi lên, xóa hết
                $user->syncPermissions([]);
            }

            DB::commit();

            return redirect()->route('admin.roles.index')
                ->with('success', 'Phân quyền thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return view('admin.role.edit', compact('user', 'roles', 'permissions'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        try {
            DB::beginTransaction();

            // Cập nhật vai trò mới (radio button nên chỉ có 1 giá trị)

            $roleId = $request->roles[0];
            $role = Role::findOrFail($roleId); // lấy tên từ id

            $user->syncRoles([$role->name]);

            // Gán quyền nếu có

            if ($request->has('permissions')) {
                // xóa hết quyền cũ đi
                $user->syncPermissions([]);
                // Lấy tất cả Permission model theo ID
                $permissionModels = Permission::whereIn('id', $request->permissions)->get();

                // Trích ra mảng name
                $permissionNames = $permissionModels->pluck('name')->toArray();

                // Đồng bộ theo name
                $user->syncPermissions($permissionNames);
            } else {
                // Nếu không có permissions gửi lên, xóa hết
                $user->syncPermissions([]);
            }


            DB::commit();

            return redirect()->route('admin.roles.index')
                ->with('success', 'Cập nhật quyền thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(User $user)
    {
        try {
            DB::beginTransaction();

            // Xóa tất cả vai trò và quyền của người dùng
            $user->syncRoles([]);
            $user->syncPermissions([]);

            DB::commit();

            return redirect()->route('admin.roles.index')
                ->with('success', 'Xóa quyền thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
    public function role()
    {
        $roles = Role::all();
        return view('admin.role.role', compact('roles'));
    }
}
