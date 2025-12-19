<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UsersTableSeeder::class);
        $this->call(DynastiesTableSeeder::class);
        $this->call(MediaTableSeeder::class);
        $this->call(KingsTableSeeder::class);
        $this->call(EventsTableSeeder::class);
        $this->call(AdsTableSeeder::class);
        $this->call(TicketSeeder::class);
        $this->call(TourSeeder::class);
        $this->call(BookingSeeder::class);
        $this->call(PublishingQueueSeeder::class);
        $this->call(PhotoArchiveSeeder::class);
        $this->call(OralHistoryArchiveSeeder::class);
        $this->call(OluCornerSeeder::class);
    }
}
