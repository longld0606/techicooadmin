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
        //admin
        DB::table('users')->insert([
            'name' => 'David Hoang Tran',
            'email' => 'dht.docs@gmail.com',
            'password' => bcrypt('12345678'),
            'type' => 'admin'
        ]);
        DB::table('users')->insert([
            'name' => 'Lê Đăng Long',
            'email' => 'longld0606@gmail.com',
            'password' => bcrypt('123456781'),
            'type' => 'admin'
        ]);
        DB::table('users')->insert([
            'name' => 'Long LD',
            'email' => 'longld.8x@gmail.com',
            'password' => bcrypt('123456782'),
            'type' => 'admin'
        ]);

        DB::table('users')->insert([
            'name' => 'Phước Trần',
            'email' => 'trantrungphuoc7@gmail.com',
            'password' => bcrypt('12345678'),
            'type' => 'admin'
        ]);
        DB::table('users')->insert([
            'name' => 'Nguyễn Việt Đoàn',
            'email' => 'doannv.241199@gmail.com',
            'password' => bcrypt('12345678'),
            'type' => 'admin'
        ]);
        DB::table('users')->insert([
            'name' => 'Nguyễn Đảm',
            'email' => 'nguyendam5555@gmail.com',
            'password' => bcrypt('12345678'),
            'type' => 'admin'
        ]);
        // admin
        DB::table('users')->insert([
            'name' => 'Long 1',
            'email' => 'longld1@gmail.com',
            'password' => bcrypt('123456'),
            'type' => 'user'
        ]);
        DB::table('users')->insert([
            'name' => 'Long 5',
            'email' => 'longld5@gmail.com',
            'password' => bcrypt('123456'),
            'type' => 'user'
        ]);
        DB::table('users')->insert([
            'name' => 'Long 6',
            'email' => 'longld6@gmail.com',
            'password' => bcrypt('123456'),
            'type' => 'user'
        ]);
    }
}
