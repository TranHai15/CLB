<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DepartmentSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
    }
}
