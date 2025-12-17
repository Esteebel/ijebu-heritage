<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PublishingQueue;
use App\Models\User;

class PublishingQueueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@example.com')->first();

        if ($admin) {
            // Create sample publishing queue items
            PublishingQueue::updateOrCreate([
                'title' => 'New Royal Artifact Collection',
                'type' => 'artifact'
            ], [
                'description' => 'Collection of newly discovered royal artifacts from the 18th century',
                'user_id' => $admin->id,
                'status' => 'ready',
                'metadata' => [
                    'priority' => 'high',
                    'reviewers' => ['editor_john', 'curator_sarah']
                ]
            ]);

            PublishingQueue::updateOrCreate([
                'title' => 'Kingdom Festival Event',
                'type' => 'event'
            ], [
                'description' => 'Annual kingdom festival with special exhibitions and performances',
                'user_id' => $admin->id,
                'status' => 'draft',
                'scheduled_at' => now()->addDays(30),
                'metadata' => [
                    'priority' => 'medium',
                    'departments' => ['events', 'marketing']
                ]
            ]);

            PublishingQueue::updateOrCreate([
                'title' => 'Virtual Tour Update',
                'type' => 'tour'
            ], [
                'description' => 'Updated virtual tour with new 360° panoramic views',
                'user_id' => $admin->id,
                'status' => 'published',
                'published_at' => now()->subDays(5),
                'metadata' => [
                    'priority' => 'low',
                    'reviewers' => ['tech_lead']
                ]
            ]);
        }
    }
}
