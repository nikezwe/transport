@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Créer un Nouveau Service</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="annonce_id" class="form-label">Annonce <span class="text-danger">*</span></label>
                            <select name="annonce_id" id="annonce_id" class="form-select @error('annonce_id') is-invalid @enderror" required>
                                <option value="">Sélectionner une annonce</option>
                                @foreach($annonces as $annonce)
                                    <option value="{{ $annonce->id }}" {{ old('annonce_id') == $annonce->id ? 'selected' : '' }}>
                                        Annonce #{{ $annonce->id }} - {{ $annonce->titre ?? 'Sans titre' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('annonce_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="type" class="form-label">Type de Service <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="type" 
                                   id="type" 
                                   class="form-control @error('type') is-invalid @enderror" 
                                   value="{{ old('type') }}" 
                                   placeholder="Ex: Réparation, Installation, Maintenance..."
                                   required>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Image <span class="text-danger">*</span></label>
                            <input type="file" 
                                   name="image" 
                                   id="image" 
                                   class="form-control @error('image') is-invalid @enderror" 
                                   accept="image/*"
                                   required>
                            <small class="form-text text-muted">
                                Formats acceptés: JPEG, PNG, JPG, GIF. Taille maximale: 2MB.
                            </small>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea name="description" 
                                      id="description" 
                                      class="form-control @error('description') is-invalid @enderror" 
                                      rows="4" 
                                      placeholder="Décrivez le service en détail..."
                                      required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('services.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Retour
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Créer le Service
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            // Créer un aperçu de l'image si nécessaire
            let preview = document.getElementById('image-preview');
            if (!preview) {
                preview = document.createElement('img');
                preview.id = 'image-preview';
                preview.className = 'img-thumbnail mt-2';
                preview.style.maxWidth = '200px';
                preview.style.maxHeight = '200px';
                e.target.parentNode.appendChild(preview);
            }
            preview.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endsection