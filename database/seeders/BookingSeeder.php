<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\User;
use App\Models\Ticket;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@example.com')->first();
        $generalTicket = Ticket::where('type', 'general')->first();
        $familyTicket = Ticket::where('type', 'family')->first();

        if ($admin && $generalTicket) {
            // Create a sample booking
            Booking::updateOrCreate([
                'user_id' => $admin->id,
                'ticket_id' => $generalTicket->id,
                'quantity' => 2,
                'visit_date' => now()->addDays(7),
                'status' => 'confirmed',
                'total_amount' => $generalTicket->price * 2,
                'visitor_details' => [
                    'visitor_1' => [
                        'name' => 'John Doe',
                        'email' => 'john@example.com'
                    ],
                    'visitor_2' => [
                        'name' => 'Jane Doe',
                        'email' => 'jane@example.com'
                    ]
                ]
            ]);
        }

        if ($admin && $familyTicket) {
            // Create a family booking
            Booking::updateOrCreate([
                'user_id' => $admin->id,
                'ticket_id' => $familyTicket->id,
                'quantity' => 1,
                'visit_date' => now()->addDays(14),
                'status' => 'pending',
                'total_amount' => $familyTicket->price,
                'visitor_details' => [
                    'adult_1' => [
                        'name' => 'Robert Smith',
                        'email' => 'robert@example.com'
                    ],
                    'adult_2' => [
                        'name' => 'Susan Smith',
                        'email' => 'susan@example.com'
                    ],
                    'child_1' => [
                        'name' => 'Tommy Smith',
                        'age' => 8
                    ]
                ]
            ]);
        }
    }
}
