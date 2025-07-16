<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Membre;
use App\Models\Produit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ProduitController
 */
final class ProduitControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $produits = Produit::factory()->count(3)->create();

        $response = $this->get(route('produits.index'));

        $response->assertOk();
        $response->assertViewIs('produit.index');
        $response->assertViewHas('produits');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('produits.create'));

        $response->assertOk();
        $response->assertViewIs('produit.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ProduitController::class,
            'store',
            \App\Http\Requests\ProduitStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $membre = Membre::factory()->create();
        $nom = fake()->word();
        $est_publie = fake()->boolean();

        $response = $this->post(route('produits.store'), [
            'membre_id' => $membre->id,
            'nom' => $nom,
            'est_publie' => $est_publie,
        ]);

        $produits = Produit::query()
            ->where('membre_id', $membre->id)
            ->where('nom', $nom)
            ->where('est_publie', $est_publie)
            ->get();
        $this->assertCount(1, $produits);
        $produit = $produits->first();

        $response->assertRedirect(route('produits.index'));
        $response->assertSessionHas('produit.id', $produit->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $produit = Produit::factory()->create();

        $response = $this->get(route('produits.show', $produit));

        $response->assertOk();
        $response->assertViewIs('produit.show');
        $response->assertViewHas('produit');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $produit = Produit::factory()->create();

        $response = $this->get(route('produits.edit', $produit));

        $response->assertOk();
        $response->assertViewIs('produit.edit');
        $response->assertViewHas('produit');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ProduitController::class,
            'update',
            \App\Http\Requests\ProduitUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $produit = Produit::factory()->create();
        $membre = Membre::factory()->create();
        $nom = fake()->word();
        $est_publie = fake()->boolean();

        $response = $this->put(route('produits.update', $produit), [
            'membre_id' => $membre->id,
            'nom' => $nom,
            'est_publie' => $est_publie,
        ]);

        $produit->refresh();

        $response->assertRedirect(route('produits.index'));
        $response->assertSessionHas('produit.id', $produit->id);

        $this->assertEquals($membre->id, $produit->membre_id);
        $this->assertEquals($nom, $produit->nom);
        $this->assertEquals($est_publie, $produit->est_publie);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $produit = Produit::factory()->create();

        $response = $this->delete(route('produits.destroy', $produit));

        $response->assertRedirect(route('produits.index'));

        $this->assertModelMissing($produit);
    }
}
