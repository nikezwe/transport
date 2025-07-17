@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Modifier le Service</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('services.update', $service) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="annonce_id" class="form-label">Annonce <span class="text-danger">*</span></label>
                            <select name="annonce_id" id="annonce_id" class="form-select @error('annonce_id') is-invalid @enderror" required>
                                <option value="">Sélectionner une annonce</option>
                                @foreach($annonces as $annonce)
                                    <option value="{{ $annonce->id }}" 
                                            {{ (old('annonce_id') ?? $service->annonce_id) == $annonce->id ? 'selected' : '' }}>
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
                                   value="{{ old('type') ?? $service->type }}" 
                                   placeholder="Ex: Réparation, Installation, Maintenance..."
                                   required>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" 
                                   name="image" 
                                   id="image" 
                                   class="form-control @error('image') is-invalid @enderror" 
                                   accept="image/*">
                            <small class="form-text text-muted">
                                Formats acceptés: JPEG, PNG, JPG, GIF. Taille maximale: 2MB. 
                                Laissez vide pour conserver l'image actuelle.
                            </small>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            @if($service->image)
                                <div class="mt-2">
                                    <label class="form-label">Image actuelle:</label>
                                    <div>
                                        <img src="{{ $service->image_url }}" 
                                             alt="{{ $service->type }}" 
                                             class="img-thumbnail" 
                                             style="max-width: 150px; max-height: 150px;">
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea name="description" 
                                      id="description" 
                                      class="form-control @error('description') is-invalid @enderror" 
                                      rows="4" 
                                      placeholder="Décrivez le service en détail..."
                                      required>{{ old('description') ?? $service->description }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('services.show', $service) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Retour
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Mettre à jour
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
            // Créer un aperçu de la nouvelle image
            let preview = document.getElementById('new-image-preview');
            if (!preview) {
                preview = document.createElement('div');
                preview.id = 'new-image-preview';
                preview.className = 'mt-2';
                preview.innerHTML = '<label class="form-label">Nouvelle image:</label><br>';
                
                const img = document.createElement('img');
                img.className = 'img-thumbnail';
                img.style.maxWidth = '150px';
                img.style.maxHeight = '150px';
                preview.appendChild(img);
                
                e.target.parentNode.appendChild(preview);
            }
            preview.querySelector('img').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endsection