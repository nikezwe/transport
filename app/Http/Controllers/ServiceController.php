<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Annonce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::with('annonce')->paginate(10);
        return view('service.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $annonces = Annonce::all();
        return view('service.create', compact('annonces'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'annonce_id' => 'required|exists:annonces,id',
            'type' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required|string|max:1000',
        ]);

        $imagePath = $request->file('image')->store('services', 'public');

        Service::create([
            'annonce_id' => $request->annonce_id,
            'type' => $request->type,
            'image' => $imagePath,
            'description' => $request->description,
        ]);

        return redirect()->route('services.index')
                        ->with('success', 'Service créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        $service->load('annonce');
        return view('service.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        $annonces = Annonce::all();
        return view('service.edit', compact('service', 'annonces'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'annonce_id' => 'required|exists:annonces,id',
            'type' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required|string|max:1000',
        ]);

        $data = [
            'annonce_id' => $request->annonce_id,
            'type' => $request->type,
            'description' => $request->description,
        ];

        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        $service->update($data);

        return redirect()->route('services.index')
                        ->with('success', 'Service mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        // Supprimer l'image associée
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }

        $service->delete();

        return redirect()->route('services.index')
                        ->with('success', 'Service supprimé avec succès.');
    }

    /**
     * Get services by annonce
     */
    public function getServicesByAnnonce($annonceId)
    {
        $services = Service::where('annonce_id', $annonceId)->get();
        return response()->json($services);
    }
}