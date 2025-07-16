<?php
namespace App\Http\Controllers;

use App\Http\Requests\payStoreRequest;
use App\Http\Requests\payUpdateRequest;
use App\Models\Pays;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class paysController extends Controller
{
    public function index(Request $request): View
    {
        $pays = Pays::all();

        return view('pays.index', [
            'pays' => $pays,
        ]);
    }

    public function create(Request $request): View
    {
        return view('pays.create');
    }

    public function store(payStoreRequest $request): RedirectResponse
    {
        $pays = Pays::create($request->validated());

        session()->flash('pays.id', $pays->id);

        return redirect()->route('pays.index');
    }

    public function show(Request $request, Pays $pays): View
    {
        return view('pay.show', [
            'pays' => $pays,
        ]);
    }

    public function edit(Request $request, Pays $pays): View
    {
        return view('pays.edit', [
            'pays' => $pays,
        ]);
    }

    public function update(payUpdateRequest $request, Pays $pays): RedirectResponse
    {
        $pays->update($request->validated());

        session()->flash('pays.id', $pays->id);

        return redirect()->route('pays.index');
    }

    public function destroy(Request $request, Pays $pays): RedirectResponse
    {
        $pays->delete();

        return redirect()->route('pays.index');
    }
}