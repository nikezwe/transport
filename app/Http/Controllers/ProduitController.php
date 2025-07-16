<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProduitStoreRequest;
use App\Http\Requests\ProduitUpdateRequest;
use App\Models\Produit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProduitController extends Controller
{
    public function index(Request $request): Response
    {
        $produits = Produit::all();

        return view('produit.index', [
            'produits' => $produits,
        ]);
    }

    public function create(Request $request): Response
    {
        return view('produit.create');
    }

    public function store(ProduitStoreRequest $request): Response
    {
        $produit = Produit::create($request->validated());

        $request->session()->flash('produit.id', $produit->id);

        return redirect()->route('produits.index');
    }

    public function show(Request $request, Produit $produit): Response
    {
        return view('produit.show', [
            'produit' => $produit,
        ]);
    }

    public function edit(Request $request, Produit $produit): Response
    {
        return view('produit.edit', [
            'produit' => $produit,
        ]);
    }

    public function update(ProduitUpdateRequest $request, Produit $produit): Response
    {
        $produit->update($request->validated());

        $request->session()->flash('produit.id', $produit->id);

        return redirect()->route('produits.index');
    }

    public function destroy(Request $request, Produit $produit): Response
    {
        $produit->delete();

        return redirect()->route('produits.index');
    }
}
