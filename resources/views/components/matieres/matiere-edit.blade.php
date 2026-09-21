<div>

    {{-- ========================================================= --}}
    {{-- MESSAGE SUCCÈS --}}
    {{-- ========================================================= --}}

    @if (session()->has('success'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
        </div>
    @endif


    {{-- ========================================================= --}}
    {{-- CARD --}}
    {{-- ========================================================= --}}

    <div class="card border-0 shadow-sm">

        {{-- ===================================================== --}}
        {{-- HEADER --}}
        {{-- ===================================================== --}}

        <div class="card-header bg-white border-0 p-4">

            <div class="d-flex justify-content-between align-items-center">

                <div>
                    <h4 class="mb-1">
                        <i class="bi bi-pencil-square me-2"></i>
                        Modifier la matière
                    </h4>

                    <small class="text-muted">
                        Modifier les informations de la matière
                    </small>
                </div>

            </div>

        </div>


        {{-- ===================================================== --}}
        {{-- BODY --}}
        {{-- ===================================================== --}}

        <div class="card-body p-4">

            <form wire:submit.prevent="save">

                {{-- ================================================= --}}
                {{-- NOM --}}
                {{-- ================================================= --}}

                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Nom de la matière
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        wire:model="nom"
                        class="form-control @error('nom') is-invalid @enderror"
                        placeholder="Exemple : Mathématiques"
                    >

                    @error('nom')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- ================================================= --}}
                {{-- COEFFICIENT --}}
                {{-- ================================================= --}}

                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Coefficient
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="number"
                        min="1"
                        max="10"
                        wire:model="coefficient"
                        class="form-control @error('coefficient') is-invalid @enderror"
                        placeholder="Exemple : 2"
                    >

                    @error('coefficient')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- ================================================= --}}
                {{-- NIVEAU --}}
                {{-- ================================================= --}}

                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Niveau
                        <span class="text-danger">*</span>
                    </label>

                    <select
                        wire:model="niveau_id"
                        class="form-select @error('niveau_id') is-invalid @enderror"
                    >

                        <option value="">
                            -- Sélectionner un niveau --
                        </option>

                        @foreach ($niveaux as $niveau)

                            <option value="{{ $niveau->id }}">
                                {{ $niveau->code }}
                            </option>

                        @endforeach

                    </select>

                    @error('niveau_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- ================================================= --}}
                {{-- BOUTONS --}}
                {{-- ================================================= --}}

                <div class="d-flex justify-content-end gap-2">

                    <button
                        type="button"
                        wire:click="cancel"
                        class="btn btn-secondary"
                    >
                        <i class="bi bi-x-lg me-1"></i>
                        Annuler
                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary"
                        wire:loading.attr="disabled"
                    >

                        <span wire:loading.remove>
                            <i class="bi bi-check-lg me-1"></i>
                            Enregistrer
                        </span>

                        <span wire:loading>
                            <span class="spinner-border spinner-border-sm me-1"></span>
                            Enregistrement...
                        </span>

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>