<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Membre;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\MembreController
 */
final class MembreControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $membres = Membre::factory()->count(3)->create();

        $response = $this->get(route('membres.index'));

        $response->assertOk();
        $response->assertViewIs('membre.index');
        $response->assertViewHas('membres');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('membres.create'));

        $response->assertOk();
        $response->assertViewIs('membre.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\MembreController::class,
            'store',
            \App\Http\Requests\MembreStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $nom = fake()->word();
        $prenom = fake()->word();
        $image = fake()->word();
        $designation = fake()->word();

        $response = $this->post(route('membres.store'), [
            'nom' => $nom,
            'prenom' => $prenom,
            'image' => $image,
            'designation' => $designation,
        ]);

        $membres = Membre::query()
            ->where('nom', $nom)
            ->where('prenom', $prenom)
            ->where('image', $image)
            ->where('designation', $designation)
            ->get();
        $this->assertCount(1, $membres);
        $membre = $membres->first();

        $response->assertRedirect(route('membres.index'));
        $response->assertSessionHas('membre.id', $membre->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $membre = Membre::factory()->create();

        $response = $this->get(route('membres.show', $membre));

        $response->assertOk();
        $response->assertViewIs('membre.show');
        $response->assertViewHas('membre');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $membre = Membre::factory()->create();

        $response = $this->get(route('membres.edit', $membre));

        $response->assertOk();
        $response->assertViewIs('membre.edit');
        $response->assertViewHas('membre');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\MembreController::class,
            'update',
            \App\Http\Requests\MembreUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $membre = Membre::factory()->create();
        $nom = fake()->word();
        $prenom = fake()->word();
        $image = fake()->word();
        $designation = fake()->word();

        $response = $this->put(route('membres.update', $membre), [
            'nom' => $nom,
            'prenom' => $prenom,
            'image' => $image,
            'designation' => $designation,
        ]);

        $membre->refresh();

        $response->assertRedirect(route('membres.index'));
        $response->assertSessionHas('membre.id', $membre->id);

        $this->assertEquals($nom, $membre->nom);
        $this->assertEquals($prenom, $membre->prenom);
        $this->assertEquals($image, $membre->image);
        $this->assertEquals($designation, $membre->designation);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $membre = Membre::factory()->create();

        $response = $this->delete(route('membres.destroy', $membre));

        $response->assertRedirect(route('membres.index'));

        $this->assertModelMissing($membre);
    }
}
