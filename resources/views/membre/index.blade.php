@extends('layouts.app')

@section('title', 'Gestion des Membres')

@section('page-title', 'Gestion des Membres')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Membres</h1>
    <a href="{{ route('membres.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Ajouter un membre
    </a>
</div>

<div class="card shadow">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary">Liste des Membres</h6>
            </div>
            <div class="col-auto">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Rechercher un membre..." id="searchInput">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card-body">
        @if($membres->count() > 0)
            <div class="row" id="membersGrid">
                @foreach($membres as $membre)
                <div class="col-md-6 col-lg-4 mb-4 member-card">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <img src="{{ $membre->image ? asset('storage/' . $membre->image) : 'https://via.placeholder.com/150x150' }}" 
                                     class="rounded-circle img-fluid" 
                                     alt="{{ $membre->prenom }} {{ $membre->nom }}"
                                     style="width: 100px; height: 100px; object-fit: cover;">
                            </div>
                            
                            <h5 class="card-title">{{ $membre->prenom }} {{ $membre->nom }}</h5>
                            <p class="card-text text-muted">{{ $membre->designation }}</p>
                            
                            <div class="mb-3">
                                @if($membre->fb_link)
                                    <a href="{{ $membre->fb_link }}" target="_blank" class="btn btn-outline-primary btn-sm me-1">
                                        <i class="fab fa-facebook"></i>
                                    </a>
                                @endif
                                
                                @if($membre->tw_link)
                                    <a href="{{ $membre->tw_link }}" target="_blank" class="btn btn-outline-info btn-sm me-1">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                @endif
                                
                                @if($membre->ig_link)
                                    <a href="{{ $membre->ig_link }}" target="_blank" class="btn btn-outline-danger btn-sm">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                @endif
                            </div>
                            
                            <div class="btn-group w-100">
                                <a href="{{ route('membres.show', $membre->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Voir
                                </a>
                                <a href="{{ route('membres.edit', $membre->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Modifier
                                </a>
                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $membre->id }})">
                                    <i class="fas fa-trash"></i> Supprimer
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $membres->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                <p class="text-muted">Aucun membre trouvé</p>
                <a href="{{ route('membres.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Créer le premier membre
                </a>
            </div>
        @endif
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
                <p>Êtes-vous sûr de vouloir supprimer ce membre ?</p>
                <p class="text-muted">Cette action est irréversible.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Confirmer la suppression</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function confirmDelete(membreId) {
        const deleteForm = document.getElementById('deleteForm');
        deleteForm.action = `/membres/${membreId}`;
        
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }
    
    // Recherche en temps réel
    document.getElementById('searchInput').addEventListener('keyup', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const memberCards = document.querySelectorAll('.member-card');
        
        memberCards.forEach(card => {
            const memberName = card.querySelector('.card-title').textContent.toLowerCase();
            const memberDesignation = card.querySelector('.card-text').textContent.toLowerCase();
            
            if (memberName.includes(searchTerm) || memberDesignation.includes(searchTerm)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    });
</script>
@endpush

@push('styles')
<style>
    .member-card {
        transition: transform 0.2s;
    }
    
    .member-card:hover {
        transform: translateY(-5px);
    }
    
    .card {
        transition: box-shadow 0.2s;
    }
    
    .card:hover {
        box-shadow: 0 4px 8px rgba(0,0,0,0.1) !important;
    }
</style>
@endpush
@endsection