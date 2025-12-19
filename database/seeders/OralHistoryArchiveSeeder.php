<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OralHistoryArchive;
use App\Models\Media;

class OralHistoryArchiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some sample media items for audio files and images
        $mediaItems = Media::limit(20)->get();

        if ($mediaItems->count() == 0) {
            // If no media items exist, create some sample ones
            for ($i = 1; $i <= 20; $i++) {
                $mediaItems[] = Media::create([
                    'filename' => "sample_media_$i.mp3",
                    'path' => "media/audio/sample_media_$i.mp3",
                    'type' => 'audio',
                    'mime' => 'audio/mpeg',
                    'size' => rand(1000000, 5000000),
                    'uploaded_by' => 1,
                ]);
            }
        }

        $stories = [
            [
                'title' => 'The Legend of Oduduwa',
                'story' => 'This is the story of Oduduwa, the legendary founder of the Yoruba people and the first ruler of Ile-Ife. According to tradition, he descended from the heavens with a chain and filled the earth with soil...',
                'category' => 'Myths',
                'audio_file_id' => $mediaItems->random()->id,
                'featured_media_id' => $mediaItems->random()->id,
                'is_featured' => true,
                'storyteller' => 'Chief Adeyemi Ogunbiyi',
                'recorded_date' => '2020-03-15',
                'location' => 'Ijebu-Ode',
                'transcript' => 'Transcribed version of the oral story...',
                'cultural_context' => 'This story explains the origin of the Yoruba people and their connection to Ile-Ife.',
            ],
            [
                'title' => 'Memories of Independence',
                'story' => 'I still remember that historic day in 1960 when Nigeria gained independence from British colonial rule. The streets were filled with joy and celebration...',
                'category' => 'Personal experiences',
                'audio_file_id' => $mediaItems->random()->id,
                'featured_media_id' => $mediaItems->random()->id,
                'is_featured' => true,
                'storyteller' => 'Mrs. Funmilayo Adesina',
                'recorded_date' => '2018-10-01',
                'location' => 'Lagos',
                'transcript' => 'Transcribed version of the oral story...',
                'cultural_context' => 'Personal account of witnessing Nigerian independence.',
            ],
            [
                'title' => 'The Great War of Ijebu',
                'story' => 'Long ago, there was a great conflict between the Ijebu people and their neighbors. Our warriors were brave and skilled in the art of warfare...',
                'category' => 'War stories',
                'audio_file_id' => $mediaItems->random()->id,
                'featured_media_id' => $mediaItems->random()->id,
                'is_featured' => false,
                'storyteller' => 'Elder Obafemi Lawal',
                'recorded_date' => '2019-07-22',
                'location' => 'Ijebu-Igbo',
                'transcript' => 'Transcribed version of the oral story...',
                'cultural_context' => 'Traditional war story passed down through generations.',
            ],
            [
                'title' => 'The Talking Drum',
                'story' => 'In the old days, we had talking drums that could carry messages across vast distances. The drummers were highly respected members of our community...',
                'category' => 'Folktales',
                'audio_file_id' => $mediaItems->random()->id,
                'featured_media_id' => $mediaItems->random()->id,
                'is_featured' => false,
                'storyteller' => 'Griotte Kehinde Balogun',
                'recorded_date' => '2021-01-10',
                'location' => 'Abeokuta',
                'transcript' => 'Transcribed version of the oral story...',
                'cultural_context' => 'Folktale about traditional communication methods.',
            ],
            [
                'title' => 'Growing Up in Ijebu Land',
                'story' => 'My childhood in Ijebu land was filled with adventure and learning. We learned traditional values from our parents and elders...',
                'category' => 'Childhood memories',
                'audio_file_id' => $mediaItems->random()->id,
                'featured_media_id' => $mediaItems->random()->id,
                'is_featured' => true,
                'storyteller' => 'Professor Wole Soyinka',
                'recorded_date' => '2017-05-30',
                'location' => 'Ibadan',
                'transcript' => 'Transcribed version of the oral story...',
                'cultural_context' => 'Personal childhood memories in Ijebu land.',
            ],
            [
                'title' => 'Voices of the Elders',
                'story' => 'These are the collected wisdom and experiences of our village elders, recorded for future generations...',
                'category' => 'Recordings of elders',
                'audio_file_id' => $mediaItems->random()->id,
                'featured_media_id' => $mediaItems->random()->id,
                'is_featured' => false,
                'storyteller' => 'Council of Elders',
                'recorded_date' => '2022-02-14',
                'location' => 'Ijebu-Ode',
                'transcript' => 'Transcribed version of the oral story...',
                'cultural_context' => 'Collection of wisdom from village elders.',
            ],
        ];

        foreach ($stories as $storyData) {
            OralHistoryArchive::create($storyData);
        }
    }
}
