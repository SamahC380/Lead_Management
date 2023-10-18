<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password'=> Hash::make('12345678'),
            'status' => 'None',
            'usertype' => 'admin',
        ]);
        DB::table('categories')->insert([
            'name' => 'Hot',
        ]);
        DB::table('categories')->insert([
            'name' => 'Warm',
        ]);
        DB::table('categories')->insert([
            'name' => 'Cold',
        ]);
    }
}

