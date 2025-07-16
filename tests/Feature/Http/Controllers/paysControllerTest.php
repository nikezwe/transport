<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Pay;
use App\Models\pays;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\paysController
 */
final class paysControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $pays = pays::factory()->count(3)->create();

        $response = $this->get(route('pays.index'));

        $response->assertOk();
        $response->assertViewIs('pay.index');
        $response->assertViewHas('pays');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('pays.create'));

        $response->assertOk();
        $response->assertViewIs('pay.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\paysController::class,
            'store',
            \App\Http\Requests\paysStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $nom = fake()->word();

        $response = $this->post(route('pays.store'), [
            'nom' => $nom,
        ]);

        $pays = Pay::query()
            ->where('nom', $nom)
            ->get();
        $this->assertCount(1, $pays);
        $pay = $pays->first();

        $response->assertRedirect(route('pays.index'));
        $response->assertSessionHas('pay.id', $pay->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $pay = pays::factory()->create();

        $response = $this->get(route('pays.show', $pay));

        $response->assertOk();
        $response->assertViewIs('pay.show');
        $response->assertViewHas('pay');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $pay = pays::factory()->create();

        $response = $this->get(route('pays.edit', $pay));

        $response->assertOk();
        $response->assertViewIs('pay.edit');
        $response->assertViewHas('pay');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\paysController::class,
            'update',
            \App\Http\Requests\paysUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $pay = pays::factory()->create();
        $nom = fake()->word();

        $response = $this->put(route('pays.update', $pay), [
            'nom' => $nom,
        ]);

        $pay->refresh();

        $response->assertRedirect(route('pays.index'));
        $response->assertSessionHas('pay.id', $pay->id);

        $this->assertEquals($nom, $pay->nom);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $pay = pays::factory()->create();
        $pay = Pay::factory()->create();

        $response = $this->delete(route('pays.destroy', $pay));

        $response->assertRedirect(route('pays.index'));

        $this->assertModelMissing($pay);
    }
}
