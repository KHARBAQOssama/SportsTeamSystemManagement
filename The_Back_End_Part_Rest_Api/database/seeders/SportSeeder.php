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
                'name' => 'Soccer',
                'icon' => 'http://localhost:8000/storage/images/soccer.png',
            ],
            [
                'name' => 'Basketball',
                'icon' => 'http://localhost:8000/storage/images/basketball.png',
            ],
            [
                'name' => 'Handball',
                'icon' => 'http://localhost:8000/storage/images/handball.png',
            ],
        ];

        DB::table('sports')->insert($sports);

    }
}
