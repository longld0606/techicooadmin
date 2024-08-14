<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        DB::table('users')->insert([
            'name' => 'David Hoang Tran',
            'email' => 'dht.docs@gmail.com',
            'password' => bcrypt('123456'),
            'type' => 'admin'
        ]);
        DB::table('users')->insert([
            'name' => 'Lê Đăng Long',
            'email' => 'longld0606@gmail.com',
            'password' => bcrypt('123456'),
            'type' => 'admin'
        ]);
        DB::table('users')->insert([
            'name' => 'Long LD',
            'email' => 'longld.8x@gmail.com',
            'password' => bcrypt('123456'),
            'type' => 'user'
        ]);
    }
}
