<?php

namespace Database\Factories;
use App\Models\User;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Subscription>
 */
class SubscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
             'user_id' => User::factory(),
            'name' => fake()->randomElement(['Netflix', 'Spotify', 'Adobe CC', 'Gym Membership']),
            'amount' => fake()->randomFloat(2, 5, 200),
            'status' => fake()->randomElement(['active', 'cancelled', 'paused']),
            'billing_cycle' => fake()->randomElement(['monthly', 'yearly']),
            'start_date' => fake()->dateTimeBetween('-1 year', 'now'),
            'next_billing_cycle' => fake()->dateTimeBetween('now', '+1 month'),
            'short_note' => fake()->sentence(),
            'category' => fake()->randomElement(['entertainment', 'productivity', 'health']),
        ];
    }
}
