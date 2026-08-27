<div>

    {{-- =====================================================
        TITRE
    ====================================================== --}}

    <div class="pagetitle">

        <h1>Modifier un niveau</h1>

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

                    Modifier

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
        CARD
    ====================================================== --}}

    <div class="card">

        <div class="card-body">

            <h5 class="card-title">
                Modifier le niveau
            </h5>


            <form wire:submit="updateNiveau">


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
                        for="annee_scolaire_id"
                        class="col-sm-2 col-form-label">

                        Année scolaire

                    </label>

                    <div class="col-sm-10">

                        <select
                            id="annee_scolaire_id"
                            class="form-select"
                            wire:model="annee_scolaire_id"
                        >

                            <option value="">
                                -- Sélectionner une année --
                            </option>

                            @foreach(
                                \App\Models\AnneeScolaire::orderByDesc('id')->get()
                                as $annee
                            )

                                <option
                                    value="{{ $annee->id }}"
                                >

                                    {{ $annee->scolaire_annee }}

                                    @if ($annee->statut === 'active')
                                        - Active
                                    @endif

                                </option>

                            @endforeach

                        </select>


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


                        {{-- ENREGISTRER --}}

                        <button
                            type="submit"
                            class="btn btn-primary"
                            wire:loading.attr="disabled"
                            wire:target="updateNiveau"
                        >

                            <span
                                wire:loading.remove
                                wire:target="updateNiveau"
                            >

                                <i class="bi bi-save"></i>

                                Enregistrer

                            </span>


                            <span
                                wire:loading
                                wire:target="updateNiveau"
                            >

                                <span
                                    class="spinner-border spinner-border-sm me-1"
                                ></span>

                                Modification...

                            </span>

                        </button>


                        {{-- ANNULER --}}

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