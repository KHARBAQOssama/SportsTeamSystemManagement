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
            ],
            [
                'name' => 'Basketball',
            ],
            [
                'name' => 'Handball',
            ],
        ];

        // Insert the sports into the database
        DB::table('sports')->insert($sports);

    }
}
