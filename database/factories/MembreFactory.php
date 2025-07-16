<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Membre;

class MembreFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Membre::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'nom' => fake()->word(),
            'prenom' => fake()->word(),
            'image' => fake()->word(),
            'designation' => fake()->word(),
            'fb_link' => fake()->word(),
            'tw_link' => fake()->word(),
            'ig_link' => fake()->word(),
        ];
    }
}
