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
        Ticket::create([
            'name' => 'General Admission',
            'description' => 'Access to all museum exhibits and galleries',
            'price' => 2500.00,
            'type' => 'general',
            'active' => true,
            'benefits' => ['Full museum access', 'Audio guide included', 'Special exhibitions']
        ]);

        Ticket::create([
            'name' => 'Student Ticket',
            'description' => 'Discounted admission for students with valid ID',
            'price' => 1500.00,
            'type' => 'student',
            'active' => true,
            'benefits' => ['Full museum access', 'Audio guide included']
        ]);

        Ticket::create([
            'name' => 'Senior Citizen',
            'description' => 'Special rate for visitors 60 years and above',
            'price' => 2000.00,
            'type' => 'senior',
            'active' => true,
            'benefits' => ['Full museum access', 'Priority entry', 'Comfort seating']
        ]);

        Ticket::create([
            'name' => 'Family Package',
            'description' => 'Great value for families of 4 or more',
            'price' => 8000.00,
            'type' => 'family',
            'active' => true,
            'benefits' => ['Full museum access for 4 people', 'Audio guides included', 'Lunch vouchers']
        ]);
    }
}
