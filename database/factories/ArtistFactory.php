<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Artist>
 */
class ArtistFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'nb_fan' => fake()->numberBetween(1000, 1000000),
            'radio' => fake()->boolean(),
            'type' => fake()->randomElement(['artista', 'compositor']),
        ];
    }
}
