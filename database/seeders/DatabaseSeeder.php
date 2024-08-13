<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'LongLD',
            'email' => 'longld0606@gmmail.com',
        ]);

        User::factory()->create([
            'name' => 'Le Dang Long',
            'email' => 'longld.8x@gmmail.com',
        ]);
    }
}
