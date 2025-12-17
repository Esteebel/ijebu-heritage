<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ticket;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // General Admission Ticket
        Ticket::updateOrCreate([
            'name' => 'General Admission',
            'type' => 'general'
        ], [
            'description' => 'Access to all permanent exhibits with audio guide included',
            'price' => 15.00,
            'active' => true,
            'benefits' => [
                'Access to all permanent exhibits',
                'Audio guide included',
                'Daily guided tours',
                'Free Wi-Fi'
            ]
        ]);

        // Family Pass
        Ticket::updateOrCreate([
            'name' => 'Family Pass',
            'type' => 'family'
        ], [
            'description' => 'Special package for families with children',
            'price' => 45.00,
            'active' => true,
            'benefits' => [
                'All General Admission benefits',
                'Priority access to special exhibits',
                'Children under 12 free',
                'Family activity pack'
            ]
        ]);

        // Senior Ticket
        Ticket::updateOrCreate([
            'name' => 'Senior Admission',
            'type' => 'senior'
        ], [
            'description' => 'Discounted admission for seniors 65+',
            'price' => 12.00,
            'active' => true,
            'benefits' => [
                'Access to all permanent exhibits',
                'Audio guide included',
                'Senior discount program',
                'Priority seating for events'
            ]
        ]);

        // Student Ticket
        Ticket::updateOrCreate([
            'name' => 'Student Admission',
            'type' => 'student'
        ], [
            'description' => 'Discounted admission for students with valid ID',
            'price' => 10.00,
            'active' => true,
            'benefits' => [
                'Access to all permanent exhibits',
                'Audio guide included',
                'Student discount program',
                'Study room access'
            ]
        ]);
    }
}
