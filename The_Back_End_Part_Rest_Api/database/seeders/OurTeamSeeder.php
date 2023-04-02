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
            'name' => 'Olympic Club Youssoufia',
            'slag' => 'OCY',
            'city' => 'YOUSSOUFIA',
            'country' => 'MOROCCO',
            'stadium' => 'DAKHLA STADIUM',
        ];

        DB::table('teams')->insert($credentials);
    }
}
