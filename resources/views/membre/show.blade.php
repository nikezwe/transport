@extends('layouts.app')

@section('title', 'Détails du membre')

@section('page-title', 'Détails du membre')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>{{ $membre->prenom }} {{ $membre->nom }}</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('membres.index') }}">Membres</a></li>
            <li class="breadcrumb-item active">{{ $membre->prenom }} {{ $membre->nom }}</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-body text-center">
                <div class="mb-3">
                    <img src="{{ $membre->image ? asset('storage/' . $membre->image) : 'https://via.placeholder.com/200x200' }}" 
                         class="rounded-circle img-fluid" 
                         alt="{{ $membre->prenom }} {{ $membre->nom }}"
                         style="width: 200px; height: 200px; object-fit: cover;">
                </div>
                
                <h3 class="mb-1">{{ $membre->prenom }} {{ $membre->nom }}</h3>
                <p class="text-muted mb-3">{{ $membre->designation }}</p>
                
                <div class="mb-4">
                    @if($membre->fb_link)
                        <a href="{{ $membre->fb_link }}" target="_blank" class="btn btn-outline-primary btn-sm me-2">
                            <i class="fab fa-facebook"></i> Facebook
                        </a>
                    @endif
                    
                    @if($membre->tw_link)
                        <a href="{{ $membre->tw_link }}" target="_blank" class="btn btn-outline-info btn-sm me-2">
                            <i class="fab fa-twitter"></i> Twitter
                        </a>
                    @endif
                    
                    @if($membre->ig_link)
                        <a href="{{ $membre->ig_link }}" target="_blank" class="btn btn-outline-danger btn-sm">
                            <i class="fab fa-instagram"></i> Instagram
                        </a>
                    @endif
                    
                    @if(!$membre->fb_link && !$membre->tw_link && !$membre->ig_link)
                        <p class="text-muted small">Aucun réseau social configuré</p>
                    @endif
                </div>
                
                <div class="d-grid gap-2">
                    <a href="{{ route('membres.edit', $membre->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                        <i class="fas fa-trash"></i> Supprimer
                    </button>
                    <a href="{{ route('membres.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Retour à la liste
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Informations détaillées</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Nom</label>
                            <p class="fs-5">{{ $membre->nom }}</p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Prénom</label>
                            <p class="fs-5">{{ $membre->prenom }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label text-muted">Désignation</label>
                    <p class="fs-5">{{ $membre->designation }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label text-muted">Date de création</label>
                    <p class="fs-6">{{ $membre->created_at->format('d/m/Y à H:i') }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label text-muted">Dernière modification</label>
                    <p class="fs-6">{{ $membre->updated_at->format('d/m/Y à H:i') }}</p>
                </div>
            </div>
        </div>
        
        <div class="card shadow mt-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Réseaux sociaux</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="text-center p-3 border rounded">
                            <i class="fab fa-facebook fa-2x text-primary mb-2"></i>
                            <h6>Facebook</h6>
                            @if($membre->fb_link)
                                <a href="{{ $membre->fb_link }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    Visiter le profil
                                </a>
                            @else
                                <span class="text-muted">Non configuré</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="text-center p-3 border rounded">
                            <i class="fab fa-twitter fa-2x text-info mb-2"></i>
                            <h6>Twitter</h6>
                            @if($membre->tw_link)
                                <a href="{{ $membre->tw_link }}" target="_blank" class="btn btn-sm btn-outline-info">
                                    Visiter le profil
                                </a>
                            @else
                                <span class="text-muted">Non configuré</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="text-center p-3 border rounded">
                            <i class="fab fa-instagram fa-2x text-danger mb-2"></i>
                            <h6>Instagram</h6>
                            @if($membre->ig_link)
                                <a href="{{ $membre->ig_link }}" target="_blank" class="btn btn-sm btn-outline-danger">
                                    Visiter le profil
                                </a>
                            @else
                                <span class="text-muted">Non configuré</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmation de suppression -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                    <h5>Attention !</h5>
                    <p>Êtes-vous sûr de vouloir supprimer le membre <strong>{{ $membre->prenom }} {{ $membre->nom }}</strong> ?</p>
                    <p class="text-muted">Cette action est irréversible et supprimera définitivement toutes les données associées.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Annuler
                </button>
                <form action="{{ route('membres.destroy', $membre->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Confirmer la suppression
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .card {
        transition: all 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1) !important;
    }
    
    .btn {
        transition: all 0.3s ease;
    }
    
    .social-links a {
        transition: transform 0.2s ease;
    }
    
    .social-links a:hover {
        transform: scale(1.1);
    }
    
    .border {
        transition: border-color 0.3s ease;
    }
    
    .border:hover {
        border-color: #007bff !important;
    }
</style>
@endpush

@push('scripts')
<script>
    function confirmDelete() {
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }
    
    // Animation d'entrée pour les éléments
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.card');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                card.style.transition = 'all 0.5s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
    });
</script>
@endpush
@endsection