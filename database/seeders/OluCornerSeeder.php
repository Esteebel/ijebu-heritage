<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OluCorner;
use App\Models\Media;

class OluCornerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some sample media items
        $mediaItems = Media::limit(5)->get();

        if ($mediaItems->count() == 0) {
            // If no media items exist, create some sample ones
            for ($i = 1; $i <= 5; $i++) {
                $mediaItems[] = Media::create([
                    'filename' => "olu_photo_$i.jpg",
                    'path' => "media/images/olu_photo_$i.jpg",
                    'type' => 'image',
                    'mime' => 'image/jpeg',
                    'size' => rand(100000, 500000),
                    'uploaded_by' => 1,
                ]);
            }
        }

        $sections = [
            [
                'section' => 'Your roots',
                'content' => "I was born and raised in Ijebu-Ode, the heart of Ijebu land. My ancestors were farmers and traders who played significant roles in our community's development. Growing up, I was surrounded by rich oral traditions and cultural practices that sparked my interest in preserving our heritage. My grandfather was a renowned storyteller who would share tales of our ancestors' bravery and wisdom every evening. These stories shaped my understanding of who we are as a people and inspired my lifelong commitment to cultural preservation.",
                'featured_media_id' => $mediaItems->random()->id,
                'is_published' => true,
            ],
            [
                'section' => 'Your journey',
                'content' => "My journey in cultural preservation began during my university years when I studied Anthropology and History. I became increasingly aware of how much of our heritage was being lost as elders passed away without documenting their knowledge. After graduation, I worked with various cultural organizations and museums, gaining valuable experience in archival work and exhibition curation. In 2010, I initiated the Ijebu Heritage Project, traveling across villages to collect stories, photographs, and artifacts. This digital museum is the culmination of over a decade of dedicated research and community engagement.",
                'featured_media_id' => $mediaItems->random()->id,
                'is_published' => true,
            ],
            [
                'section' => 'Why you created this',
                'content' => "I created this virtual museum because I witnessed firsthand how rapidly our cultural heritage was disappearing. Young people were migrating to cities, traditional practices were being forgotten, and precious historical artifacts were deteriorating. I realized that we needed a comprehensive digital archive that could preserve our history for future generations. This platform serves multiple purposes: it educates visitors about Ijebu culture, honors our ancestors' legacy, and provides a resource for researchers and students. More importantly, it gives our community a sense of pride in their heritage and ensures that our stories will never be lost.",
                'featured_media_id' => $mediaItems->random()->id,
                'is_published' => true,
            ],
            [
                'section' => 'Vision for Ijebu future',
                'content' => "My vision for the future of Ijebu heritage is one where our traditions thrive alongside modernity. I hope to expand this museum with interactive exhibits, virtual reality experiences, and educational programs for schools. I envision partnerships with universities and cultural institutions worldwide to promote research and exchange. Most importantly, I want to empower young Ijebu people to take ownership of their heritage by training them as cultural ambassadors and archivists. The future of our culture lies in the hands of our youth, and it is our responsibility to equip them with the knowledge and tools to carry it forward. Together, we can ensure that the spirit of Ijebu land continues to inspire generations to come.",
                'featured_media_id' => $mediaItems->random()->id,
                'is_published' => true,
            ],
        ];

        foreach ($sections as $sectionData) {
            OluCorner::create($sectionData);
        }
    }
}
