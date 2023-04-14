<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OurTeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $credentials = [
            'first_name' => 'The',
            'last_name' => 'Admin',
            'birth_day' => '1999-01-01',
            'role_id' => '4',
        ];

        DB::table('users')->insert($credentials);
    }
}