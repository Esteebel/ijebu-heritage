<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\King;
use App\Models\Dynasty;

class KingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stuart = Dynasty::where('name', 'Stuart Dynasty')->first();
        $tudor = Dynasty::where('name', 'Tudor Dynasty')->first();

        // Update or create James I
        $james = King::where('name', 'James I')->first();
        if ($james) {
            $james->update([
                'portrait_media_id' => 2 // James I portrait
            ]);
        } else {
            King::create([
                'name' => 'James I',
                'regnal_name' => 'James I of England',
                'birth_year' => 1566,
                'death_year' => 1625,
                'reign_start_date' => '1603-03-24',
                'reign_end_date' => '1625-03-27',
                'dynasty_id' => $stuart->id,
                'portrait_media_id' => 2, // James I portrait
                'short_bio' => 'James I was King of England and Ireland from 1603 and King of Scotland from 1567.',
                'full_bio' => 'James VI and I (James Charles Stuart; 19 June 1566 – 27 March 1625) was King of Scotland as James VI from 24 July 1567 and King of England and Ireland as James I from the union of the Scottish and English crowns on 24 March 1603 until his death in 1625.',
                'featured' => true
            ]);
        }

        // Update or create Elizabeth I
        $elizabeth = King::where('name', 'Elizabeth I')->first();
        if ($elizabeth) {
            $elizabeth->update([
                'portrait_media_id' => 1 // Elizabeth I portrait
            ]);
        } else {
            King::create([
                'name' => 'Elizabeth I',
                'regnal_name' => 'Elizabeth I of England',
                'birth_year' => 1533,
                'death_year' => 1603,
                'reign_start_date' => '1558-11-17',
                'reign_end_date' => '1603-03-24',
                'dynasty_id' => $tudor->id,
                'portrait_media_id' => 1, // Elizabeth I portrait
                'short_bio' => 'Elizabeth I was Queen of England and Ireland from 17 November 1558 until her death in 1603.',
                'full_bio' => 'Elizabeth I (7 September 1533 – 24 March 1603) was Queen of England and Ireland from 17 November 1558 until her death in 1603. Sometimes called the Virgin Queen, Gloriana or Good Queen Bess, Elizabeth was the last monarch of the House of Tudor.',
                'featured' => true
            ]);
        }
    }
}
