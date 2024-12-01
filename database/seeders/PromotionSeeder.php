<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Promotion;
use App\Models\Event;
use App\Models\Ticket;

class PromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Promotion::factory()->count(20)->create()->each(function ($promotion) {
            // Attach events to the promotion
            $events = Event::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $promotion->events()->attach($events);

            // Attach tickets to the promotion
            $tickets = Ticket::inRandomOrder()->take(rand(1, 5))->pluck('id');
            $promotion->tickets()->attach($tickets);
        });
    }
}