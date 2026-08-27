<div class="row justify-content-center">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Modifier l'année scolaire</h5>
                <p class="text-muted mb-4">Mettez à jour le nom de l'année scolaire sélectionnée.</p>

                <form wire:submit="updateAnnee">
                    <div class="row mb-3">
                        <label for="annee" class="col-sm-3 col-form-label">Année scolaire</label>
                        <div class="col-sm-9">
                            <input
                                id="annee"
                                type="text"
                                class="form-control @error('annee') is-invalid @enderror"
                                wire:model="annee"
                                placeholder="Ex. 2026-2027"
                                required
                            >
                            @error('annee')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Format conseillé : 2026 - 2027</div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('anneescolaire.index') }}" class="btn btn-light">Annuler</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check2 me-1"></i> Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>