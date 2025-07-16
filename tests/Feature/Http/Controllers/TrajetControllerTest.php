<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\PaysArrivee;
use App\Models\PaysDepart;
use App\Models\Trajet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\TrajetController
 */
final class TrajetControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $trajets = Trajet::factory()->count(3)->create();

        $response = $this->get(route('trajets.index'));

        $response->assertOk();
        $response->assertViewIs('trajet.index');
        $response->assertViewHas('trajets');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('trajets.create'));

        $response->assertOk();
        $response->assertViewIs('trajet.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\TrajetController::class,
            'store',
            \App\Http\Requests\TrajetStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $pays_depart = PaysDepart::factory()->create();
        $pays_arrivee = PaysArrivee::factory()->create();
        $ville_depart = fake()->word();
        $ville_arrivee = fake()->word();
        $date_depart = Carbon::parse(fake()->date());
        $date_arrivee = Carbon::parse(fake()->date());

        $response = $this->post(route('trajets.store'), [
            'pays_depart_id' => $pays_depart->id,
            'pays_arrivee_id' => $pays_arrivee->id,
            'ville_depart' => $ville_depart,
            'ville_arrivee' => $ville_arrivee,
            'date_depart' => $date_depart->toDateString(),
            'date_arrivee' => $date_arrivee->toDateString(),
        ]);

        $trajets = Trajet::query()
            ->where('pays_depart_id', $pays_depart->id)
            ->where('pays_arrivee_id', $pays_arrivee->id)
            ->where('ville_depart', $ville_depart)
            ->where('ville_arrivee', $ville_arrivee)
            ->where('date_depart', $date_depart)
            ->where('date_arrivee', $date_arrivee)
            ->get();
        $this->assertCount(1, $trajets);
        $trajet = $trajets->first();

        $response->assertRedirect(route('trajets.index'));
        $response->assertSessionHas('trajet.id', $trajet->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $trajet = Trajet::factory()->create();

        $response = $this->get(route('trajets.show', $trajet));

        $response->assertOk();
        $response->assertViewIs('trajet.show');
        $response->assertViewHas('trajet');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $trajet = Trajet::factory()->create();

        $response = $this->get(route('trajets.edit', $trajet));

        $response->assertOk();
        $response->assertViewIs('trajet.edit');
        $response->assertViewHas('trajet');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\TrajetController::class,
            'update',
            \App\Http\Requests\TrajetUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $trajet = Trajet::factory()->create();
        $pays_depart = PaysDepart::factory()->create();
        $pays_arrivee = PaysArrivee::factory()->create();
        $ville_depart = fake()->word();
        $ville_arrivee = fake()->word();
        $date_depart = Carbon::parse(fake()->date());
        $date_arrivee = Carbon::parse(fake()->date());

        $response = $this->put(route('trajets.update', $trajet), [
            'pays_depart_id' => $pays_depart->id,
            'pays_arrivee_id' => $pays_arrivee->id,
            'ville_depart' => $ville_depart,
            'ville_arrivee' => $ville_arrivee,
            'date_depart' => $date_depart->toDateString(),
            'date_arrivee' => $date_arrivee->toDateString(),
        ]);

        $trajet->refresh();

        $response->assertRedirect(route('trajets.index'));
        $response->assertSessionHas('trajet.id', $trajet->id);

        $this->assertEquals($pays_depart->id, $trajet->pays_depart_id);
        $this->assertEquals($pays_arrivee->id, $trajet->pays_arrivee_id);
        $this->assertEquals($ville_depart, $trajet->ville_depart);
        $this->assertEquals($ville_arrivee, $trajet->ville_arrivee);
        $this->assertEquals($date_depart, $trajet->date_depart);
        $this->assertEquals($date_arrivee, $trajet->date_arrivee);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $trajet = Trajet::factory()->create();

        $response = $this->delete(route('trajets.destroy', $trajet));

        $response->assertRedirect(route('trajets.index'));

        $this->assertModelMissing($trajet);
    }
}
