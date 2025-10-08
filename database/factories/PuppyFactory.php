<?php

namespace Database\Factories;

use App\Models\Puppy;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Puppy>
 */
class PuppyFactory extends Factory
{
    protected $model = Puppy::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => fake()->unique()->firstName(),
            'trait' => fake()->randomElement(['Curious', 'Playful', 'Sleepy', 'Brave', 'Gentle']),
            'image_url' => fake()->imageUrl(640, 480, 'dogs', true),
        ];
    }
}
