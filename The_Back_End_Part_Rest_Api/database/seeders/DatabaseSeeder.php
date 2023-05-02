<?php

namespace Database\Seeders;

use App\Models\User;
use App\Events\UserCreated;
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
            BranchesTableSeeder::class,
            OurTeamSeeder::class,
            AdminSeeder::class
        ]);

        
        User::factory()->times(30)->create()->each(function ($user) {
            event(new UserCreated($user));
        });;
    }
}
