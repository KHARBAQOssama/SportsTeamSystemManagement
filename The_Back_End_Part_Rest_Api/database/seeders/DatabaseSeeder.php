<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {   
        $this->call([
            RolesAndPermissionsTableSeeder::class,
            SportSeeder::class,
            TeamSeeder::class,
            OurTeamSeeder::class,
            AdminSeeder::class
        ]);

        \App\Models\User::factory(10)->create();
    }
}
