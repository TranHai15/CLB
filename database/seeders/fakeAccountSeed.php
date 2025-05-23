<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class fakeAccountSeed extends Seeder
{
    public function run(): void
    {
        // 1. Lấy danh sách role từ DB
        $roles = Role::pluck('name')->toArray();
        // Ví dụ: ['admin', 'head-truyen-thong', 'staff-truyen-thong', ...]

        // 2. Chuẩn bị map role → email mẫu
        //    Bạn chỉ việc sửa các email trong 3 mảng này
        $adminEmails = [
            'antrc2gamer@gmail.com',
        ];

        $headEmails = [
            'head-truyen-thong@example.com',
            'head-nhan-su@example.com',
            'head-tai-nguyen@example.com',
        ];

        $staffEmails = [
            'staff-truyen-thong@example.com',
            'staff-nhan-su@example.com',
            'staff-tai-nguyen@example.com',
        ];

        // 3. Tạo user cho từng email (nếu chưa có), rồi gán role
        // --- Admin ---
        foreach ($adminEmails as $email) {
            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name'       => 'Administrator',
                    'slug'       => Str::slug($email, '-'),
                    'status'     => 'active',
                    'department_id' => null,
                ]
            );
            if (in_array('admin', $roles)) {
                $user->assignRole('admin');
            }
        }

        // --- Head per department ---
        foreach ($headEmails as $email) {
            // Lấy slug từ phần email trước @, ví dụ 'head-truyen-thong'
            $roleName = Str::before($email, '@');
            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name'          => 'Trưởng ' . Str::title(str_replace('head-', '', $roleName)),
                    'slug'          => Str::slug($email, '-'),
                    'status'        => 'active',
                    // map department_id nếu cần: lookup Department by slug
                    'department_id' => Department::where('slug', str_replace('head-', '', $roleName))->value('id'),
                ]
            );
            if (in_array($roleName, $roles)) {
                $user->assignRole($roleName);
            }
        }

        // --- Staff per department ---
        foreach ($staffEmails as $email) {
            $roleName = Str::before($email, '@'); // 'staff-nhan-su', etc.
            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name'          => 'Nhân viên ' . Str::title(str_replace('staff-', '', $roleName)),
                    'slug'          => Str::slug($email, '-'),
                    'status'        => 'active',
                    'department_id' => Department::where('slug', str_replace('staff-', '', $roleName))->value('id'),
                ]
            );
            if (in_array($roleName, $roles)) {
                $user->assignRole($roleName);
            }
        }

        $this->command->info('Đã tạo user & gán role tương ứng từ danh sách email.');
    }
}
