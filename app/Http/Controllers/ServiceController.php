<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Routing\Controller;
use App\Models\Membre;


class ServiceController extends Controller
{
    /**
     * Afficher la liste des services
     */
    public function index(): View
    {
        $services = Service::orderBy('nom')->paginate(10);
        
        return view('service.index', compact('services'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create(): View
    {
        $membres = Membre::all(); 

        return view('service.create', compact('membres'));
    }

    /**
     * Stocker un nouveau service
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|numeric|min:0',
            'duree' => 'required|integer|min:1',
            'actif' => 'boolean'
        ]);

        $validated['actif'] = $request->has('actif');

        Service::create($validated);

        return redirect()->route('services.index')
            ->with('success', 'Service créé avec succès!');
    }

    /**
     * Afficher un service spécifique
     */
    public function show(Service $service): View
    {
        return view('services.show', compact('service'));
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(Service $service): View
    {
        return view('services.edit', compact('service'));
    }

    /**
     * Mettre à jour un service
     */
    public function update(Request $request, Service $service): RedirectResponse
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|numeric|min:0',
            'duree' => 'required|integer|min:1',
            'actif' => 'boolean'
        ]);

        $validated['actif'] = $request->has('actif');

        $service->update($validated);

        return redirect()->route('services.index')
            ->with('success', 'Service mis à jour avec succès!');
    }

    /**
     * Supprimer un service
     */
    public function destroy(Service $service): RedirectResponse
    {
        $service->delete();

        return redirect()->route('services.index')
            ->with('success', 'Service supprimé avec succès!');
    }
}