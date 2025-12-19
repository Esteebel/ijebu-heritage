<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PhotoArchive;
use App\Models\Media;

class PhotoArchiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some sample media items for photos
        $mediaItems = Media::where('type', 'image')->limit(20)->get();

        if ($mediaItems->count() == 0) {
            // If no media items exist, create some sample ones
            for ($i = 1; $i <= 20; $i++) {
                $mediaItems[] = Media::create([
                    'filename' => "sample_photo_$i.jpg",
                    'path' => "media/images/sample_photo_$i.jpg",
                    'type' => 'image',
                    'mime' => 'image/jpeg',
                    'size' => rand(100000, 500000),
                    'uploaded_by' => 1,
                ]);
            }
        }

        $photos = [
            [
                'title' => 'Ijebu Traditional Festival',
                'description' => 'Celebration of traditional Ijebu festival with colorful attire',
                'category' => 'Festivals',
                'decade' => '1970',
                'media_id' => $mediaItems->random()->id,
                'is_featured' => true,
                'date_taken' => '1975-06-15',
                'location' => 'Ijebu-Ode',
                'photographer' => 'Unknown Photographer',
            ],
            [
                'title' => 'Ijebu Market Scene',
                'description' => 'Busy market day with vendors selling traditional goods',
                'category' => 'Market scenes',
                'decade' => '1960',
                'media_id' => $mediaItems->random()->id,
                'is_featured' => true,
                'date_taken' => '1963-03-22',
                'location' => 'Ijebu-Igbo Market',
                'photographer' => 'Colonial Office',
            ],
            [
                'title' => 'Traditional Coronation Ceremony',
                'description' => 'Coronation of a traditional ruler with ceremonial regalia',
                'category' => 'Coronations',
                'decade' => '1950',
                'media_id' => $mediaItems->random()->id,
                'is_featured' => false,
                'date_taken' => '1958-11-05',
                'location' => 'Ijebu-Ode Palace',
                'photographer' => 'Nigerian News Service',
            ],
            [
                'title' => 'Old Town Layout',
                'description' => 'Aerial view of traditional town layout with compounds',
                'category' => 'Old towns',
                'decade' => '1940',
                'media_id' => $mediaItems->random()->id,
                'is_featured' => false,
                'date_taken' => '1947-09-12',
                'location' => 'Ijebu-Ode',
                'photographer' => 'British Colonial Survey',
            ],
            [
                'title' => 'Early School Group Photo',
                'description' => 'Students and teachers at one of the first formal schools',
                'category' => 'Early schools',
                'decade' => '1950',
                'media_id' => $mediaItems->random()->id,
                'is_featured' => true,
                'date_taken' => '1955-10-30',
                'location' => 'St. Peter\'s School, Ijebu-Ode',
                'photographer' => 'Missionary Society',
            ],
            [
                'title' => 'Traditional Wedding Ceremony',
                'description' => 'Traditional Ijebu wedding with elaborate ceremonies',
                'category' => 'Traditional ceremonies',
                'decade' => '1980',
                'media_id' => $mediaItems->random()->id,
                'is_featured' => false,
                'date_taken' => '1982-04-18',
                'location' => 'Ijebu-Igbo',
                'photographer' => 'Local Studio',
            ],
            [
                'title' => 'Harvest Festival Celebration',
                'description' => 'Community gathering for annual harvest celebration',
                'category' => 'Festivals',
                'decade' => '1960',
                'media_id' => $mediaItems->random()->id,
                'is_featured' => false,
                'date_taken' => '1967-08-25',
                'location' => 'Remo Division',
                'photographer' => 'Western Nigeria Government',
            ],
            [
                'title' => 'Traditional Craftsman at Work',
                'description' => 'Local artisan crafting traditional pottery',
                'category' => 'Market scenes',
                'decade' => '1970',
                'media_id' => $mediaItems->random()->id,
                'is_featured' => false,
                'date_taken' => '1973-02-14',
                'location' => 'Ijebu-Ode Craft Market',
                'photographer' => 'Cultural Documentation Project',
            ],
        ];

        foreach ($photos as $photoData) {
            PhotoArchive::create($photoData);
        }
    }
}
