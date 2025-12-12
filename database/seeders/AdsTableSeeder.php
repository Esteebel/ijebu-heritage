<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ad;

class AdsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if Header Banner already exists
        if (!Ad::where('name', 'Header Banner')->exists()) {
            Ad::create([
                'name' => 'Header Banner',
                'slot_location' => 'header',
                'ad_code' => '<div class="bg-gray-200 border-2 border-dashed rounded-xl w-full h-24 flex items-center justify-center text-gray-500">Header Advertisement</div>',
                'active' => true
            ]);
        }

        // Check if Sidebar Banner already exists
        if (!Ad::where('name', 'Sidebar Banner')->exists()) {
            Ad::create([
                'name' => 'Sidebar Banner',
                'slot_location' => 'sidebar',
                'ad_code' => '<div class="bg-gray-200 border-2 border-dashed rounded-xl w-full h-64 flex items-center justify-center text-gray-500">Sidebar Advertisement</div>',
                'active' => true
            ]);
        }
    }
}
