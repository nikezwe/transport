<div class="row">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Informations du service</h6>
            </div>
            <div class="card-body">
                <!-- Membre -->
                <div class="mb-3">
                    <label for="membre_id" class="form-label">Membre <span class="text-danger">*</span></label>
                    <select class="form-select @error('membre_id') is-invalid @enderror" id="membre_id" name="membre_id" required>
                        <option value="">Sélectionner un membre</option>
                        @foreach($membres as $membre)
                            <option value="{{ $membre->id }}" {{ old('membre_id', $service->membre_id ?? '') == $membre->id ? 'selected' : '' }}>
                                {{ $membre->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('membre_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Trajet -->
                <div class="mb-3">
                    <label for="trajet_id" class="form-label">Trajet <span class="text-danger">*</span></label>
                    <select class="form-select @error('trajet_id') is-invalid @enderror" id="trajet_id" name="trajet_id" required>
                        <option value="">Sélectionner un trajet</option>
                        @foreach($trajets as $trajet)
                            <option value="{{ $trajet->id }}" {{ old('trajet_id', $service->trajet_id ?? '') == $trajet->id ? 'selected' : '' }}>
                                {{ $trajet->depart }} → {{ $trajet->arrivee }}
                            </option>
                        @endforeach
                    </select>
                    @error('trajet_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="4" required>{{ old('description', $service->description ?? '') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Date de départ -->
                <div class="mb-3">
                    <label for="date_depart" class="form-label">Date de départ <span class="text-danger">*</span></label>
                    <input type="datetime-local" class="form-control @error('date_depart') is-invalid @enderror" 
                           id="date_depart" name="date_depart" value="{{ old('date_depart', $service->date_depart ?? '') }}" required>
                    @error('date_depart')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Type -->
                <div class="mb-3">
                    <label for="type" class="form-label">Type de service</label>
                    <select class="form-select @error('type') is-invalid @enderror" id="type" name="type">
                        <option value="transport" {{ old('type', $service->type ?? '') === 'transport' ? 'selected' : '' }}>Transport</option>
                        <option value="livraison" {{ old('type', $service->type ?? '') === 'livraison' ? 'selected' : '' }}>Livraison</option>
                        <option value="autre" {{ old('type', $service->type ?? '') === 'autre' ? 'selected' : '' }}>Autre</option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Image -->
                <div class="mb-3">
                    <label for="image" class="form-label">
                        Image du service
                        @if(isset($service) && $service->image)
                            <small class="text-muted">(Laisser vide pour conserver l'image actuelle)</small>
                        @endif
                    </label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" 
                           id="image" name="image" accept="image/*">
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

    <!-- Colonne de droite : Prévisualisation -->
    <div class="col-md-4">
        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Prévisualisation</h6>
            </div>
            <div class="card-body text-center">
                <div id="imagePreview" class="mb-3">
                    @if(isset($service) && $service->image)
                        <img src="{{ asset('storage/' . $service->image) }}" 
                             class="img-fluid rounded" 
                             alt="Image actuelle"
                             style="width: 100%; height: 200px; object-fit: cover;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center rounded"
                             style="width: 100%; height: 200px;">
                            <i class="fas fa-image fa-3x text-muted"></i>
                        </div>
                    @endif
                </div>

                <h5 class="card-title" id="membrePreview">
                    {{ old('membre_id', $service->membre_id ?? '') ? 'Membre sélectionné' : 'Aucun membre' }}
                </h5>

                <p class="text-muted small" id="trajetPreview">
                    {{ old('trajet_id', $service->trajet_id ?? '') ? 'Trajet sélectionné' : 'Aucun trajet' }}
                </p>

                <p class="text-muted small" id="typePreview">
                    {{ old('type', $service->type ?? 'transport') }}
                </p>

                <p class="text-muted small" id="datePreview">
                    {{ old('date_depart', $service->date_depart ?? 'Date à définir') }}
                </p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="d-flex justify-content-between">
            <a href="{{ route('services.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour à la liste
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> {{ isset($service) ? 'Mettre à jour' : 'Créer' }} le service
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
                         class="img-fluid rounded" 
                         alt="Nouvelle image"
                         style="width: 100%; height: 200px; object-fit: cover;">
                `;
            };
            reader.readAsDataURL(file);
        }
    });

    // Mise à jour du membre
    function updateMembrePreview() {
        const membreSelect = document.getElementById('membre_id');
        const selectedOption = membreSelect.options[membreSelect.selectedIndex];
        const preview = document.getElementById('membrePreview');
        preview.textContent = selectedOption.text || 'Aucun membre';
    }

    // Mise à jour du trajet
    function updateTrajetPreview() {
        const trajetSelect = document.getElementById('trajet_id');
        const selectedOption = trajetSelect.options[trajetSelect.selectedIndex];
        const preview = document.getElementById('trajetPreview');
        preview.textContent = selectedOption.text || 'Aucun trajet';
    }

    // Mise à jour du type
    function updateTypePreview() {
        const type = document.getElementById('type').value || 'transport';
        document.getElementById('typePreview').textContent = type;
    }

    // Mise à jour de la date
    function updateDatePreview() {
        const date = document.getElementById('date_depart').value || 'Date à définir';
        document.getElementById('datePreview').textContent = date;
    }

    // Événements
    document.getElementById('membre_id').addEventListener('change', updateMembrePreview);
    document.getElementById('trajet_id').addEventListener('change', updateTrajetPreview);
    document.getElementById('type').addEventListener('change', updateTypePreview);
    document.getElementById('date_depart').addEventListener('change', updateDatePreview);

    // Initialisation
    document.addEventListener('DOMContentLoaded', function() {
        updateMembrePreview();
        updateTrajetPreview();
        updateTypePreview();
        updateDatePreview();
    });
</script>
@endpush