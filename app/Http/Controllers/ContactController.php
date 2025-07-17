<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactStoreRequest;
use App\Http\Requests\ContactUpdateRequest;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * Afficher la liste des contacts avec pagination et recherche
     */
    public function index(Request $request): View
    {
        $query = Contact::query();
        
        // Recherche par nom ou email
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        }
        
        // Pagination avec 10 contacts par page
        $contacts = $query->paginate(10);

        return view('contact.index', [
            'contacts' => $contacts,
            'search' => $request->get('search'),
        ]);
    }

    /**
     * Afficher le formulaire de création
     */
    public function create(Request $request): View
    {
        return view('contact.create');
    }

    /**
     * Enregistrer un nouveau contact
     */
    public function store(ContactStoreRequest $request): RedirectResponse
    {
        try {
            $contact = Contact::create($request->validated());

            return redirect()
                ->route('contacts.show', $contact)
                ->with('success', 'Contact créé avec succès.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la création du contact.');
        }
    }

    /**
     * Afficher un contact spécifique
     */
    public function show(Request $request, Contact $contact): View
    {
        return view('contact.show', [
            'contact' => $contact,
        ]);
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(Request $request, Contact $contact): View
    {
        return view('contact.edit', [
            'contact' => $contact,
        ]);
    }

    /**
     * Mettre à jour un contact existant
     */
    public function update(ContactUpdateRequest $request, Contact $contact): RedirectResponse
    {
        try {
            $contact->update($request->validated());

            return redirect()
                ->route('contacts.show', $contact)
                ->with('success', 'Contact mis à jour avec succès.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la mise à jour du contact.');
        }
    }

    /**
     * Supprimer un contact
     */
    public function destroy(Request $request, Contact $contact): RedirectResponse
    {
        try {
            $contactName = $contact->name; // Sauvegarder le nom pour le message
            $contact->delete();

            return redirect()
                ->route('contacts.index')
                ->with('success', "Contact '{$contactName}' supprimé avec succès.");
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Une erreur est survenue lors de la suppression du contact.');
        }
    }

    /**
     * Supprimer plusieurs contacts en une fois
     */
    public function destroyMultiple(Request $request): RedirectResponse
    {
        $request->validate([
            'contacts' => 'required|array',
            'contacts.*' => 'exists:contacts,id',
        ]);

        try {
            $count = Contact::whereIn('id', $request->contacts)->delete();

            return redirect()
                ->route('contacts.index')
                ->with('success', "{$count} contact(s) supprimé(s) avec succès.");
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Une erreur est survenue lors de la suppression des contacts.');
        }
    }

    /**
     * Exporter les contacts en CSV
     */
    public function export(Request $request)
    {
        $contacts = Contact::all();
        
        $filename = 'contacts_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($contacts) {
            $file = fopen('php://output', 'w');
            
            // En-têtes CSV
            fputcsv($file, ['ID', 'Nom', 'Email', 'Téléphone', 'Date de création']);
            
            // Données
            foreach ($contacts as $contact) {
                fputcsv($file, [
                    $contact->id,
                    $contact->name,
                    $contact->email,
                    $contact->phone ?? '',
                    $contact->created_at->format('Y-m-d H:i:s'),
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}