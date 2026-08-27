<div>

    {{-- =====================================================
        TITRE
    ====================================================== --}}

    <div class="pagetitle">

        <h1>Créer un niveau</h1>

        <nav>

            <ol class="breadcrumb">

                <li class="breadcrumb-item">

                    <a href="{{ url('/dashbord') }}">
                        Accueil
                    </a>

                </li>

                <li class="breadcrumb-item">

                    <a href="{{ route('niveaux.index') }}">
                        Niveaux
                    </a>

                </li>

                <li class="breadcrumb-item active">
                    Ajouter
                </li>

            </ol>

        </nav>

    </div>


    {{-- =====================================================
        MESSAGE D'ERREUR
    ====================================================== --}}

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
            ></button>

        </div>

    @endif

    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif


    {{-- =====================================================
        FORMULAIRE
    ====================================================== --}}

    <div class="card">

        <div class="card-body">

            <h5 class="card-title">
                Ajouter un niveau
            </h5>


            <form wire:submit="save">


                {{-- =================================================
                    CODE
                ================================================== --}}

                <div class="row mb-3">

                    <label
                        for="code"
                        class="col-sm-2 col-form-label">

                        Code

                    </label>

                    <div class="col-sm-10">

                        <input
                            type="text"
                            id="code"
                            class="form-control"
                            wire:model="code"
                            placeholder="Ex : CP1"
                        >

                        @error('code')

                            <div class="text-danger mt-1">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                </div>


                {{-- =================================================
                    LIBELLÉ
                ================================================== --}}

                <div class="row mb-3">

                    <label
                        for="libelle"
                        class="col-sm-2 col-form-label">

                        Libellé

                    </label>

                    <div class="col-sm-10">

                        <input
                            type="text"
                            id="libelle"
                            class="form-control"
                            wire:model="libelle"
                            placeholder="Ex : Cours Préparatoire 1"
                        >

                        @error('libelle')

                            <div class="text-danger mt-1">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                </div>


                {{-- =================================================
                    MONTANT
                ================================================== --}}

                <div class="row mb-3">

                    <label
                        for="montant"
                        class="col-sm-2 col-form-label">

                        Montant

                    </label>

                    <div class="col-sm-10">

                        <div class="input-group">

                            <input
                                type="number"
                                id="montant"
                                class="form-control"
                                wire:model="montant"
                                min="0"
                                placeholder="Ex : 50000"
                            >

                            <span class="input-group-text">
                                FCFA
                            </span>

                        </div>

                        @error('montant')

                            <div class="text-danger mt-1">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                </div>


                {{-- =================================================
                    ANNÉE SCOLAIRE
                ================================================== --}}

                <div class="row mb-3">

                    <label
                        class="col-sm-2 col-form-label">

                        Année scolaire

                    </label>

                    <div class="col-sm-10">

                        @php
                            $anneeScolaire = \App\Models\AnneeScolaire::find($annee_scolaire_id);
                        @endphp

                        @if ($anneeScolaire)

                            <div class="form-control bg-light">

                                <i class="bi bi-calendar-check me-1"></i>

                                {{ $anneeScolaire->scolaire_annee }}

                                <span class="badge bg-success ms-2">
                                    Active
                                </span>

                            </div>

                        @else

                            <div class="alert alert-warning">

                                <i class="bi bi-exclamation-triangle me-1"></i>

                                Aucune année scolaire active.

                            </div>

                        @endif

                        @error('annee_scolaire_id')

                            <div class="text-danger mt-1">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                </div>


                {{-- =================================================
                    BOUTONS
                ================================================== --}}

                <div class="row mb-3">

                    <label class="col-sm-2 col-form-label">
                    </label>

                    <div class="col-sm-10">

                        <button
                            type="submit"
                            class="btn btn-primary"
                            wire:loading.attr="disabled"
                            wire:target="save"
                        >

                            <span
                                wire:loading.remove
                                wire:target="save"
                            >

                                <i class="bi bi-save"></i>

                                Enregistrer

                            </span>


                            <span
                                wire:loading
                                wire:target="save"
                            >

                                <span class="spinner-border spinner-border-sm me-1">
                                </span>

                                Enregistrement...

                            </span>

                        </button>


                        <a
                            href="{{ route('niveaux.index') }}"
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