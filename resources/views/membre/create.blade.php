@extends('layouts.app')

@section('title', 'Créer un membre')

@section('page-title', 'Créer un membre')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Créer un nouveau membre</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('membres.index') }}">Membres</a></li>
            <li class="breadcrumb-item active">Créer</li>
        </ol>
    </nav>
</div>

<form action="{{ route('membres.store') }}" method="POST" enctype="multipart/form-data" id="createMembreForm">
    @csrf
    
    @include('membre._form')
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
</style>
@endpush

@push('scripts')
<script>
    // Validation du formulaire avant soumission
    document.getElementById('createMembreForm').addEventListener('submit', function(e) {
        let isValid = true;
        const requiredFields = ['nom', 'prenom', 'designation', 'image'];
        
        requiredFields.forEach(fieldName => {
            const field = document.getElementById(fieldName);
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('Veuillez remplir tous les champs obligatoires.');
        }
    });
    
    // Nettoyage des classes d'erreur lors de la saisie
    document.querySelectorAll('.form-control').forEach(input => {
        input.addEventListener('input', function() {
            this.classList.remove('is-invalid');
        });
    });
</script>
@endpush
@endsection