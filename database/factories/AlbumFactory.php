<?php

namespace Database\Factories;

use App\Models\Artist;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Album>
 */
class AlbumFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->words(3, true),
            'upc' => fake()->ean13(),
            'label' => fake()->word(),
            'nb_tracks' => fake()->randomNumber(2),
            'duration' => fake()->randomNumber(3, true),
            'fans' => fake()->numberBetween(1000, 1000000),
            'release_date' => fake()->date(),
            'record_type' => fake()->randomElement(['ep', 'album']),
            'available' => fake()->boolean(),
            'artist_id' => fn () => Artist::inRandomOrder()->first()->id,
        ];
    }
}
