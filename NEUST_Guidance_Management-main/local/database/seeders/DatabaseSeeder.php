<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the counselors table with initial data.
     *
     * @return void
     */
    public function run()
    {
        $userData = [
            'user_type' => '1',
            'first_name' => 'guidance',
            'last_name' => 'counselor',
            'email' => 'counselor@gmail.com',
            'password' => Hash::make('bnhs2024'),
        ];

        $userId = DB::table('users')->insertGetId($userData);

        $counselorData = [
            'user_type' => '1',
            'user_id' => $userId,
            'firstname' => 'guidance',
            'surname' => 'counselor',
            'email' => 'counselor@gmail.com',
        ];

        DB::table('counselor')->insert($counselorData);
    }
}
