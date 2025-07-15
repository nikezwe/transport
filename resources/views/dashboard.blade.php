@extends('layouts.app')

@section('title', 'Dashboard')

@section('page-header', 'Dashboard')

@section('page-actions')
    <button class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Nouveau
    </button>
@endsection

@section('content')
<div class="row">
    <!-- Statistiques -->
    <div class="col-md-3 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Total Services</h6>
                        <h3 class="mb-0">{{ $totalServices ?? 25 }}</h3>
                    </div>
                    <div class="text-primary">
                        <i class="fas fa-cogs fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Produits</h6>
                        <h3 class="mb-0">{{ $totalProduits ?? 156 }}</h3>
                    </div>
                    <div class="text-success">
                        <i class="fas fa-box fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Membres</h6>
                        <h3 class="mb-0">{{ $totalMembres ?? 89 }}</h3>
                    </div>
                    <div class="text-info">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Annonces</h6>
                        <h3 class="mb-0">{{ $totalAnnonces ?? 42 }}</h3>
                    </div>
                    <div class="text-warning">
                        <i class="fas fa-bullhorn fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Graphiques et tableaux -->
<div class="row">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">Activité Récente</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Utilisateur</th>
                                <th>Date</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Nouveau produit ajouté</td>
                                <td>John Doe</td>
                                <td>Il y a 2 heures</td>
                                <td><span class="badge bg-success">Terminé</span></td>
                            </tr>
                            <tr>
                                <td>Service mis à jour</td>
                                <td>Jane Smith</td>
                                <td>Il y a 4 heures</td>
                                <td><span class="badge bg-primary">En cours</span></td>
                            </tr>
                            <tr>
                                <td>Nouveau membre inscrit</td>
                                <td>Mike Johnson</td>
                                <td>Il y a 6 heures</td>
                                <td><span class="badge bg-success">Terminé</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">Notifications</h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <div class="list-group-item border-0 px-0">
                        <div class="d-flex">
                            <div class="me-3">
                                <i class="fas fa-bell text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Nouveau message</h6>
                                <p class="text-muted mb-0 small">Vous avez reçu un nouveau message</p>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item border-0 px-0">
                        <div class="d-flex">
                            <div class="me-3">
                                <i class="fas fa-exclamation-triangle text-warning"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Stock faible</h6>
                                <p class="text-muted mb-0 small">Certains produits sont en rupture</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection