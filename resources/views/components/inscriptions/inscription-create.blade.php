<div>

    {{-- =========================================================
        MESSAGE
    ========================================================== --}}

    @if (session()->has('success'))

        <div class="alert alert-success">

            <i class="bi bi-check-circle"></i>

            {{ session('success') }}

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

                    <div
                        class="
                            d-flex
                            align-items-center
                            gap-2

                            {{ $step == 1
                                ? 'text-primary fw-bold'
                                : 'text-success'
                            }}
                        "
                    >

                        <span
                            class="badge
                            {{ $step == 1
                                ? 'bg-primary'
                                : 'bg-success'
                            }}"
                        >
                            1
                        </span>

                        Informations de l'élève

                    </div>

                </div>


                {{-- PROGRESSION --}}

                <div class="col-md-2">

                    <div class="progress">

                        <div
                            class="progress-bar"
                            style="
                                width:
                                {{ $step == 1 ? '0%' : '100%' }}
                            "
                        >
                        </div>

                    </div>

                </div>


                {{-- ETAPE 2 --}}

                <div class="col-md-5">

                    <div
                        class="
                            d-flex
                            align-items-center
                            gap-2

                            {{ $step == 2
                                ? 'text-primary fw-bold'
                                : 'text-muted'
                            }}
                        "
                    >

                        <span
                            class="badge
                            {{ $step == 2
                                ? 'bg-primary'
                                : 'bg-secondary'
                            }}"
                        >
                            2
                        </span>

                        Paiement

                    </div>

                </div>

            </div>

        </div>

    </div>



    {{-- =========================================================
        ETAPE 1 : ELEVE
    ========================================================== --}}

    @if ($step == 1)

        <div class="card">

            <div class="card-header">

                <h5 class="mb-0">

                    <i class="bi bi-person-plus"></i>

                    Informations de l'élève

                </h5>

            </div>


            <div class="card-body">

                <div class="row">

                    {{-- NOM --}}

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Nom *
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            wire:model="nom"
                            placeholder="Nom"
                        >

                        @error('nom')

                            <small class="text-danger">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>


                    {{-- PRENOM --}}

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Prénom *
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            wire:model="prenom"
                            placeholder="Prénom"
                        >

                        @error('prenom')

                            <small class="text-danger">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>


                    {{-- DATE NAISSANCE --}}

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Date de naissance *
                        </label>

                        <input
                            type="date"
                            class="form-control"
                            wire:model="naissance"
                        >

                        @error('naissance')

                            <small class="text-danger">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>


                    {{-- SEXE --}}

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Sexe *
                        </label>

                        <select
                            class="form-select"
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

                            <small class="text-danger">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>


                    {{-- LIEU --}}

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Lieu de naissance
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            wire:model="lieu"
                            placeholder="Lieu"
                        >

                    </div>


                    {{-- CONTACT ELEVE --}}

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Contact élève
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            wire:model="contact_eleve"
                            placeholder="Contact élève"
                        >

                    </div>


                    {{-- CONTACT PARENT --}}

                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            Contact parent *
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            wire:model="contact_parent"
                            placeholder="Contact parent"
                        >

                        @error('contact_parent')

                            <small class="text-danger">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>


                    {{-- ANNEE SCOLAIRE --}}

                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            Année scolaire *
                        </label>

                        <select
                            class="form-select"
                            wire:model="annee_scolaire_id"
                        >

                            <option value="">
                                Sélectionner
                            </option>

                            @foreach(
                                \App\Models\AnneeScolaire::orderByDesc('id')->get()
                                as $annee
                            )

                                <option value="{{ $annee->id }}">

                                    {{ $annee->scolaire_annee }}

                                </option>

                            @endforeach

                        </select>

                        @error('annee_scolaire_id')

                            <small class="text-danger">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>


                    {{-- NIVEAU --}}

                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            Niveau *
                        </label>

                        <select
                            class="form-select"
                            wire:model.live="niveau_id"
                        >

                            <option value="">
                                Sélectionner
                            </option>

                            @foreach($niveaux as $niveau)

                                <option value="{{ $niveau->id }}">

                                    {{ $niveau->code }}

                                </option>

                            @endforeach

                        </select>

                        @error('niveau_id')

                            <small class="text-danger">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>


                    {{-- CLASSE --}}

                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            Classe *
                        </label>

                        <select
                            class="form-select"
                            wire:model="classe_id"
                            @disabled(!$niveau_id)
                        >

                            <option value="">
                                Sélectionner
                            </option>

                            @foreach($classes as $classe)

                                <option value="{{ $classe->id }}">

                                    {{ $classe->name }}

                                </option>

                            @endforeach

                        </select>

                        @error('classe_id')

                            <small class="text-danger">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>


                    {{-- PHOTO --}}

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Photo
                        </label>

                        <input
                            type="file"
                            class="form-control"
                            wire:model="photo"
                            accept="image/*"
                        >

                        @error('photo')

                            <small class="text-danger">
                                {{ $message }}
                            </small>

                        @enderror


                        @if ($photo)

                            <div class="mt-3">

                                <img
                                    src="{{ $photo->temporaryUrl() }}"
                                    width="120"
                                    height="120"
                                    class="rounded"
                                    style="object-fit: cover;"
                                >

                            </div>

                        @endif

                    </div>

                </div>


                {{-- SUIVANT --}}

                <div class="d-flex justify-content-end mt-4">

                    <button
                        type="button"
                        class="btn btn-primary"
                        wire:click="suivant"
                        wire:loading.attr="disabled"
                    >

                        <span
                            wire:loading.remove
                            wire:target="suivant"
                        >

                            Suivant

                            <i class="bi bi-arrow-right"></i>

                        </span>


                        <span
                            wire:loading
                            wire:target="suivant"
                        >

                            Vérification...

                        </span>

                    </button>

                </div>

            </div>

        </div>

    @endif



    {{-- =========================================================
        ETAPE 2 : PAIEMENT
    ========================================================== --}}

    @if ($step == 2)

        <div class="card">

            <div class="card-header">

                <h5 class="mb-0">

                    <i class="bi bi-credit-card"></i>

                    Paiement de l'inscription

                </h5>

            </div>


            <div class="card-body">


                {{-- RESUME ELEVE --}}

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

                            {{ $classes->firstWhere(
                                'id',
                                $classe_id
                            )?->name ?? '-' }}

                        </div>

                    </div>

                </div>



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
                                value="{{ number_format(
                                    $frais_scolarite,
                                    0,
                                    ',',
                                    ' '
                                ) }}"
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
                            Montant payé *
                        </label>

                        <div class="input-group">

                            <input
                                type="number"
                                class="form-control"
                                wire:model.live="montant"
                                min="0"
                                max="{{ $frais_scolarite }}"
                            >

                            <span class="input-group-text">
                                FCFA
                            </span>

                        </div>

                        @error('montant')

                            <small class="text-danger">
                                {{ $message }}
                            </small>

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
                            value="{{ number_format(
                                $this->reste,
                                0,
                                ',',
                                ' '
                            ) }}"
                            readonly
                        >

                            <span class="input-group-text">
                                FCFA
                            </span>

                        </div>

                    </div>


                    {{-- MODE PAIEMENT --}}

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Mode de paiement *
                        </label>

                        <select
                            class="form-select"
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

                            <small class="text-danger">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>


                    {{-- DATE PAIEMENT --}}

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Date du paiement *
                        </label>

                        <input
                            type="date"
                            class="form-control"
                            wire:model="date_paiement"
                        >
                        

                        @error('date_paiement')

                            <small class="text-danger">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>

                </div>



                {{-- RESUME FINANCIER --}}

                <div class="card bg-light mt-3">

                    <div class="card-body">

                        <h6>
                            Résumé du paiement
                        </h6>


                        <div class="d-flex justify-content-between">

                            <span>
                                Frais de scolarité
                            </span>

                            <strong>

                                {{ number_format(
                                    $frais_scolarite,
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
                                    $montant,
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
                                    $this->reste,
                                    0,
                                    ',',
                                    ' '
                                ) }}

                                FCFA

                            </strong>

                        </div>

                    </div>

                </div>



                {{-- BOUTONS --}}

                <div class="d-flex justify-content-between mt-4">


                    <button
                        type="button"
                        class="btn btn-secondary"
                        wire:click="precedent"
                    >

                        <i class="bi bi-arrow-left"></i>

                        Précédent

                    </button>


                    <button
                        type="button"
                        class="btn btn-success"
                        wire:click="enregistrer"
                        wire:loading.attr="disabled"
                    >

                        <span
                            wire:loading.remove
                            wire:target="enregistrer"
                        >

                            <i class="bi bi-check-circle"></i>

                            Confirmer

                        </span>


                        <span
                            wire:loading
                            wire:target="enregistrer"
                        >

                            Enregistrement...

                        </span>

                    </button>

                </div>

            </div>

        </div>

    @endif

</div>