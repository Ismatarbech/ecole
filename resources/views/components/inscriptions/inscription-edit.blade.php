<div>

    {{-- =========================================================
        MESSAGE DE SUCCÈS
    ========================================================== --}}

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>
        </div>
    @endif


    {{-- =========================================================
        ETAPES
    ========================================================== --}}

    <div class="card mb-4">

        <div class="card-body">

            <div class="row align-items-center">

                {{-- ETAPE 1 --}}

                <div class="col-md-5">

                    <div class="d-flex align-items-center gap-2
                        {{ $step == 1 ? 'text-primary fw-bold' : 'text-success' }}">

                        <span class="badge
                            {{ $step == 1 ? 'bg-primary' : 'bg-success' }}">
                            1
                        </span>

                        Informations de l'élève

                    </div>

                </div>


            </div>

        </div>

    </div>



    {{-- =========================================================
        ETAPE 1 : INFORMATIONS ELEVE
    ========================================================== --}}

    @if ($step == 1)

        <div class="card">

            <div class="card-header">

                <h5 class="mb-0">
                    <i class="bi bi-person-vcard me-2"></i>
                    Modifier les informations de l'élève
                </h5>

            </div>


            <div class="card-body">

                <div class="row">


                    {{-- MATRICULE --}}

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Matricule
                        </label>

                        <input
                            type="text"
                            class="form-control @error('matricule') is-invalid @enderror"
                            wire:model="matricule"
                            readonly
                        >

                        @error('matricule')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- NOM --}}

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Nom <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            class="form-control @error('nom') is-invalid @enderror"
                            wire:model="nom"
                            placeholder="Nom"
                        >

                        @error('nom')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- PRENOM --}}

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Prénom <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            class="form-control @error('prenom') is-invalid @enderror"
                            wire:model="prenom"
                            placeholder="Prénom"
                        >

                        @error('prenom')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- DATE NAISSANCE --}}

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Date de naissance <span class="text-danger">*</span>
                        </label>

                        <input
                            type="date"
                            class="form-control @error('naissance') is-invalid @enderror"
                            wire:model="naissance"
                        >

                        @error('naissance')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- SEXE --}}

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Sexe <span class="text-danger">*</span>
                        </label>

                        <select
                            class="form-select @error('sexe') is-invalid @enderror"
                            wire:model="sexe"
                        >

                            <option value="">
                                Sélectionner
                            </option>

                            <option value="M">
                                Masculin
                            </option>

                            <option value="F">
                                Féminin
                            </option>

                        </select>

                        @error('sexe')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- LIEU --}}

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Lieu de naissance
                        </label>

                        <input
                            type="text"
                            class="form-control @error('lieu') is-invalid @enderror"
                            wire:model="lieu"
                            placeholder="Lieu de naissance"
                        >

                        @error('lieu')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- CONTACT ELEVE --}}

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Contact élève
                        </label>

                        <input
                            type="text"
                            class="form-control @error('contact_eleve') is-invalid @enderror"
                            wire:model="contact_eleve"
                            placeholder="Contact élève"
                        >

                        @error('contact_eleve')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- CONTACT PARENT --}}

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Contact parent <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            class="form-control @error('contact_parent') is-invalid @enderror"
                            wire:model="contact_parent"
                            placeholder="Contact parent"
                        >

                        @error('contact_parent')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- =================================================
                        ANNEE SCOLAIRE
                    ================================================== --}}

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Année scolaire <span class="text-danger">*</span>
                        </label>

                        <select
                            class="form-select @error('annee_scolaire_id') is-invalid @enderror"
                            wire:model="annee_scolaire_id"
                        >

                            <option value="">
                                Sélectionner
                            </option>

                            @foreach ($annees as $annee)

                                <option value="{{ $annee->id }}">

                                    {{ $annee->scolaire_annee }}

                                </option>

                            @endforeach

                        </select>

                        @error('annee_scolaire_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- =================================================
                        NIVEAU
                    ================================================== --}}

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Niveau <span class="text-danger">*</span>
                        </label>

                        <select
                            class="form-select @error('niveau_id') is-invalid @enderror"
                            wire:model.live="niveau_id"
                        >

                            <option value="">
                                Sélectionner
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


                    {{-- =================================================
                        CLASSE
                    ================================================== --}}

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Classe <span class="text-danger">*</span>
                        </label>

                        <select
                            class="form-select @error('classe_id') is-invalid @enderror"
                            wire:model="classe_id"
                            @disabled(!$niveau_id)
                        >

                            <option value="">
                                Sélectionner
                            </option>

                            @foreach ($classes as $classe)

                                <option value="{{ $classe->id }}">

                                    {{ $classe->name }}

                                </option>

                            @endforeach

                        </select>

                        @error('classe_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- =================================================
                        PHOTO
                    ================================================== --}}

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Photo
                        </label>

                        <input
                            type="file"
                            class="form-control @error('photo') is-invalid @enderror"
                            wire:model="photo"
                            accept="image/*"
                        >

                        @error('photo')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror


                        {{-- PHOTO ACTUELLE --}}

                        @if ($anciennePhoto && !$photo)

                            <div class="mt-3">

                                <small class="text-muted d-block mb-2">
                                    Photo actuelle :
                                </small>

                                <img
                                    src="{{ asset('storage/' . $anciennePhoto) }}"
                                    alt="Photo actuelle"
                                    class="rounded border"
                                    width="110"
                                    height="110"
                                    style="object-fit: cover;"
                                >

                            </div>

                        @endif


                        {{-- APERCU NOUVELLE PHOTO --}}

                        @if ($photo)

                            <div class="mt-3">

                                <small class="text-success d-block mb-2">
                                    Nouvelle photo :
                                </small>

                                <img
                                    src="{{ $photo->temporaryUrl() }}"
                                    alt="Nouvelle photo"
                                    class="rounded border"
                                    width="110"
                                    height="110"
                                    style="object-fit: cover;"
                                >

                            </div>

                        @endif

                    </div>

                </div>


                {{-- ENREGISTRER LES INFORMATIONS --}}

                <div class="d-flex justify-content-end mt-4">

                    <button
                        type="button"
                        class="btn btn-primary"
                        wire:click="suivant"
                        wire:loading.attr="disabled"
                        wire:target="suivant"
                    >

                        <span wire:loading.remove wire:target="suivant">

                            Enregistrer les modifications

                        </span>


                        <span wire:loading wire:target="suivant">

                            <span class="spinner-border spinner-border-sm me-1"></span>

                            Enregistrement...

                        </span>

                    </button>

                </div>

            </div>

        </div>

    @endif



    {{-- =========================================================
        ETAPE 2 : PAIEMENT
    ========================================================== --}}

    @if (false)

        <div class="card">

            <div class="card-header">

                <h5 class="mb-0">

                    <i class="bi bi-credit-card me-2"></i>

                    Modifier le paiement

                </h5>

            </div>


            <div class="card-body">


                {{-- =================================================
                    RESUME ELEVE
                ================================================== --}}

                <div class="alert alert-primary">

                    <div class="row">

                        <div class="col-md-4">

                            <strong>
                                Matricule :
                            </strong>

                            {{ $matricule }}

                        </div>


                        <div class="col-md-4">

                            <strong>
                                Élève :
                            </strong>

                            {{ $nom }} {{ $prenom }}

                        </div>


                        <div class="col-md-4">

                            <strong>
                                Classe :
                            </strong>

                            @php
                                $classeSelectionnee = $classes->firstWhere(
                                    'id',
                                    $classe_id
                                );
                            @endphp

                            {{ $classeSelectionnee?->name ?? '-' }}

                        </div>

                    </div>

                </div>



                {{-- =================================================
                    INFORMATIONS PAIEMENT
                ================================================== --}}

                <div class="row">


                    {{-- FRAIS SCOLARITE --}}

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Frais de scolarité
                        </label>

                        <div class="input-group">

                            <input
                                type="text"
                                class="form-control"
                                value="{{ number_format((float) $frais_scolarite, 0, ',', ' ') }}"
                                readonly
                            >

                            <span class="input-group-text">
                                FCFA
                            </span>

                        </div>

                    </div>


                    {{-- MONTANT --}}

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Montant payé <span class="text-danger">*</span>
                        </label>

                        <div class="input-group">

                            <input
                                type="number"
                                class="form-control @error('montant') is-invalid @enderror"
                                wire:model.live="montant"
                                min="0"
                                max="{{ $frais_scolarite }}"
                            >

                            <span class="input-group-text">
                                FCFA
                            </span>

                        </div>

                        @error('montant')

                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- RESTE --}}

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Reste à payer
                        </label>

                        <div class="input-group">

                            <input
                                type="text"
                                class="form-control"
                                value="{{ number_format((float) $this->reste, 0, ',', ' ') }}"
                                readonly
                            >

                            <span class="input-group-text">
                                FCFA
                            </span>

                        </div>

                    </div>


                    {{-- MODE DE PAIEMENT --}}

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Mode de paiement <span class="text-danger">*</span>
                        </label>

                        <select
                            class="form-select @error('mode_paiement') is-invalid @enderror"
                            wire:model="mode_paiement"
                        >

                            <option value="Especes">
                                Espèces
                            </option>

                            <option value="Mobile Money">
                                Mobile Money
                            </option>

                            <option value="Virement">
                                Virement
                            </option>

                            <option value="Cheque">
                                Chèque
                            </option>

                        </select>

                        @error('mode_paiement')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- DATE PAIEMENT --}}

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Date du paiement <span class="text-danger">*</span>
                        </label>

                        <input
                            type="date"
                            class="form-control @error('date_paiement') is-invalid @enderror"
                            wire:model="date_paiement"
                        >

                        @error('date_paiement')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                </div>



                {{-- =================================================
                    RESUME FINANCIER
                ================================================== --}}

                <div class="card bg-light mt-3">

                    <div class="card-body">

                        <h6 class="mb-3">

                            <i class="bi bi-calculator me-2"></i>

                            Résumé du paiement

                        </h6>


                        <div class="d-flex justify-content-between">

                            <span>
                                Frais de scolarité
                            </span>

                            <strong>

                                {{ number_format(
                                    (float) $frais_scolarite,
                                    0,
                                    ',',
                                    ' '
                                ) }}

                                FCFA

                            </strong>

                        </div>


                        <div class="d-flex justify-content-between mt-2">

                            <span>
                                Montant payé
                            </span>

                            <strong>

                                {{ number_format(
                                    (float) $montant,
                                    0,
                                    ',',
                                    ' '
                                ) }}

                                FCFA

                            </strong>

                        </div>


                        <hr>


                        <div class="d-flex justify-content-between">

                            <strong>
                                Reste à payer
                            </strong>

                            <strong class="text-danger">

                                {{ number_format(
                                    (float) $this->reste,
                                    0,
                                    ',',
                                    ' '
                                ) }}

                                FCFA

                            </strong>

                        </div>

                    </div>

                </div>



                {{-- =================================================
                    BOUTONS
                ================================================== --}}

                <div class="d-flex justify-content-between mt-4">


                    {{-- PRECEDENT --}}

                    <button
                        type="button"
                        class="btn btn-secondary"
                        wire:click="precedent"
                        wire:loading.attr="disabled"
                        wire:target="precedent"
                    >

                        <i class="bi bi-arrow-left me-1"></i>

                        Précédent

                    </button>


                    {{-- ENREGISTRER --}}

                    <button
                        type="button"
                        class="btn btn-success"
                        wire:click="enregistrer"
                        wire:loading.attr="disabled"
                        wire:target="enregistrer"
                    >

                        <span
                            wire:loading.remove
                            wire:target="enregistrer"
                        >

                            <i class="bi bi-check-circle me-1"></i>

                            Enregistrer les modifications

                        </span>


                        <span
                            wire:loading
                            wire:target="enregistrer"
                        >

                            <span class="spinner-border spinner-border-sm me-1"></span>

                            Enregistrement...

                        </span>

                    </button>

                </div>

            </div>

        </div>

    @endif

</div>