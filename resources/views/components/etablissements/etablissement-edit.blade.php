<div>

    {{-- =====================================================
        TITRE
    ====================================================== --}}

    <div class="pagetitle">

        <h1>Modifier l'établissement</h1>

        <nav>

            <ol class="breadcrumb">

                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">
                        Accueil
                    </a>
                </li>

                <li class="breadcrumb-item">

                    <a href="{{ route('etablissement.index') }}">
                        Etablissements
                    </a>

                </li>

                <li class="breadcrumb-item active">
                    Modifier
                </li>

            </ol>

        </nav>

    </div>


    {{-- =====================================================
        CARD
    ====================================================== --}}

    <div class="card">

        <div class="card-body">

            <h5 class="card-title">
                Modifier l'établissement
            </h5>


            <form wire:submit="mettreAJour">


                {{-- =================================================
                    NOM
                ================================================== --}}

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
                            placeholder="Nom de l'établissement"
                        >

                        @error('nom')

                            <div class="text-danger mt-1">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                </div>


                {{-- =================================================
                    ANCIEN LOGO
                ================================================== --}}

                @if ($ancienLogo)

                    <div class="row mb-3">

                        <label class="col-sm-2 col-form-label">

                            Logo actuel

                        </label>

                        <div class="col-sm-10">

                            <img
                                src="{{ asset('storage/' . $ancienLogo) }}"
                                alt="Logo actuel"
                                width="120"
                                height="120"
                                class="rounded border"
                                style="object-fit: cover;"
                            >

                        </div>

                    </div>

                @endif


                {{-- =================================================
                    NOUVEAU LOGO
                ================================================== --}}

                <div class="row mb-3">

                    <label
                        for="logo"
                        class="col-sm-2 col-form-label">

                        Nouveau logo

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


                        {{-- Chargement --}}
                        <div
                            wire:loading
                            wire:target="logo"
                            class="text-primary mt-2"
                        >

                            <span class="spinner-border spinner-border-sm">
                            </span>

                            Chargement du logo...

                        </div>


                        {{-- =================================================
                            APERÇU DU NOUVEAU LOGO
                        ================================================== --}}

                        @if ($logo)

                            <div class="mt-3">

                                <p class="mb-2">
                                    Aperçu du nouveau logo :
                                </p>

                                <img
                                    src="{{ $logo->temporaryUrl() }}"
                                    alt="Nouveau logo"
                                    width="120"
                                    height="120"
                                    class="rounded border"
                                    style="object-fit: cover;"
                                >

                            </div>

                        @endif

                    </div>

                </div>


                {{-- =================================================
                    BOUTON
                ================================================== --}}

                <div class="row mb-3">

                    <label class="col-sm-2 col-form-label">
                    </label>

                    <div class="col-sm-10">

                        <button
                            type="submit"
                            class="btn btn-primary"
                            wire:loading.attr="disabled"
                            wire:target="mettreAJour"
                        >

                            {{-- Bouton normal --}}
                            <span
                                wire:loading.remove
                                wire:target="mettreAJour"
                            >

                                <i class="bi bi-save"></i>

                                Enregistrer les modifications

                            </span>


                            {{-- Chargement --}}
                            <span
                                wire:loading
                                wire:target="mettreAJour"
                            >

                                <span
                                    class="spinner-border spinner-border-sm me-1">
                                </span>

                                Modification...

                            </span>

                        </button>


                        <a
                            href="{{ route('etablissement.index') }}"
                            class="btn btn-secondary"
                        >

                            Annuler

                        </a>

                    </div>

                </div>


            </form>

        </div>

    </div>

</div>