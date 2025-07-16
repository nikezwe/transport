@extends('layouts.app')

@section('title', 'Détail du service')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ $service->nom }}</h4>
                    @if($service->actif)
                        <span class="badge bg-success">Actif</span>
                    @else
                        <span class="badge bg-secondary">Inactif</span>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted">Description</h6>
                            <p>{{ $service->description }}</p>
                        </div>
                        <div class="col-md-3">
                            <h6 class="text-muted">Prix</h6>
                            <p class="h5 text-primary">{{ $service->prix_format }}</p>
                        </div>
                        <div class="col-md-3">
                            <h6 class="text-muted">Durée</h6>
                            <p class="h5 text-info">{{ $service->duree_format }}</p>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted">Créé le</h6>
                            <p>{{ $service->created_at->format('d/m/Y à H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Dernière modification</h6>
                            <p>{{ $service->updated_at->format('d/m/Y à H:i') }}</p>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('services.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Retour à la liste
                        </a>
                        <div>
                            <a href="{{ route('services.edit', $service) }}" class="btn btn-primary">
                                <i class="fas fa-edit"></i> Modifier
                            </a>
                            <form action="{{ route('services.destroy', $service) }}" 
                                  method="POST" 
                                  class="d-inline"
                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce service ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash"></i> Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection