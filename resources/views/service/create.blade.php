@extends('layouts.app')

@section('title', 'Créer un service')

@section('page-title', 'Créer un service')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Créer un nouveau service</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('services.index') }}">Services</a></li>
            <li class="breadcrumb-item active">Créer</li>
        </ol>
    </nav>
</div>

<form action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data" id="createServiceForm">
    @csrf
    @include('service._form')
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
</style>
@endpush

@push('scripts')
<script>
    // Validation du formulaire avant soumission
    document.getElementById('createServiceForm').addEventListener('submit', function(e) {
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
        
        if (prixField.value && parseFloat(prixField.value) <= 0) {
            prixField.classList.add('is-invalid');
            isValid = false;
        }
        
        if (dureeField.value && parseInt(dureeField.value) <= 0) {
            dureeField.classList.add('is-invalid');
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
</script>
@endpush

@endsection