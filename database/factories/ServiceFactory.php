<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Membre;
use App\Models\Service;
use App\Models\Trajet;

class ServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Service::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'membre_id' => Membre::factory(),
            'trajet_id' => Trajet::factory(),
            'description' => fake()->text(),
            'date_depart' => fake()->dateTime(),
            'prix' => fake()->randomFloat(2, 0, 99999999.99),
            'type' => fake()->word(),
        ];
    }
}
