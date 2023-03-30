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
            ],
            [
                'name' => 'Team Member',
            ],
            [
                'name' => 'Sub-admin',
            ],
            [
                'name' => 'Admin',
            ],
        ];

        // Insert the roles into the database
        DB::table('roles')->insert($roles);
    }
}
