@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Détails du Service</h4>
                    <div>
                        <a href="{{ route('services.edit', $service) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Modifier
                        </a>
                        <a href="{{ route('services.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            @if($service->image)
                                <img src="{{ $service->image_url }}" 
                                     alt="{{ $service->type }}" 
                                     class="img-fluid rounded shadow">
                            @else
                                <div class="text-center p-4 bg-light rounded">
                                    <i class="fas fa-image fa-3x text-muted"></i>
                                    <p class="text-muted mt-2">Pas d'image</p>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <h5 class="mb-3">{{ $service->type }}</h5>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Description:</label>
                                <p class="text-muted">{{ $service->description }}</p>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Annonce associée:</label>
                                @if($service->annonce)
                                    <div class="border rounded p-3 bg-light">
                                        <h6 class="mb-1">
                                            <span class="badge bg-primary">ID: {{ $service->annonce->id }}</span>
                                            {{ $service->annonce->titre ?? 'Sans titre' }}
                                        </h6>
                                        @if(isset($service->annonce->description))
                                            <p class="text-muted small mb-0">
                                                {{ Str::limit($service->annonce->description, 100) }}
                                            </p>
                                        @endif
                                    </div>
                                @else
                                    <p class="text-danger">Annonce supprimée ou introuvable</p>
                                @endif
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Créé le:</label>
                                    <p class="text-muted">{{ $service->created_at->format('d/m/Y à H:i') }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Modifié le:</label>
                                    <p class="text-muted">{{ $service->updated_at->format('d/m/Y à H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('services.index') }}" class="btn btn-secondary">
                            <i class="fas fa-list"></i> Liste des services
                        </a>
                        <div>
                            <a href="{{ route('services.edit', $service) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Modifier
                            </a>
                            <form action="{{ route('services.destroy', $service) }}" 
                                  method="POST" 
                                  style="display: inline;"
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