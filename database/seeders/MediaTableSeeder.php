<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Media;
use App\Models\User;

class MediaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@example.com')->first();

        // Check if Elizabeth I portrait already exists
        if (!Media::where('filename', 'elizabeth_i_portrait.jpg')->exists()) {
            Media::create([
                'filename' => 'elizabeth_i_portrait.jpg',
                'path' => 'media/elizabeth_i_portrait.jpg',
                'type' => 'image',
                'mime' => 'image/jpeg',
                'width' => 800,
                'height' => 600,
                'size' => 102400,
                'caption' => 'Portrait of Queen Elizabeth I',
                'credit' => 'Unknown Artist, circa 1600',
                'uploaded_by' => $admin->id
            ]);
        }

        // Check if James I portrait already exists
        if (!Media::where('filename', 'james_i_portrait.jpg')->exists()) {
            Media::create([
                'filename' => 'james_i_portrait.jpg',
                'path' => 'media/james_i_portrait.jpg',
                'type' => 'image',
                'mime' => 'image/jpeg',
                'width' => 800,
                'height' => 600,
                'size' => 102400,
                'caption' => 'Portrait of King James I',
                'credit' => 'Unknown Artist, circa 1620',
                'uploaded_by' => $admin->id
            ]);
        }
    }
}
