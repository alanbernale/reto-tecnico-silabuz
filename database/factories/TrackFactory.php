<?php

namespace Database\Factories;

use App\Models\Album;
use App\Models\Artist;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Track>
 */
class TrackFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'readable' => fake()->boolean(),
            'title' => fake()->words(3, true),
            'title_short' => fake()->words(2, true),
            'title_version' => fake()->words(2, true),
            'link' => fake()->url(),
            'duration' => fake()->randomNumber(3, true),
            'rank' => fake()->numberBetween(1000, 1000000),
            'explicit_lyrics' => fake()->boolean(),
            'preview' => fake()->url(),
            'artist_id' => fn () => Artist::inRandomOrder()->first()->id,
            'album_id' => fn () => Album::inRandomOrder()->first()->id,
        ];
    }
}
