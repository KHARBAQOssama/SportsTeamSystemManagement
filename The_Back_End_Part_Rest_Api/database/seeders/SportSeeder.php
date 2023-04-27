<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sports = [
            [
                'name' => 'Football',
                'symbol' => '⚽',
                'win_points' => 3,
                'loss_points' => 0,
                'draw_points' => 1,
            ],
            [
                'name' => 'Basketball',
                'symbol' => '🏀',
                'win_points' => 2,
                'loss_points' => 0,
                'draw_points' => 1,
            ],
            [
                'name' => 'Baseball',
                'symbol' => '⚾',
                'win_points' => 1,
                'loss_points' => 0,
                'draw_points' => 0,
            ],
            [
                'name' => 'Hockey',
                'symbol' => '🏒',
                'win_points' => 2,
                'loss_points' => 0,
                'draw_points' => 1,
            ],
            [
                'name' => 'Rugby',
                'symbol' => '🏉',
                'win_points' => 4,
                'loss_points' => 0,
                'draw_points' => 2,
            ],
            [
                'name' => 'Volleyball',
                'symbol' => '🏐',
                'win_points' => 2,
                'loss_points' => 0,
                'draw_points' => 1,
            ],
            [
                'name' => 'Handball',
                'symbol' => '🤾',
                'win_points' => 2,
                'loss_points' => 0,
                'draw_points' => 1,
            ],
            [
                'name' => 'Water Polo',
                'symbol' => '🤽',
                'win_points' => 2,
                'loss_points' => 0,
                'draw_points' => 1,
            ],
            [
                'name' => 'Cricket',
                'symbol' => '🏏',
                'win_points' => 2,
                'loss_points' => 0,
                'draw_points' => 1,
                ],
        ];
        
        DB::table('sports')->insert($sports);
    }
}
