<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Annonce;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AnnonceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Annonce::query();

        // Filtres
        if ($request->filled('direction')) {
            $query->where('direction', $request->direction);
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('urgence')) {
            $query->where('urgence', $request->urgence);
        }

        if ($request->filled('date_debut')) {
            $query->where('date_depart', '>=', $request->date_debut);
        }

        if ($request->filled('date_fin')) {
            $query->where('date_depart', '<=', $request->date_fin);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ville_depart', 'like', "%{$search}%")
                  ->orWhere('ville_arrivee', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $annonces = $query->orderBy('created_at', 'desc')->paginate(15);

        // Statistiques
        $stats = [
            'total' => Annonce::count(),
            'en_attente' => Annonce::where('statut', 'en_attente')->count(),
            'en_cours' => Annonce::where('statut', 'en_cours')->count(),
            'livre' => Annonce::where('statut', 'livre')->count(),
            'annule' => Annonce::where('statut', 'annule')->count(),
        ];

        return view('annonce.index', compact('annonces', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('annonce.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'direction' => 'required|in:chine-burundi,burundi-chine',
            'date_depart' => 'required|date|after_or_equal:today',
            'date_limite' => 'nullable|date|after_or_equal:date_depart',
            'ville_depart' => 'required|string|max:255',
            'ville_arrivee' => 'required|string|max:255',
            'adresse_collecte' => 'required|string',
            'adresse_livraison' => 'required|string',
            'poids' => 'required|numeric|min:0.01',
            'dimensions' => 'nullable|string|max:255',
            'valeur' => 'nullable|numeric|min:0',
            'nombre_colis' => 'required|integer|min:1',
            'description' => 'required|string',
            'budget' => 'nullable|numeric|min:0',
            'urgence' => 'required|in:normale,urgent,tres-urgent',
            'commentaires' => 'nullable|string',
            'statut' => 'required|in:en_attente,en_cours,livre,annule',
            'active' => 'boolean',
        ]);

        Annonce::create($request->all());

        return redirect()->route('annonces.index')
                        ->with('success', 'Annonce créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Annonce $annonce)
    {
        $annonce->load('services');
        return view('annonce.show', compact('annonce'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Annonce $annonce)
    {
        return view('annonce.edit', compact('annonce'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Annonce $annonce)
    {
        $request->validate([
            'direction' => 'required|in:chine-burundi,burundi-chine',
            'date_depart' => 'required|date',
            'date_limite' => 'nullable|date|after_or_equal:date_depart',
            'ville_depart' => 'required|string|max:255',
            'ville_arrivee' => 'required|string|max:255',
            'adresse_collecte' => 'required|string',
            'adresse_livraison' => 'required|string',
            'poids' => 'required|numeric|min:0.01',
            'dimensions' => 'nullable|string|max:255',
            'valeur' => 'nullable|numeric|min:0',
            'nombre_colis' => 'required|integer|min:1',
            'description' => 'required|string',
            'budget' => 'nullable|numeric|min:0',
            'urgence' => 'required|in:normale,urgent,tres-urgent',
            'commentaires' => 'nullable|string',
            'statut' => 'required|in:en_attente,en_cours,livre,annule',
            'active' => 'boolean',
        ]);

        $annonce->update($request->all());

        return redirect()->route('annonces.index')
                        ->with('success', 'Annonce mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Annonce $annonce)
    {
        $annonce->delete();

        return redirect()->route('annonces.index')
                        ->with('success', 'Annonce supprimée avec succès.');
    }

    /**
     * Toggle active status
     */
    public function toggleActive(Annonce $annonce)
    {
        // dd(!$annonce->active);
        $annonce->update(['active' => !$annonce->active]);

        $status = $annonce->active ? 'activée' : 'désactivée';
        return redirect()->back()
                        ->with('success', "Annonce {$status} avec succès.");
    }


}