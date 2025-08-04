<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserRating;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserRating>
 */
class UserRatingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserRating::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $movies = [
            ['tt0133093', 'The Matrix'],
            ['tt0111161', 'The Shawshank Redemption'],
            ['tt0068646', 'The Godfather'],
            ['tt0108052', 'Schindler\'s List'],
            ['tt0167260', 'The Lord of the Rings: The Return of the King'],
            ['tt0110912', 'Pulp Fiction'],
            ['tt0060196', 'The Good, the Bad and the Ugly'],
            ['tt0137523', 'Fight Club'],
            ['tt0109830', 'Forrest Gump'],
            ['tt1375666', 'Inception'],
        ];

        $movie = $this->faker->randomElement($movies);
        
        return [
            'user_id' => User::factory(),
            'imdb_id' => $movie[0],
            'movie_title' => $movie[1],
            'rating' => $this->faker->numberBetween(1, 5),
            'review' => $this->faker->optional(0.7)->paragraph(),
        ];
    }
}
