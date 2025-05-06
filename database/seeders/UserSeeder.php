<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'account_type' => 'club_member',
            'status' => 'active'
        ]);

        // Create regular users
        User::factory(5)->create();
    }
}
