<?php

namespace Database\Factories;

use App\Models\File;
use Illuminate\Database\Eloquent\Factories\Factory;

class FileMetadataFactory extends Factory
{
    public function definition(): array
    {
        return [
            'file_id' => File::factory(),
            'mime_type' => fake()->mimeType(),
            'original_name' => fake()->word() . '.' . fake()->fileExtension(),
            'file_size' => fake()->numberBetween(1000, 10000000),
        ];
    }
}
