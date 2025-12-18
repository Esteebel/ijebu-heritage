<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\King;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;

class FixMissingKingPortraitsSeeder extends Seeder
{
    /**
     * Run the database seeds to fix missing king portrait files.
     *
     * @return void
     */
    public function run()
    {
        // Get all kings with portrait media
        $kings = King::with('portraitMedia')->get();

        foreach ($kings as $king) {
            // Check if king has portrait media assigned
            if ($king->portrait_media_id && $king->portraitMedia) {
                // Check if the media file actually exists
                $filePath = storage_path('app/public/' . $king->portraitMedia->path);

                if (!file_exists($filePath)) {
                    // File doesn't exist, so we need to either:
                    // 1. Clear the portrait_media_id reference, or
                    // 2. Replace with a default image

                    // For now, we'll set it to null to avoid broken images
                    $king->update(['portrait_media_id' => null]);

                    // Optionally, we could delete the orphaned media record
                    // $king->portraitMedia->delete();

                    echo "Fixed missing portrait for king: {$king->name}\n";
                } else {
                    echo "King {$king->name} has valid portrait file\n";
                }
            } else {
                echo "King {$king->name} has no portrait assigned\n";
            }
        }
    }
}
