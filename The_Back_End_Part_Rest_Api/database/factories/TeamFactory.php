<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'city' => fake()->city(),
            'country' => fake()->country(),
            'image_url' => '/storage/images/teamDefaultImage.png',
            'stadium' => fake()->company(),
            'slag' => strtoupper(Str::random(3)),
        ];
    }
}
