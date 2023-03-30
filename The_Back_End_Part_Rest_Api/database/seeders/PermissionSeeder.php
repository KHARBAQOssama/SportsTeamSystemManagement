<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            [
                'name' => 'add user',
            ],
            [
                'name' => 'delete user',
            ],
            [
                'name' => 'update user',
            ],
        ];

        // Insert the permissions into the database
        DB::table('permissions')->insert($permissions);
    }
}
