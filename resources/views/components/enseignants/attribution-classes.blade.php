<div class="w-2/2">

    @if (session()->has('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if (!$this->anneeActive)
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle me-1"></i>
            Aucune année scolaire active.
        </div>
    @else

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="bi bi-person-workspace me-1"></i>
                    Attribuer une classe et une matière
                </h5>

                <!-- General Form Elements -->
                <form wire:submit="attribuer">

                    {{-- ENSEIGNANT --}}
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Enseignant</label>
                        <div class="col-sm-10">
                            <flux:select wire:model="user_id" class="@error('user_id') is-invalid @enderror">
                                <option value="">Sélectionner un enseignant</option>
                                @foreach ($this->enseignants as $ens)
                                    <option value="{{ $ens->id }}">{{ $ens->name }}</option>
                                @endforeach
                            </flux:select>
                            @error('user_id')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- CLASSE --}}
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Classe</label>
                        <div class="col-sm-10">
                            <flux:select wire:model.live="classe_id" class="@error('classe_id') is-invalid @enderror">
                                <option value="">Sélectionner une classe</option>
                                @foreach ($this->classes as $classe)
                                    <option value="{{ $classe->id }}">
                                        {{ $classe->name ?? $classe->libelle }}
                                        @if ($classe->niveau)
                                            ({{ $classe->niveau->code ?? $classe->niveau->libelle ?? '' }})
                                        @endif
                                    </option>
                                @endforeach
                            </flux:select>
                            @error('classe_id')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- MATIERE (dépend de la classe) --}}
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Matière</label>
                        <div class="col-sm-10">
                            <flux:select wire:model="matiere_id"
                                         :disabled="$classe_id === ''"
                                         class="@error('matiere_id') is-invalid @enderror">
                                <option value="">
                                    {{ $classe_id === '' ? 'Choisir d\'abord une classe' : 'Sélectionner une matière' }}
                                </option>
                                @foreach ($this->matieres as $matiere)
                                    <option value="{{ $matiere->id }}">{{ $matiere->nom }}</option>
                                @endforeach
                            </flux:select>
                            @error('matiere_id')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror

                            @if ($classe_id !== '' && $this->matieres->isEmpty())
                                <div class="text-danger mt-1">
                                    Aucune matière pour le niveau de cette classe.
                                </div>
                            @endif

                            <div wire:loading wire:target="classe_id" class="text-muted small mt-1">
                                <span class="spinner-border spinner-border-sm me-1"></span>
                                Chargement des matières...
                            </div>
                        </div>
                    </div>

                    {{-- BOUTONS --}}
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="attribuer">
                                <span wire:loading.remove wire:target="attribuer">
                                    <i class="bi bi-check-circle me-1"></i> Enregistrer
                                </span>
                                <span wire:loading wire:target="attribuer">
                                    <span class="spinner-border spinner-border-sm me-1"></span> Enregistrement...
                                </span>
                            </button>

                            <a href="{{ route('enseignants.index') }}" class="btn btn-outline-secondary ms-2">
                                Annuler
                            </a>
                        </div>
                    </div>

                </form><!-- End General Form Elements -->

            </div>
        </div>
    @endif
</div>