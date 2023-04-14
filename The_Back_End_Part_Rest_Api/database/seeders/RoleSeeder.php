<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Fan',
                'icon' => 'http://localhost:8000/storage/images/suporter.png'
            ],
            [
                'name' => 'Team Member',
                'icon' => 'http://localhost:8000/storage/images/team-member.png'
            ],
            [
                'name' => 'Sub-admin',
                'icon' => 'http://localhost:8000/storage/images/admin.png',
            ],
            [
                'name' => 'Admin',
                'icon' => 'http://localhost:8000/storage/images/super-admin.png',
            ],
        ];

        // Insert the roles into the database
        DB::table('roles')->insert($roles);
    }
}
