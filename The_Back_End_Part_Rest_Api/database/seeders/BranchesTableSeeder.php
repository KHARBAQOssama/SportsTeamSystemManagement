<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Array of possible branch prefixes
        $prefixes = [
            'The Youth Squad',
            'The Future Stars',
            'The Rising Stars',
            'The Development Team',
            'The B-Team',
            'The Academy Squad',
            'The U-19s',
            'The U-17s',
            'The U-15s',
            'The U-13s',
            'The Young Guns',
            'The Prospects',
            'The Next Generation',
            'The Future Force',
            'The Emerging Talent',
            'The Greenhorns',
            'The Up-and-Comers',
            'The New Recruits',
        ];

        // Create 10 branches with random sport IDs between 1 and 6
        for ($i = 0; $i < count($prefixes); $i++) {
            $name = $prefixes[$i];
            DB::table('branches')->insert([
                'name' => $name,
                'icon' => null,
                'sport_id' => rand(1, 9),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}