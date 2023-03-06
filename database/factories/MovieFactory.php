<?php

namespace Database\Factories;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Factories\Factory;
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Movie::class;

    public function definition()
    {
        // Generate fake data for a movie record
        return [
            'title' => $this->faker->sentence, // Generate a fake movie title
            'release_year' => $this->faker->numberBetween(1900, 2022), // Generate a fake release year between 1900 and 2022
            'genres' => $this->faker->words(3, true), // Generate a fake set of genres
            'description' => $this->faker->paragraph, // Generate a fake movie description
        ];
    }
}
