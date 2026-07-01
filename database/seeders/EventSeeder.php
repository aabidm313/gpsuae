<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\User;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        // Create 5 published events owned by different users
        Event::factory(5)
            ->published()
            ->recycle($users)
            ->create()
            ->each(function (Event $event) use ($users) {
                // Register 3–6 random users as participants (skip the organizer)
                $participants = $users
                    ->where('id', '!=', $event->user_id)
                    ->random(min(rand(3, 6), $users->count() - 1));

                foreach ($participants as $user) {
                    EventRegistration::create([
                        'event_id' => $event->id,
                        'user_id'  => $user->id,
                        'status'   => 'registered',
                    ]);
                }
            });

        // 3 draft events
        Event::factory(3)
            ->draft()
            ->recycle($users)
            ->create();

        // 2 cancelled events
        Event::factory(2)
            ->state(['status' => 'cancelled'])
            ->recycle($users)
            ->create();
    }
}
