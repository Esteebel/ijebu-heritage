<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Dynasty;

class DynastiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if Stuart Dynasty already exists
        if (!Dynasty::where('name', 'Stuart Dynasty')->exists()) {
            Dynasty::create([
                'name' => 'Stuart Dynasty',
                'description' => 'The Stuart dynasty was a British royal house that originated in Scotland before advancing to the English and later British throne.',
                'start_year' => 1371,
                'end_year' => 1714
            ]);
        }

        // Check if Tudor Dynasty already exists
        if (!Dynasty::where('name', 'Tudor Dynasty')->exists()) {
            Dynasty::create([
                'name' => 'Tudor Dynasty',
                'description' => 'The Tudor dynasty was a Welsh-English royal house that ruled England and Wales from 1485 to 1603.',
                'start_year' => 1485,
                'end_year' => 1603
            ]);
        }
    }
}
