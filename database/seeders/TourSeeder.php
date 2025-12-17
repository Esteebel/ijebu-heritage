<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tour;

class TourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Virtual Tour
        Tour::updateOrCreate([
            'name' => 'Virtual Museum Tour',
            'type' => 'virtual'
        ], [
            'description' => 'Explore the Kingdom Museum from anywhere in the world with our immersive virtual experience',
            'url' => 'https://virtual-tour.example.com',
            'active' => true,
            'features' => [
                '360° panoramic views',
                'Interactive exhibits',
                'Audio narration',
                'Multilingual support'
            ]
        ]);

        // Guided Tour
        Tour::updateOrCreate([
            'name' => 'Guided Historical Tour',
            'type' => 'guided'
        ], [
            'description' => 'Expert-led tour through our most significant exhibits and artifacts',
            'active' => true,
            'features' => [
                'Expert historian guide',
                'Behind-the-scenes access',
                'Exclusive stories and insights',
                'Small group experience'
            ]
        ]);

        // Self-Guided Tour
        Tour::updateOrCreate([
            'name' => 'Self-Guided Royal Timeline Tour',
            'type' => 'self-guided'
        ], [
            'description' => 'Follow the chronological journey of royal history at your own pace',
            'active' => true,
            'features' => [
                'Custom route map',
                'QR code scanning for information',
                'Mobile app integration',
                'Flexible timing'
            ]
        ]);
    }
}
