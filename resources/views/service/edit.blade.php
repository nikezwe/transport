@extends('layouts.app')

@section('title', 'Modifier le service')

@section('page-title', 'Modifier le service')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Modifier le service : {{ $service->nom }}</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('services.index') }}">Services</a></li>
            <li class="breadcrumb-item"><a href="{{ route('services.show', $service) }}">{{ $service->nom }}</a></li>
            <li class="breadcrumb-item active">Modifier</li>
        </ol>
    </nav>
</div>

<form action="{{ route('services.update', $service) }}" method="POST" enctype="multipart/form-data" id="editServiceForm">
    @csrf
    @method('PUT')
    
    @include('services._form')
</form>

@push('styles')
<style>
    .form-control:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    
    .is-invalid {
        border-color: #dc3545;
    }
    
    .invalid-feedback {
        display: block;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .required {
        color: #dc3545;
    }
    
    .img-thumbnail {
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        padding: 0.25rem;
    }
</style>
@endpush

@push('scripts')
<script>
    // Validation du formulaire avant soumission
    document.getElementById('editServiceForm').addEventListener('submit', function(e) {
        let isValid = true;
        const requiredFields = ['nom', 'description', 'prix', 'duree'];
        
        requiredFields.forEach(fieldName => {
            const field = document.getElementById(fieldName);
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });
        
        // Validation spécifique pour les champs numériques
        const prixField = document.getElementById('prix');
        const dureeField = document.getElementById('duree');
        const placesField = document.getElementById('places_disponibles');
        
        if (prixField.value && parseFloat(prixField.value) <= 0) {
            prixField.classList.add('is-invalid');
            isValid = false;
        }
        
        if (dureeField.value && parseInt(dureeField.value) <= 0) {
            dureeField.classList.add('is-invalid');
            isValid = false;
        }
        
        if (placesField.value && parseInt(placesField.value) <= 0) {
            placesField.classList.add('is-invalid');
            isValid = false;
        }
        
        if (!isValid) {
            e.preventDefault();
            alert('Veuillez remplir tous les champs obligatoires correctement.');
        }
    });
    
    // Nettoyage des classes d'erreur lors de la saisie
    document.querySelectorAll('.form-control').forEach(input => {
        input.addEventListener('input', function() {
            this.classList.remove('is-invalid');
        });
    });
    
    // Validation en temps réel pour les champs numériques
    document.getElementById('prix').addEventListener('input', function() {
        if (this.value && parseFloat(this.value) <= 0) {
            this.classList.add('is-invalid');
        } else {
            this.classList.remove('is-invalid');
        }
    });
    
    document.getElementById('duree').addEventListener('input', function() {
        if (this.value && parseInt(this.value) <= 0) {
            this.classList.add('is-invalid');
        } else {
            this.classList.remove('is-invalid');
        }
    });
    
    document.getElementById('places_disponibles').addEventListener('input', function() {
        if (this.value && parseInt(this.value) <= 0) {
            this.classList.add('is-invalid');
        } else {
            this.classList.remove('is-invalid');
        }
    });
    
    // Confirmation avant modification
    document.getElementById('editServiceForm').addEventListener('submit', function(e) {
        if (this.checkValidity()) {
            const confirmation = confirm('Êtes-vous sûr de vouloir modifier ce service ?');
            if (!confirmation) {
                e.preventDefault();
            }
        }
    });
</script>
@endpush

@endsection