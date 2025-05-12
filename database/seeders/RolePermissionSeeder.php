<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $actions = ['create', 'read', 'update', 'delete'];
        $departments = Department::all();

        foreach ($departments as $dept) {
            $slug = $dept->slug;

            // Tạo các quyền
            foreach ($actions as $action) {
                Permission::firstOrCreate(['name' => "{$action}-{$slug}"]);
            }

            // Tạo roles
            $headRole = Role::firstOrCreate(['name' => "head-{$slug}"]);
            $staffRole = Role::firstOrCreate(['name' => "staff-{$slug}"]);

            // Gán quyền cho trưởng phòng
            $permissions = Permission::where('name', 'like', "%-{$slug}")->get();
            $headRole->syncPermissions($permissions);

            // Gán quyền giới hạn cho nhân viên
            $limitedPermissions = $permissions->filter(function ($perm) {
                return str_contains($perm->name, 'read') || str_contains($perm->name, 'update');
            });
            $staffRole->syncPermissions($limitedPermissions);
        }

        // Tạo role admin và gán tất cả quyền
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions(Permission::all());
    }
}
