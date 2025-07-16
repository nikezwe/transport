<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Membre;
use App\Models\Produit;

class ProduitFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Produit::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'membre_id' => Membre::factory(),
            'nom' => fake()->word(),
            'description' => fake()->text(),
            'poids' => fake()->randomFloat(2, 0, 999999.99),
            'est_publie' => fake()->boolean(),
        ];
    }
}
