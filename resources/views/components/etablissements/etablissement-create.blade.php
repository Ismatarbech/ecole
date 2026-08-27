<div>

    {{-- =====================================================
        MESSAGE DE SUCCÈS
    ====================================================== --}}

    @if (session()->has('message'))

        <div class="alert alert-success alert-dismissible fade show"
             role="alert">

            <i class="bi bi-check-circle me-1"></i>

            {{ session('message') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close">
            </button>

        </div>

    @endif


    {{-- =====================================================
        CARD
    ====================================================== --}}

    <div class="card">

        <div class="card-body">

            <h5 class="card-title">
                Ajouter un établissement
            </h5>


            {{-- =================================================
                FORMULAIRE
            ================================================== --}}

            <form wire:submit="enregistrer">

                {{-- ===============================
                    NOM
                ================================ --}}

                <div class="row mb-3">

                    <label
                        for="nom"
                        class="col-sm-2 col-form-label">

                        Nom de l'établissement

                    </label>

                    <div class="col-sm-10">

                        <input
                            type="text"
                            id="nom"
                            class="form-control"
                            wire:model="nom"
                            placeholder="Ex : Lycée Moderne de N'Djamena"
                        >

                        @error('nom')
                            <div class="text-danger mt-1">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                </div>


                {{-- ===============================
                    LOGO
                ================================ --}}

                <div class="row mb-3">

                    <label
                        for="logo"
                        class="col-sm-2 col-form-label">

                        Logo de l'établissement

                    </label>

                    <div class="col-sm-10">

                        <input
                            type="file"
                            id="logo"
                            class="form-control"
                            wire:model="logo"
                            accept=".jpg,.jpeg,.png,.webp"
                        >

                        @error('logo')
                            <div class="text-danger mt-1">
                                {{ $message }}
                            </div>
                        @enderror


                        {{-- =========================
                            CHARGEMENT
                        ========================== --}}

                        <div wire:loading wire:target="logo"
                             class="text-primary mt-2">

                            <i class="bi bi-arrow-repeat"></i>
                            Chargement du logo...

                        </div>


                        {{-- =========================
                            APERÇU DU LOGO
                        ========================== --}}

                        @if ($logo)

                            <div class="mt-3">

                                <p class="mb-2">
                                    Aperçu :
                                </p>

                                <img
                                    src="{{ $logo->temporaryUrl() }}"
                                    alt="Aperçu du logo"
                                    width="120"
                                    height="120"
                                    style="object-fit: cover;"
                                    class="rounded border"
                                >

                            </div>

                        @endif

                    </div>

                </div>


                {{-- ===============================
                    BOUTON
                ================================ --}}

                <div class="row mb-3">

                    <label class="col-sm-2 col-form-label">
                    </label>

                    <div class="col-sm-10">

                        <button
                            type="submit"
                            class="btn btn-primary"
                            wire:loading.attr="disabled"
                            wire:target="enregistrer">

                            <span
                                wire:loading.remove
                                wire:target="enregistrer">

                                <i class="bi bi-save"></i>
                                Enregistrer

                            </span>

                            <span
                                wire:loading
                                wire:target="enregistrer">

                                <span
                                    class="spinner-border spinner-border-sm"
                                    role="status">
                                </span>

                                Enregistrement...

                            </span>

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

</div>