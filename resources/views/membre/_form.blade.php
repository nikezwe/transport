<div class="row">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Informations du membre</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nom') is-invalid @enderror" 
                                   id="nom" name="nom" value="{{ old('nom', $membre->nom ?? '') }}" required>
                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="prenom" class="form-label">Prénom <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('prenom') is-invalid @enderror" 
                                   id="prenom" name="prenom" value="{{ old('prenom', $membre->prenom ?? '') }}" required>
                            @error('prenom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="designation" class="form-label">Désignation <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('designation') is-invalid @enderror" 
                           id="designation" name="designation" value="{{ old('designation', $membre->designation ?? '') }}" 
                           placeholder="Ex: Développeur, Designer, Chef de projet..." required>
                    @error('designation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="image" class="form-label">
                        Photo de profil <span class="text-danger">*</span>
                        @if(isset($membre) && $membre->image)
                            <small class="text-muted">(Laisser vide pour conserver l'image actuelle)</small>
                        @endif
                    </label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" 
                           id="image" name="image" accept="image/*" 
                           {{ !isset($membre) ? 'required' : '' }}>
                    <div class="form-text">
                        Formats acceptés: JPEG, PNG, JPG, GIF. Taille maximale: 2MB
                    </div>
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <!-- Prévisualisation de l'image -->
        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Prévisualisation</h6>
            </div>
            <div class="card-body text-center">
                <div id="imagePreview" class="mb-3">
                    @if(isset($membre) && $membre->image)
                        <img src="{{ asset('storage/' . $membre->image) }}" 
                             class="rounded-circle img-fluid" 
                             alt="Photo actuelle"
                             style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto"
                             style="width: 150px; height: 150px;">
                            <i class="fas fa-user fa-3x text-muted"></i>
                        </div>
                    @endif
                </div>
                <p class="text-muted small">
                    <span id="fullNamePreview">{{ old('prenom', $membre->prenom ?? 'Prénom') }} {{ old('nom', $membre->nom ?? 'Nom') }}</span>
                </p>
                <p class="text-muted small">
                    <span id="designationPreview">{{ old('designation', $membre->designation ?? 'Désignation') }}</span>
                </p>
            </div>
        </div>
        
        <!-- Réseaux sociaux -->
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Réseaux sociaux</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="fb_link" class="form-label">
                        <i class="fab fa-facebook text-primary"></i> Facebook
                    </label>
                    <input type="url" class="form-control @error('fb_link') is-invalid @enderror" 
                           id="fb_link" name="fb_link" value="{{ old('fb_link', $membre->fb_link ?? '') }}" 
                           placeholder="https://facebook.com/username">
                    @error('fb_link')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="tw_link" class="form-label">
                        <i class="fab fa-twitter text-info"></i> Twitter
                    </label>
                    <input type="url" class="form-control @error('tw_link') is-invalid @enderror" 
                           id="tw_link" name="tw_link" value="{{ old('tw_link', $membre->tw_link ?? '') }}" 
                           placeholder="https://twitter.com/username">
                    @error('tw_link')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="ig_link" class="form-label">
                        <i class="fab fa-instagram text-danger"></i> Instagram
                    </label>
                    <input type="url" class="form-control @error('ig_link') is-invalid @enderror" 
                           id="ig_link" name="ig_link" value="{{ old('ig_link', $membre->ig_link ?? '') }}" 
                           placeholder="https://instagram.com/username">
                    @error('ig_link')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="d-flex justify-content-between">
            <a href="{{ route('membres.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour à la liste
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> {{ isset($membre) ? 'Mettre à jour' : 'Créer' }} le membre
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Prévisualisation de l'image
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('imagePreview');
                preview.innerHTML = `
                    <img src="${e.target.result}" 
                         class="rounded-circle img-fluid" 
                         alt="Nouvelle photo"
                         style="width: 150px; height: 150px; object-fit: cover;">
                `;
            };
            reader.readAsDataURL(file);
        }
    });
    
    // Mise à jour du nom complet en temps réel
    function updateFullNamePreview() {
        const prenom = document.getElementById('prenom').value || 'Prénom';
        const nom = document.getElementById('nom').value || 'Nom';
        document.getElementById('fullNamePreview').textContent = `${prenom} ${nom}`;
    }
    
    // Mise à jour de la désignation en temps réel
    function updateDesignationPreview() {
        const designation = document.getElementById('designation').value || 'Désignation';
        document.getElementById('designationPreview').textContent = designation;
    }
    
    // Événements pour la mise à jour en temps réel
    document.getElementById('prenom').addEventListener('input', updateFullNamePreview);
    document.getElementById('nom').addEventListener('input', updateFullNamePreview);
    document.getElementById('designation').addEventListener('input', updateDesignationPreview);
    
    // Validation des URLs
    function validateUrl(inputId) {
        const input = document.getElementById(inputId);
        const url = input.value;
        
        if (url && !url.startsWith('http://') && !url.startsWith('https://')) {
            input.setCustomValidity('L\'URL doit commencer par http:// ou https://');
        } else {
            input.setCustomValidity('');
        }
    }
    
    ['fb_link', 'tw_link', 'ig_link'].forEach(id => {
        document.getElementById(id).addEventListener('blur', () => validateUrl(id));
    });
</script>
@endpush