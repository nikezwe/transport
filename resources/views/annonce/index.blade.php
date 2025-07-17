@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- En-tête avec statistiques -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="h3">Gestion des Annonces</h1>
                <div>
                    <a href="{{ route('annonces.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Nouvelle Annonce
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $stats['total'] }}</h4>
                            <span>Total</span>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-clipboard-list fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $stats['en_attente'] }}</h4>
                            <span>En Attente</span>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $stats['en_cours'] }}</h4>
                            <span>En Cours</span>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-shipping-fast fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $stats['livre'] }}</h4>
                            <span>Livrées</span>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Filtres</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('annonces.index') }}">
                <div class="row">
                    <div class="col-md-2">
                        <select name="direction" class="form-select">
                            <option value="">Toutes directions</option>
                            @foreach(App\Models\Annonce::DIRECTIONS as $key => $label)
                                <option value="{{ $key }}" {{ request('direction') == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="statut" class="form-select">
                            <option value="">Tous statuts</option>
                            @foreach(App\Models\Annonce::STATUTS as $key => $label)
                                <option value="{{ $key }}" {{ request('statut') == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="urgence" class="form-select">
                            <option value="">Toutes urgences</option>
                            @foreach(App\Models\Annonce::URGENCES as $key => $label)
                                <option value="{{ $key }}" {{ request('urgence') == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="date_debut" class="form-control" value="{{ request('date_debut') }}" placeholder="Date début">
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="date_fin" class="form-control" value="{{ request('date_fin') }}" placeholder="Date fin">
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Rechercher...">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Filtrer
                        </button>
                        <a href="{{ route('annonces.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Réinitialiser
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif


    <!-- Table des annonces -->
    <div class="card">
        <div class="card-body">
            @if($annonces->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" id="selectAll">
                                </th>
                                <th>ID</th>
                                <th>Direction</th>
                                <th>Départ</th>
                                <th>Arrivée</th>
                                <th>Date Départ</th>
                                <th>Poids</th>
                                <th>Budget</th>
                                <th>Urgence</th>
                                <th>Statut</th>
                                <th>État</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($annonces as $annonce)
                                <tr class="{{ $annonce->is_expired ? 'table-danger' : '' }}">
                                    <td>
                                        <input type="checkbox" name="selected_annonces[]" value="{{ $annonce->id }}" class="annonce-checkbox">
                                    </td>
                                    <td>{{ $annonce->id }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $annonce->direction_label }}</span>
                                    </td>
                                    <td>{{ $annonce->ville_depart }}</td>
                                    <td>{{ $annonce->ville_arrivee }}</td>
                                    <td>{{ \Carbon\Carbon::parse($annonce->date_depart)->format('d/m/Y') }}</td>
                                    <td>{{ $annonce->poids_formate }}</td>
                                    <td>{{ $annonce->budget_formate }}</td>
                                    <td>
                                        <span class="badge bg-{{ $annonce->urgence_class }}">
                                            {{ $annonce->urgence_label }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $annonce->statut_class }}">
                                            {{ $annonce->statut_label }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $annonce->active ? 'success' : 'secondary' }}">
                                            {{ $annonce->active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('annonces.show', $annonce) }}" 
                                               class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('annonces.edit', $annonce) }}" 
                                               class="btn btn-sm btn-outline-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('annonces.toggle-active', $annonce) }}" 
                                                  method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-{{ $annonce->active ? 'secondary' : 'success' }}">
                                                    <i class="fas fa-{{ $annonce->active ? 'eye-slash' : 'eye' }}"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('annonces.destroy', $annonce) }}" 
                                                  method="POST" 
                                                  style="display: inline;"
                                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-center mt-4">
                    {{ $annonces->withQueryString()->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Aucune annonce trouvée.</p>
                    <a href="{{ route('annonces.create') }}" class="btn btn-primary">
                        Créer la première annonce
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection