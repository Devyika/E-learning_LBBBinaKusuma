<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'rizaldy',
                'username' => 'rizaldy',
                'email' => 'rizaldy@gmail.com',
                'password' => Hash::make('1111')
            ],
            [
                'name' => 'fiki',
                'username' => 'fiki',
                'email' => 'fiki@gmail.com',
                'password' => Hash::make('2222')
            ]
        ]);
    }
}
