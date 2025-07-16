<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Pay;
use App\Models\Trajet;

class TrajetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Trajet::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'pays_depart_id' => Pay::factory()->create()->depart_id,
            'pays_arrivee_id' => Pay::factory()->create()->arrivee_id,
            'ville_depart' => fake()->word(),
            'ville_arrivee' => fake()->word(),
            'date_depart' => fake()->date(),
            'date_arrivee' => fake()->date(),
        ];
    }
}
