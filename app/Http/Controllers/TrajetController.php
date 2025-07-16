<?php

namespace App\Http\Controllers;

use App\Http\Requests\TrajetStoreRequest;
use App\Http\Requests\TrajetUpdateRequest;
use App\Models\Trajet;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TrajetController extends Controller
{
    public function index(Request $request): Response
    {
        $trajets = Trajet::all();

        return view('trajet.index', [
            'trajets' => $trajets,
        ]);
    }

    public function create(Request $request): Response
    {
        return view('trajet.create');
    }

    public function store(TrajetStoreRequest $request): Response
    {
        $trajet = Trajet::create($request->validated());

        $request->session()->flash('trajet.id', $trajet->id);

        return redirect()->route('trajets.index');
    }

    public function show(Request $request, Trajet $trajet): Response
    {
        return view('trajet.show', [
            'trajet' => $trajet,
        ]);
    }

    public function edit(Request $request, Trajet $trajet): Response
    {
        return view('trajet.edit', [
            'trajet' => $trajet,
        ]);
    }

    public function update(TrajetUpdateRequest $request, Trajet $trajet): Response
    {
        $trajet->update($request->validated());

        $request->session()->flash('trajet.id', $trajet->id);

        return redirect()->route('trajets.index');
    }

    public function destroy(Request $request, Trajet $trajet): Response
    {
        $trajet->delete();

        return redirect()->route('trajets.index');
    }
}
