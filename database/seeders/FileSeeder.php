<?php

namespace Database\Seeders;

use App\Models\File;
use App\Models\User;
use Illuminate\Database\Seeder;

class FileSeeder extends Seeder
{
    public function run(): void
    {


        File::factory(3)->create();
    }
}
