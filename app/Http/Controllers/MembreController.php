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
    public function index(Request $request): View
    {
        $membres = Membre::paginate(10);

        return view('membre.index', [
            'membres' => $membres,
        ]);
    }

    public function create(Request $request): View
    {
        return view('membre.create');
    }

    public function store(MembreStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        $membre = Membre::create($data);

        $request->session()->put('membre.id', $membre->id);

        return redirect()->route('membres.index');
    }

    public function show(Request $request, Membre $membre): View
    {
        return view('membre.show', [
            'membre' => $membre,
        ]);
    }
    public function edit(Request $request, Membre $membre): View
    {
        return view('membre.edit', [
            'membre' => $membre,
        ]);
    }

    public function update(MembreUpdateRequest $request, Membre $membre): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        $membre->update($data);

        session()->flash('membre.id', $membre->id);

        return redirect()->route('membres.index');
    }

    public function destroy(Request $request, Membre $membre): RedirectResponse
    {
        $membre->delete();

        return redirect()->route('membres.index');
    }
}
