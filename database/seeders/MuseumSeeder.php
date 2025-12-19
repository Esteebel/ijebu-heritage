<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Festival;
use App\Models\Food;
use App\Models\HistoricalSite;
use App\Models\Personality;
use App\Models\LanguageItem;
use App\Models\OralHistory;
use App\Models\DiasporaStory;
use App\Models\HistoricalEvent;

class MuseumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample festivals
        Festival::create([
            'name' => 'Ojude Oba Festival',
            'description' => 'The annual festival of the Awujale of Ijebuland, celebrating the rich cultural heritage of the Ijebu people.',
            'origin_story' => 'Started in the 19th century to honor the Awujale and showcase the regalia of various regberegbe groups.',
            'regberegbe_groups' => 'Elesunwon, Akarakumo, Agamo, Oroge, Ilugun',
            'horsemen_info' => 'Colorful horsemen representing different regberegbe groups parade through the streets.',
            'start_date' => '2025-07-15',
            'end_date' => '2025-07-15',
            'featured' => true
        ]);

        // Create sample foods
        Food::create([
            'name' => 'Ikokore',
            'description' => 'Traditional Ijebu delicacy made from fermented corn dough.',
            'recipe' => 'Mix fermented corn dough with water to form a thick paste, steam until cooked, serve with soup or stew.',
            'ingredients' => 'Corn, water',
            'preparation_method' => 'Fermentation and steaming',
            'cultural_significance' => 'Considered a staple food during special occasions and ceremonies.',
            'region' => 'Ijebu Ode'
        ]);

        // Create sample historical sites
        HistoricalSite::create([
            'name' => 'Omo Alagemo Grove',
            'description' => 'Sacred grove considered the spiritual heart of Ijebu land.',
            'location' => 'Ijebu Ode',
            'historical_significance' => 'Believed to be the dwelling place of ancestral spirits and deities.',
            'preservation_status' => 'Protected',
            'featured' => true
        ]);

        // Create sample personalities
        Personality::create([
            'name' => 'Obafemi Awolowo',
            'biography' => 'First Premier of Western Region, Nigerian nationalist, and statesman.',
            'achievements' => 'Father of Nigerian federalism, established free education in Western Nigeria',
            'category' => 'Politician',
            'birth_date' => '1909-03-06',
            'death_date' => '1987-05-09',
            'featured' => true
        ]);

        // Create sample language items
        LanguageItem::create([
            'word_phrase' => 'E ku o',
            'pronunciation_guide' => 'Eh koo oh',
            'meaning' => 'Thank you',
            'usage_example' => 'E ku o for your help',
            'category' => 'Phrase'
        ]);

        // Create sample oral histories
        OralHistory::create([
            'title' => 'The Legend of Oduduwa',
            'storyteller' => 'Chief Elder',
            'recording_date' => '2025-01-15',
            'transcription' => 'Long ago, Oduduwa descended from the heavens with a chain...',
            'category' => 'Folktale',
            'featured' => true
        ]);

        // Create sample diaspora stories
        DiasporaStory::create([
            'title' => 'Building Bridges in America',
            'storyteller' => 'Dr. Adewale Johnson',
            'origin_location' => 'Ijebu Ode',
            'destination' => 'New York, USA',
            'immigration_story' => 'Moved to America in 1985 to pursue higher education and became a professor...',
            'achievements' => 'Professor of African Studies, published author, community leader',
            'featured' => true
        ]);

        // Create sample historical events
        HistoricalEvent::create([
            'title' => 'British-Ijebu War',
            'description' => 'Conflict between British forces and Ijebu warriors in 1892.',
            'event_date' => '1892-03-20',
            'significance' => 'Marked the beginning of British colonial influence in Ijebuland.',
            'location' => 'Ijebu Ode',
            'featured' => true
        ]);
    }
}
