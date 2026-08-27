<div>

    {{-- =========================================================
        MESSAGE DE SUCCÈS
    ========================================================== --}}

    @if (session()->has('success'))

        <div
            class="alert alert-success alert-dismissible fade show"
            role="alert"
        >
            <i class="bi bi-check-circle me-1"></i>

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close">
            </button>
        </div>

    @endif


    {{-- =========================================================
        MESSAGE D'ERREUR
    ========================================================== --}}

    @if (session()->has('error'))

        <div
            class="alert alert-danger alert-dismissible fade show"
            role="alert"
        >
            <i class="bi bi-exclamation-triangle me-1"></i>

            {{ session('error') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close">
            </button>
        </div>

    @endif


    {{-- =========================================================
        FORMULAIRE
    ========================================================== --}}

    <div class="w-2/2">

        <div class="card">

            <div class="card-body">

                <h5 class="card-title">
                    Ajouter une salle de classe
                </h5>


                <!-- General Form Elements -->

                <form wire:submit="saveClasse">

                    {{-- NOM DE LA CLASSE --}}
                    <div class="row mb-3">

                        <label
                            for="inputText"
                            class="col-sm-2 col-form-label"
                        >
                            Nom
                        </label>

                        <div class="col-sm-10">

                            <input
                                type="text"
                                class="form-control"
                                wire:model="name"
                            >

                            {{-- Erreur nom --}}
                            @error('name')

                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                    </div>


                    {{-- NIVEAU --}}
                    <div class="row mb-3">

                        <label
                            for="inputText"
                            class="col-sm-2 col-form-label"
                        >
                        </label>

                        <div class="col-sm-10">

                            <flux:select wire:model="niveau_id">

                                <option value="">
                                    Sélectionner un niveau
                                </option>

                                @foreach($anneecurrent as $annee)

                                    <option value="{{ $annee->id }}">
                                        {{ $annee->libelle }}
                                    </option>

                                @endforeach

                            </flux:select>


                            {{-- Erreur niveau --}}
                            @error('niveau_id')

                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                    </div>


                    {{-- BOUTON --}}
                    <div class="row mb-3">

                        <label class="col-sm-2 col-form-label">
                        </label>

                        <div class="col-sm-10">

                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                Enregistrer
                            </button>

                        </div>

                    </div>

                </form>

                <!-- End General Form Elements -->

            </div>

        </div>

    </div>

</div>