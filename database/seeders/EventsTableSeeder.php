<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if Annual Royal History Conference already exists
        if (!Event::where('title', 'Annual Royal History Conference')->exists()) {
            Event::create([
                'title' => 'Annual Royal History Conference',
                'description' => 'Join us for our annual conference celebrating royal history with guest speakers and exhibitions.',
                'start_datetime' => '2026-05-15 09:00:00',
                'end_datetime' => '2026-05-17 17:00:00',
                'location' => 'Main Hall, Ijebu Heritage'
            ]);
        }

        // Check if Tudor Dynasty Special Exhibition already exists
        if (!Event::where('title', 'Tudor Dynasty Special Exhibition')->exists()) {
            Event::create([
                'title' => 'Tudor Dynasty Special Exhibition',
                'description' => 'A special exhibition showcasing artifacts and stories from the Tudor Dynasty.',
                'start_datetime' => '2026-07-01 10:00:00',
                'end_datetime' => '2026-09-30 18:00:00',
                'location' => 'Gallery 3, Ijebu Heritage'
            ]);
        }
    }
}
