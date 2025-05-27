<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\Department;

class buildSeed extends Seeder
{
    public function run(): void
    {
        // Các danh mục mẫu
        $sampleCategories = [
            'HTML & CSS',
            'JavaScript cơ bản',
            'Frontend Frameworks & Libraries',
            'Backend & Server-side',
            'Cơ sở dữ liệu',
            'APIs & Microservices',
            'DevOps & Deployment',
            'An ninh Web',
            'Hiệu năng & Tối ưu hóa',
            'Testing & Debugging',
        ];

        // Các thẻ mẫu
        $sampleTags = [
            'HTML5',
            'CSS3',
            'Flexbox',
            'Grid',
            'Responsive Design',
            'ES6+',
            'DOM',
            'Event Handling',
            'Fetch API',
            'Async/Await',
            'React',
            'Vue.js',
            'Angular',
            'Svelte',
            'Node.js',
            'Express',
            'PHP',
            'Django',
            'Ruby on Rails',
            'MySQL',
            'PostgreSQL',
            'MongoDB',
            'Redis',
            'RESTful',
            'GraphQL',
            'JWT Authentication',
            'API Gateway',
            'Docker',
            'Kubernetes',
            'CI/CD',
            'Nginx',
            'AWS',
            'Azure',
            'GCP',
            'XSS',
            'CSRF',
            'SQL Injection',
            'OAuth2',
            'Lazy Loading',
            'Code Splitting',
            'Caching',
            'WebP',
            'Jest',
            'Mocha',
            'Cypress',
            'Chrome DevTools',
        ];

        // Lấy random một user để gán created_by và updated_by
        $userId = User::inRandomOrder()->value('id');

        // Tạo các danh mục
        foreach ($sampleCategories as $categoryName) {
            Category::create([
                'name'       => $categoryName,
                'slug'       => Str::slug($categoryName),
                'image_url'  => fake()->imageUrl(),
                'created_by' => $userId,
                'updated_by' => $userId,
            ]);
        }

        // Tạo các thẻ
        foreach ($sampleTags as $tagName) {
            Tag::create([
                'name'       => $tagName,
                'slug'       => Str::slug($tagName),
                'created_by' => $userId,
                'updated_by' => $userId,
            ]);
        }
        Department::insert([
            [
                'name' => 'Phòng Nhân sự',
                'slug' => Str::slug('Phòng Nhân sự'),
                'description' => 'Quản lý nhân sự và tuyển dụng.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Phòng Truyền thông',
                'slug' => Str::slug('Phòng Truyền thông'),
                'description' => 'Phụ trách truyền thông và quan hệ công chúng.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Phòng Tài nguyên',
                'slug' => Str::slug('Phòng Tài nguyên'),
                'description' => 'Quản lý tài nguyên và thiết bị.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
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

            // // Gán quyền giới hạn cho nhân viên
            // $limitedPermissions = $permissions->filter(function ($perm) {
            //     return str_contains($perm->name, 'read') || str_contains($perm->name, 'update');
            // });
            // $staffRole->syncPermissions($limitedPermissions);
        }

        // Tạo role admin và gán tất cả quyền
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $permissionMoney = Permission::firstOrCreate(['name' => 'money']);
        $quyTien = Role::firstOrCreate(['name' => 'head-phong-quy-tien']);

        $quyTien->givePermissionTo($permissionMoney);
        $admin->syncPermissions(Permission::all());
        // 1. Lấy danh sách role từ DB
        $roles = Role::pluck('name')->toArray();
        // Ví dụ: ['admin', 'head-truyen-thong', 'staff-truyen-thong', ...]

        // 2. Chuẩn bị map role → email mẫu
        //    Bạn chỉ việc sửa các email trong 3 mảng này
        $adminEmails = [
            'antrc2gamer@gmail.com',
            'hairobet15092005@gmail.com'
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
    //
}
