<?php

namespace App\Http\Controllers;

use App\Http\Requests\MembreStoreRequest;
use App\Http\Requests\MembreUpdateRequest;
use App\Models\Membre;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MembreController extends Controller
{
    public function index(Request $request): Response
    {
        $membres = Membre::all();

        return view('membre.index', [
            'membres' => $membres,
        ]);
    }

    public function create(Request $request): Response
    {
        return view('membre.create');
    }

    public function store(MembreStoreRequest $request): Response
    {
        $membre = Membre::create($request->validated());

        $request->session()->flash('membre.id', $membre->id);

        return redirect()->route('membres.index');
    }

    public function show(Request $request, Membre $membre): Response
    {
        return view('membre.show', [
            'membre' => $membre,
        ]);
    }

    public function edit(Request $request, Membre $membre): Response
    {
        return view('membre.edit', [
            'membre' => $membre,
        ]);
    }

    public function update(MembreUpdateRequest $request, Membre $membre): Response
    {
        $membre->update($request->validated());

        $request->session()->flash('membre.id', $membre->id);

        return redirect()->route('membres.index');
    }

    public function destroy(Request $request, Membre $membre): Response
    {
        $membre->delete();

        return redirect()->route('membres.index');
    }
}
