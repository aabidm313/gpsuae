<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    public function definition(): array
    {
        $start = fake()->dateTimeBetween('+1 week', '+3 months');
        $end   = fake()->dateTimeBetween($start, '+4 months');

        return [
            'user_id'          => User::factory(),
            'title'            => fake()->sentence(4),
            'description'      => fake()->paragraph(3),
            'location'         => fake()->city() . ', ' . fake()->country(),
            'start_datetime'   => $start,
            'end_datetime'     => $end,
            'max_participants' => fake()->randomElement([null, 20, 50, 100, 200]),
            'status'           => fake()->randomElement(['draft', 'published', 'published', 'published']),
        ];
    }

    public function published(): static
    {
        return $this->state(['status' => 'published']);
    }

    public function draft(): static
    {
        return $this->state(['status' => 'draft']);
    }
}
