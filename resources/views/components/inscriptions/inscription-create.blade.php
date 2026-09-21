<div>

{{-- ========================================================= --}}
{{-- MESSAGE --}}
{{-- ========================================================= --}}

@if (session()->has('success'))

    <div class="alert alert-success border-0 shadow-sm mb-4">

        <i class="bi bi-check-circle-fill me-2"></i>

        {{ session('success') }}

    </div>

@endif


@if (session()->has('error'))

    <div class="alert alert-danger border-0 shadow-sm mb-4">

        <i class="bi bi-exclamation-triangle-fill me-2"></i>

        {{ session('error') }}

    </div>

@endif



{{-- ========================================================= --}}
{{-- HEADER --}}
{{-- ========================================================= --}}

<div class="card border-0 shadow-sm mb-4 overflow-hidden">

    <div
        class="card-body text-white p-4"
        style="background: linear-gradient(135deg, #0d6efd, #6f42c1);"
    >

        <div class="d-flex align-items-center">

            <div
                class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center me-3 shadow"
                style="width: 55px; height: 55px; font-size: 25px;"
            >

                <i class="bi bi-pencil-square"></i>

            </div>


            <div>

                <h4 class="mb-1 fw-bold">

                    Nouvelle inscription

                </h4>

                <div class="opacity-75">

                    Enregistrement d'un nouvel élève

                </div>

            </div>

        </div>

    </div>

</div>



{{-- ========================================================= --}}
{{-- INDICATEUR ETAPES --}}
{{-- ========================================================= --}}

<div class="card border-0 shadow-sm mb-4">

    <div class="card-body p-4">

        <div class="row align-items-center text-center">


            {{-- ETAPE 1 --}}

            <div class="col">

                <div
                    class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center fw-bold shadow-sm
                    {{ $step >= 1 ? 'bg-primary text-white' : 'bg-light text-muted' }}"
                    style="width: 50px; height: 50px; font-size: 18px;"
                >

                    @if ($step > 1)

                        <i class="bi bi-check-lg"></i>

                    @else

                        1

                    @endif

                </div>


                <div
                    class="{{ $step >= 1 ? 'text-primary fw-bold' : 'text-muted' }}"
                >

                    Informations

                </div>

                <small class="text-muted">

                    Élève & scolarité

                </small>

            </div>



            {{-- LIGNE 1 --}}

            <div class="col-auto px-0">

                <div
                    style="width: 80px; height: 3px;"
                    class="rounded {{ $step >= 2 ? 'bg-primary' : 'bg-light' }}"
                ></div>

            </div>



            {{-- ETAPE 2 --}}

            <div class="col">

                <div
                    class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center fw-bold shadow-sm
                    {{ $step >= 2 ? 'bg-primary text-white' : 'bg-light text-muted' }}"
                    style="width: 50px; height: 50px; font-size: 18px;"
                >

                    @if ($step > 2)

                        <i class="bi bi-check-lg"></i>

                    @else

                        2

                    @endif

                </div>


                <div
                    class="{{ $step >= 2 ? 'text-primary fw-bold' : 'text-muted' }}"
                >

                    Paiement

                </div>

                <small class="text-muted">

                    Frais & règlement

                </small>

            </div>



            {{-- LIGNE 2 --}}

            <div class="col-auto px-0">

                <div
                    style="width: 80px; height: 3px;"
                    class="rounded {{ $step >= 3 ? 'bg-primary' : 'bg-light' }}"
                ></div>

            </div>



            {{-- ETAPE 3 --}}

            <div class="col">

                <div
                    class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center fw-bold shadow-sm
                    {{ $step >= 3 ? 'bg-primary text-white' : 'bg-light text-muted' }}"
                    style="width: 50px; height: 50px; font-size: 18px;"
                >

                    3

                </div>


                <div
                    class="{{ $step >= 3 ? 'text-primary fw-bold' : 'text-muted' }}"
                >

                    Confirmation

                </div>

                <small class="text-muted">

                    Photo & récapitulatif

                </small>

            </div>

        </div>

    </div>

</div>



{{-- ========================================================= --}}
{{-- ETAPE 1 : INFORMATIONS --}}
{{-- ========================================================= --}}

@if ($step == 1)

    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white border-0 pt-4 px-4">

            <div class="d-flex align-items-center">

                <div
                    class="bg-primary bg-opacity-10 text-primary rounded-3 d-flex align-items-center justify-content-center me-3"
                    style="width: 45px; height: 45px; font-size: 20px;"
                >

                    <i class="bi bi-person-vcard"></i>

                </div>


                <div>

                    <h5 class="mb-0 fw-bold">

                        Informations de l'élève

                    </h5>

                    <small class="text-muted">

                        Renseignez les informations personnelles et scolaires

                    </small>

                </div>

            </div>

        </div>



        <div class="card-body p-4">


            {{-- INFORMATIONS PERSONNELLES --}}

            <div class="mb-4">

                <div class="fw-bold text-primary mb-3 pb-2 border-bottom">

                    <i class="bi bi-person me-2"></i>

                    Informations personnelles

                </div>


                <div class="row">


                    {{-- NOM --}}

                    <div class="col-md-4 mb-3">

                        <label class="form-label fw-semibold">

                            Nom

                            <span class="text-danger">*</span>

                        </label>

                        <input
                            type="text"
                            class="form-control @error('nom') is-invalid @enderror"
                            wire:model="nom"
                            placeholder="Nom de l'élève"
                        >

                        @error('nom')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>



                    {{-- PRENOM --}}

                    <div class="col-md-4 mb-3">

                        <label class="form-label fw-semibold">

                            Prénom

                            <span class="text-danger">*</span>

                        </label>

                        <input
                            type="text"
                            class="form-control @error('prenom') is-invalid @enderror"
                            wire:model="prenom"
                            placeholder="Prénom de l'élève"
                        >

                        @error('prenom')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>



                    {{-- DATE NAISSANCE --}}

                    <div class="col-md-4 mb-3">

                        <label class="form-label fw-semibold">

                            Date de naissance

                            <span class="text-danger">*</span>

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

                        <label class="form-label fw-semibold">

                            Sexe

                            <span class="text-danger">*</span>

                        </label>

                        <select
                            class="form-select @error('sexe') is-invalid @enderror"
                            wire:model="sexe"
                        >

                            <option value="">

                                -- Sélectionner --

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

                        <label class="form-label fw-semibold">

                            Lieu de naissance

                            <span class="text-danger">*</span>

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



                    {{-- CONTACT PARENT --}}

                    <div class="col-md-4 mb-3">

                        <label class="form-label fw-semibold">

                            Contact parent

                        </label>

                        <input
                            type="text"
                            class="form-control @error('contact_parent') is-invalid @enderror"
                            wire:model="contact_parent"
                            placeholder="Numéro du parent"
                        >

                        @error('contact_parent')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                                        {{-- TUTEUR --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">
                            Nom du tuteur
                        </label>

                        <input
                            type="text"
                            class="form-control @error('tuteur') is-invalid @enderror"
                            wire:model="tuteur"
                            placeholder="Nom du tuteur"
                        >

                        @error('tuteur')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- NUMERO TUTEUR --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">
                            Numéro du tuteur
                        </label>

                        <input
                            type="text"
                            class="form-control @error('contact_tuteur') is-invalid @enderror"
                            wire:model="contact_tuteur"
                            placeholder="Numéro du tuteur"
                        >

                        @error('contact_tuteur')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>



                    {{-- DATE INSCRIPTION --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">
                            Date d'inscription
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="date"
                            class="form-control bg-light @error('date_inscription') is-invalid @enderror"
                            wire:model="date_inscription"
                            readonly
                        >

                        @error('date_inscription')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>

            </div>



            {{-- INFORMATIONS SCOLAIRES --}}

            <div>

                <div class="fw-bold text-primary mb-3 pb-2 border-bottom">

                    <i class="bi bi-mortarboard me-2"></i>

                    Informations scolaires

                </div>


                <div class="row">


                    {{-- ANNEE --}}

                    <div class="col-md-4 mb-3">

                        <label class="form-label fw-semibold">

                            Année scolaire

                            <span class="text-danger">*</span>

                        </label>

                        <select
                            class="form-select @error('annee_scolaire_id') is-invalid @enderror"
                            wire:model="annee_scolaire_id"
                        >

                            <option value="">

                                -- Sélectionner --

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



                    {{-- NIVEAU --}}

                    <div class="col-md-4 mb-3">

                        <label class="form-label fw-semibold">

                            Niveau

                            <span class="text-danger">*</span>

                        </label>

                        <select
                            class="form-select @error('niveau_id') is-invalid @enderror"
                            wire:model.live="niveau_id"
                        >

                            <option value="">

                                -- Sélectionner --

                            </option>

                            @foreach ($niveaux as $niveau)

                                <option value="{{ $niveau->id }}">

                                    {{ $niveau->libelle }}

                                    ({{ $niveau->code }})

                                </option>

                            @endforeach

                        </select>

                        @error('niveau_id')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>



                    {{-- CLASSE --}}

                    <div class="col-md-4 mb-3">

                        <label class="form-label fw-semibold">

                            Classe

                            <span class="text-danger">*</span>

                        </label>

                        <select
                            class="form-select @error('classe_id') is-invalid @enderror"
                            wire:model.live="classe_id"
                            {{ !$niveau_id ? 'disabled' : '' }}
                        >

                            <option value="">

                                -- Sélectionner --

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

                </div>

            </div>



            {{-- BOUTONS --}}

            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">

                <a
                    href="{{ route('inscription.index') }}"
                    class="btn btn-light border px-4"
                >

                    <i class="bi bi-arrow-left me-1"></i>

                    Annuler

                </a>


                <button
                    type="button"
                    class="btn btn-primary px-4 py-2 shadow-sm"
                    wire:click="suivant"
                    wire:loading.attr="disabled"
                >

                    <span
                        wire:loading.remove
                        wire:target="suivant"
                    >

                        Continuer

                        <i class="bi bi-arrow-right ms-1"></i>

                    </span>


                    <span
                        wire:loading
                        wire:target="suivant"
                    >

                        <span class="spinner-border spinner-border-sm me-2"></span>

                        Chargement...

                    </span>

                </button>

            </div>

        </div>

    </div>

@endif



{{-- ========================================================= --}}
{{-- ETAPE 2 : PAIEMENT --}}
{{-- ========================================================= --}}

@if ($step == 2)

    @php

        $montantActuel = floatval($montant ?? 0);

        $pourcentagePaye = $frais_scolarite > 0
            ? min(100, ($montantActuel / $frais_scolarite) * 100)
            : 0;

    @endphp


    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white border-0 pt-4 px-4">

            <div class="d-flex align-items-center">

                <div
                    class="bg-success bg-opacity-10 text-success rounded-3 d-flex align-items-center justify-content-center me-3"
                    style="width: 45px; height: 45px; font-size: 20px;"
                >

                    <i class="bi bi-cash-stack"></i>

                </div>


                <div>

                    <h5 class="mb-0 fw-bold">

                        Informations du paiement

                    </h5>

                    <small class="text-muted">

                        Renseignez le règlement des frais de scolarité

                    </small>

                </div>

            </div>

        </div>



        <div class="card-body p-4">


            {{-- SITUATION FINANCIERE --}}

            <div class="fw-bold text-success mb-3 pb-2 border-bottom">

                <i class="bi bi-wallet2 me-2"></i>

                Situation financière

            </div>


            <div class="row g-3 mb-4">


                {{-- FRAIS --}}

                <div class="col-md-4">

                    <div class="border rounded-3 p-3 h-100">

                        <small class="text-muted">

                            Frais de scolarité

                        </small>

                        <div class="fw-bold fs-5 mt-1 text-primary">

                            <i class="bi bi-mortarboard me-1"></i>

                            {{ number_format((float) $frais_scolarite, 0, ',', ' ') }}

                            <small class="text-muted">

                                FCFA

                            </small>

                        </div>

                    </div>

                </div>



                {{-- MONTANT PAYE --}}

                <div class="col-md-4">

                    <div class="border rounded-3 p-3 h-100">

                        <small class="text-muted">

                            Montant payé

                        </small>

                        <div class="fw-bold fs-5 mt-1 text-success">

                            <i class="bi bi-check-circle-fill me-1"></i>

                            {{ number_format((float) $montantActuel, 0, ',', ' ') }}

                            <small class="text-muted">

                                FCFA

                            </small>

                        </div>

                    </div>

                </div>



                {{-- RESTE --}}

                <div class="col-md-4">

                    <div class="border rounded-3 p-3 h-100">

                        <small class="text-muted">

                            Reste à payer

                        </small>

                        <div class="fw-bold fs-5 mt-1 text-danger">

                            <i class="bi bi-exclamation-circle-fill me-1"></i>

                            {{ number_format((float) $this->reste, 0, ',', ' ') }}

                            <small class="text-muted">

                                FCFA

                            </small>

                        </div>

                    </div>

                </div>

            </div>



            {{-- PROGRESSION --}}

            <div class="mb-4">

                <div class="d-flex justify-content-between mb-2">

                    <span class="fw-semibold">

                        <i class="bi bi-graph-up text-primary me-1"></i>

                        Progression du paiement

                    </span>

                    <span class="text-primary fw-bold">

                        {{ number_format($pourcentagePaye, 0) }} %

                    </span>

                </div>


                <div class="progress" style="height: 10px;">

                    <div
                        class="progress-bar"
                        role="progressbar"
                        style="width: {{ $pourcentagePaye }}%"
                    ></div>

                </div>

            </div>



            {{-- FORMULAIRE PAIEMENT --}}

            <div class="fw-bold text-primary mb-3 pb-2 border-bottom">

                <i class="bi bi-credit-card me-2"></i>

                Détails du règlement

            </div>


            <div class="row">


                {{-- MONTANT --}}

                <div class="col-md-4 mb-3">

                    <label class="form-label fw-semibold">

                        Montant payé

                        <span class="text-danger">*</span>

                    </label>

                    <input
                        type="number"
                        class="form-control @error('montant') is-invalid @enderror"
                        wire:model.live="montant"
                        min="0"
                        max="{{ $frais_scolarite }}"
                        placeholder="Saisissez le montant"
                    >

                    @error('montant')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror

                </div>



                {{-- MODE --}}

                <div class="col-md-4 mb-3">

                    <label class="form-label fw-semibold">

                        Mode de paiement

                        <span class="text-danger">*</span>

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



            {{-- DATE paiement --}}
<div class="col-md-4 mb-3">
    <label class="form-label fw-semibold">
        Date de paiement
        <span class="text-danger">*</span>
    </label>

    <input
        type="date"
        class="form-control bg-light @error('date_paiement') is-invalid @enderror"
        wire:model="date_paiement"
        readonly
    >

    @error('date_paiement')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

            </div>



            {{-- BOUTONS --}}

            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">

                <button
                    type="button"
                    class="btn btn-light border px-4"
                    wire:click="retour"
                >

                    <i class="bi bi-arrow-left me-1"></i>

                    Retour

                </button>


                <button
                    type="button"
                    class="btn btn-primary px-4 py-2 shadow-sm"
                    wire:click="allerRecapitulatif"
                >

                    Récapitulatif

                    <i class="bi bi-arrow-right ms-1"></i>

                </button>

            </div>

        </div>

    </div>

@endif



{{-- ========================================================= --}}
{{-- ETAPE 3 : PHOTO & RECAPITULATIF --}}
{{-- ========================================================= --}}

@if ($step == 3)

    @php

        $anneeSelectionnee = $annees->firstWhere(
            'id',
            $annee_scolaire_id
        );

        $niveauSelectionne = $niveaux->firstWhere(
            'id',
            $niveau_id
        );

        $classeSelectionnee = $classes->firstWhere(
            'id',
            $classe_id
        );

    @endphp


    <div class="row g-4">


        {{-- ========================================================= --}}
        {{-- PHOTO --}}
        {{-- ========================================================= --}}

        <div class="col-lg-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white border-0 pt-4 px-4">

                    <div class="d-flex align-items-center">

                        <div
                            class="bg-primary bg-opacity-10 text-primary rounded-3 d-flex align-items-center justify-content-center me-3"
                            style="width: 45px; height: 45px; font-size: 20px;"
                        >

                            <i class="bi bi-camera"></i>

                        </div>


                        <div>

                            <h5 class="mb-0 fw-bold">

                                Photo de l'élève

                            </h5>

                            <small class="text-muted">

                                Importer ou utiliser la webcam

                            </small>

                        </div>

                    </div>

                </div>



                <div
                    class="card-body text-center p-4"

                    x-data="{

                        mode: 'upload',

                        cameraActive: false,

                        stream: null,

                        uploading: false,


                        async startCamera() {

                            try {

                                this.stream =
                                    await navigator.mediaDevices.getUserMedia({

                                        video: true,

                                        audio: false

                                    });


                                this.$refs.video.srcObject =
                                    this.stream;


                                this.cameraActive = true;

                            } catch (error) {

                                alert(
                                    'Impossible d’accéder à la webcam. Vérifiez les autorisations du navigateur.'
                                );

                                this.cameraActive = false;

                            }

                        },


                        stopCamera() {

                            if (this.stream) {

                                this.stream
                                    .getTracks()
                                    .forEach(
                                        track => track.stop()
                                    );

                                this.stream = null;

                            }


                            this.cameraActive = false;

                        },


                        capturePhoto() {

                            const video =
                                this.$refs.video;

                            const canvas =
                                this.$refs.canvas;


                            canvas.width =
                                video.videoWidth;

                            canvas.height =
                                video.videoHeight;


                            const context =
                                canvas.getContext('2d');


                            context.drawImage(
                                video,
                                0,
                                0,
                                canvas.width,
                                canvas.height
                            );


                            canvas.toBlob(

                                (blob) => {

                                    this.uploading = true;


                                    const file =
                                        new File(

                                            [blob],

                                            'photo-webcam-' +
                                            Date.now() +
                                            '.jpg',

                                            {
                                                type:
                                                    'image/jpeg'
                                            }

                                        );


                                    $wire.upload(

                                        'photo',

                                        file,


                                        () => {

                                            this.uploading =
                                                false;

                                            this.stopCamera();

                                            this.mode =
                                                'upload';

                                        },


                                        () => {

                                            this.uploading =
                                                false;

                                            alert(
                                                'Erreur lors de l’envoi de la photo.'
                                            );

                                        }

                                    );

                                },

                                'image/jpeg',

                                0.9

                            );

                        }

                    }"

                    x-init="$watch(
                        'mode',
                        value => {
                            if (value !== 'camera') {
                                stopCamera();
                            }
                        }
                    )"
                >


                    {{-- APERCU PHOTO --}}

                    @if ($photo)

                        <img
                            src="{{ $photo->temporaryUrl() }}"
                            class="rounded-circle shadow mb-4"
                            style="
                                width: 180px;
                                height: 180px;
                                object-fit: cover;
                                border: 5px solid #f8f9fa;
                            "
                            alt="Photo de l'élève"
                        >

                    @else

                        <div
                            class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto shadow-sm mb-4"
                            style="
                                width: 180px;
                                height: 180px;
                            "
                        >

                            <i
                                class="bi bi-person text-muted"
                                style="font-size: 70px;"
                            ></i>

                        </div>

                    @endif



                    {{-- CHOIX SOURCE --}}

                    <div
                        class="btn-group w-100 mb-3"
                        role="group"
                    >

                        <button
                            type="button"
                            class="btn"
                            :class="
                                mode === 'upload'
                                    ? 'btn-primary'
                                    : 'btn-outline-primary'
                            "
                            @click="
                                mode = 'upload';
                                stopCamera();
                            "
                        >

                            <i class="bi bi-folder2-open me-1"></i>

                            Ordinateur

                        </button>



                        <button
                            type="button"
                            class="btn"
                            :class="
                                mode === 'camera'
                                    ? 'btn-primary'
                                    : 'btn-outline-primary'
                            "
                            @click="
                                mode = 'camera';
                                startCamera();
                            "
                        >

                            <i class="bi bi-camera-video me-1"></i>

                            Webcam

                        </button>

                    </div>



                    {{-- UPLOAD --}}

                    <div
                        x-show="mode === 'upload'"
                        x-transition
                    >

                        <label
                            class="btn btn-outline-primary w-100 py-2"
                        >

                            <i class="bi bi-upload me-2"></i>

                            Choisir une photo

                            <input
                                type="file"
                                class="d-none"
                                wire:model="photo"
                                accept="image/*"
                            >

                        </label>

                    </div>



                    {{-- WEBCAM --}}

                    <div
                        x-show="mode === 'camera'"
                        x-transition
                        style="display: none;"
                    >

                        <div
                            class="border rounded-3 overflow-hidden bg-dark mb-3"
                        >

                            <video
                                x-ref="video"
                                autoplay
                                playsinline
                                muted
                                class="w-100"
                                style="
                                    min-height: 230px;
                                    object-fit: cover;
                                "
                            ></video>

                        </div>



                        <button
                            type="button"
                            class="btn btn-success w-100 py-2"
                            x-show="cameraActive"
                            :disabled="uploading"
                            @click="capturePhoto()"
                        >

                            <span x-show="!uploading">

                                <i class="bi bi-camera-fill me-2"></i>

                                Prendre la photo

                            </span>


                            <span x-show="uploading">

                                <span class="spinner-border spinner-border-sm me-2"></span>

                                Chargement...

                            </span>

                        </button>



                        <button
                            type="button"
                            class="btn btn-outline-danger w-100 mt-2"
                            x-show="cameraActive"
                            @click="
                                stopCamera();
                                mode = 'upload';
                            "
                        >

                            <i class="bi bi-x-circle me-1"></i>

                            Annuler

                        </button>

                    </div>



                    <canvas
                        x-ref="canvas"
                        class="d-none"
                    ></canvas>



                    @error('photo')

                        <div class="text-danger small mt-3">

                            <i class="bi bi-exclamation-circle me-1"></i>

                            {{ $message }}

                        </div>

                    @enderror



                    <div
                        wire:loading
                        wire:target="photo"
                        class="mt-3 text-primary"
                    >

                        <span class="spinner-border spinner-border-sm me-2"></span>

                        Chargement de la photo...

                    </div>

                </div>

            </div>

        </div>



        {{-- ========================================================= --}}
        {{-- RECAPITULATIF --}}
        {{-- ========================================================= --}}

        <div class="col-lg-8">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white border-0 pt-4 px-4">

                    <div class="d-flex align-items-center">

                        <div
                            class="bg-success bg-opacity-10 text-success rounded-3 d-flex align-items-center justify-content-center me-3"
                            style="
                                width: 45px;
                                height: 45px;
                                font-size: 20px;
                            "
                        >

                            <i class="bi bi-clipboard-check"></i>

                        </div>


                        <div>

                            <h5 class="mb-0 fw-bold">

                                Récapitulatif

                            </h5>

                            <small class="text-muted">

                                Vérifiez les informations avant d'enregistrer

                            </small>

                        </div>

                    </div>

                </div>



                <div class="card-body p-4">


                    {{-- INFORMATIONS ELEVE --}}

                    <div class="row g-3">


                        <div class="col-md-6">

                            <div class="p-3 bg-light rounded-3 h-100">

                                <small class="text-muted">

                                    Élève

                                </small>

                                <div class="fw-bold fs-5">

                                    {{ $nom }}

                                    {{ $prenom }}

                                </div>

                            </div>

                        </div>



                        <div class="col-md-6">

                            <div class="p-3 bg-light rounded-3 h-100">

                                <small class="text-muted">

                                    Sexe

                                </small>

                                <div class="fw-bold">

                                    @if ($sexe == 'M')

                                        <i class="bi bi-gender-male text-primary me-1"></i>

                                        Masculin

                                    @else

                                        <i class="bi bi-gender-female text-danger me-1"></i>

                                        Féminin

                                    @endif

                                </div>

                            </div>

                        </div>



                        <div class="col-md-4">

                            <div class="p-3 bg-light rounded-3 h-100">

                                <small class="text-muted">

                                    Année scolaire

                                </small>

                                <div class="fw-bold">

                                    <i class="bi bi-calendar3 text-primary me-1"></i>

                                    {{
                                        $anneeSelectionnee
                                        ?->scolaire_annee
                                        ?? '-'
                                    }}

                                </div>

                            </div>

                        </div>



                        <div class="col-md-4">

                            <div class="p-3 bg-light rounded-3 h-100">

                                <small class="text-muted">

                                    Niveau

                                </small>

                                <div class="fw-bold">

                                    <i class="bi bi-mortarboard text-primary me-1"></i>

                                    {{
                                        $niveauSelectionne
                                        ?->libelle
                                        ?? $niveauSelectionne
                                        ?->code
                                        ?? '-'
                                    }}

                                </div>

                            </div>

                        </div>



                        <div class="col-md-4">

                            <div class="p-3 bg-light rounded-3 h-100">

                                <small class="text-muted">

                                    Classe

                                </small>

                                <div class="fw-bold">

                                    <i class="bi bi-building text-primary me-1"></i>

                                    {{
                                        $classeSelectionnee
                                        ?->name
                                        ?? '-'
                                    }}

                                </div>

                            </div>

                        </div>

                    </div>



                    {{-- AUTRES INFORMATIONS --}}

                    <div class="row g-3 mt-1">


                        <div class="col-md-4">

                            <div class="border rounded-3 p-3 h-100">

                                <small class="text-muted">

                                    Date de naissance

                                </small>

                                <div class="fw-bold mt-1">

                                    {{ $naissance }}

                                </div>

                            </div>

                        </div>



                        <div class="col-md-4">

                            <div class="border rounded-3 p-3 h-100">

                                <small class="text-muted">

                                    Lieu de naissance

                                </small>

                                <div class="fw-bold mt-1">

                                    {{ $lieu }}

                                </div>

                            </div>

                        </div>



                        <div class="col-md-4">

                            <div class="border rounded-3 p-3 h-100">

                                <small class="text-muted">

                                    Contact parent

                                </small>

                                <div class="fw-bold mt-1">

                                    {{ $contact_parent ?: '-' }}

                                </div>

                            </div>

                        </div>

                         <div class="col-md-4">

                            <div class="border rounded-3 p-3 h-100">

                                <small class="text-muted">

                                    Nom de tuteur 

                                </small>

                                <div class="fw-bold mt-1">

                                    {{ $tuteur ?: '-' }}

                                </div>

                            </div>

                        </div>

                          <div class="col-md-4">

                            <div class="border rounded-3 p-3 h-100">

                                <small class="text-muted">

                                    Numero de tuteur 

                                </small>

                                <div class="fw-bold mt-1">

                                    {{ $contact_tuteur ?: '-' }}

                                </div>

                            </div>

                        </div>

                        

                    </div>



                    {{-- SITUATION FINANCIERE --}}

                    <div
                        class="d-flex align-items-center justify-content-between mt-4 mb-3 pt-3 border-top"
                    >

                        <div>

                            <h6 class="fw-bold mb-1">

                                <i class="bi bi-cash-stack text-success me-2"></i>

                                Situation financière

                            </h6>

                            <small class="text-muted">

                                Informations du paiement effectué.

                            </small>

                        </div>

                    </div>



                    <div class="row g-3">


                        {{-- FRAIS --}}

                        <div class="col-md-4">

                            <div class="border rounded-3 p-3 h-100">

                                <small class="text-muted">

                                    Frais de scolarité

                                </small>

                                <div class="fw-bold fs-5 mt-1 text-primary">

                                    <i class="bi bi-mortarboard me-1"></i>

                                    {{
                                        number_format(
                                            (float) $frais_scolarite,
                                            0,
                                            ',',
                                            ' '
                                        )
                                    }}

                                    <small class="text-muted">

                                        FCFA

                                    </small>

                                </div>

                            </div>

                        </div>



                        {{-- PAYE --}}

                        <div class="col-md-4">

                            <div class="border rounded-3 p-3 h-100">

                                <small class="text-muted">

                                    Montant payé

                                </small>

                                <div class="fw-bold fs-5 mt-1 text-success">

                                    <i class="bi bi-check-circle-fill me-1"></i>

                                    {{
                                        number_format(
                                            (float) $montant,
                                            0,
                                            ',',
                                            ' '
                                        )
                                    }}

                                    <small class="text-muted">

                                        FCFA

                                    </small>

                                </div>

                            </div>

                        </div>



                        {{-- RESTE --}}

                        <div class="col-md-4">

                            <div class="border rounded-3 p-3 h-100">

                                <small class="text-muted">

                                    Reste à payer

                                </small>

                                <div class="fw-bold fs-5 mt-1 text-danger">

                                    <i class="bi bi-exclamation-circle-fill me-1"></i>

                                    {{
                                        number_format(
                                            (float) $this->reste,
                                            0,
                                            ',',
                                            ' '
                                        )
                                    }}

                                    <small class="text-muted">

                                        FCFA

                                    </small>

                                </div>

                            </div>

                        </div>

                    </div>



                    {{-- MODE PAIEMENT --}}

                    <div class="mt-3">

                        <div class="border rounded-3 p-3 bg-light">

                            <small class="text-muted">

                                <i class="bi bi-credit-card me-1"></i>

                                Mode de paiement

                            </small>

                            <div class="fw-bold mt-1">

                                {{ $mode_paiement }}

                            </div>

                        </div>

                    </div>



                    {{-- DATE PAIEMENT --}}

                    <div class="mt-3">

                        <div class="border rounded-3 p-3 bg-light">

                            <small class="text-muted">

                                <i class="bi bi-calendar-check me-1"></i>

                                Date du paiement

                            </small>

                            <div class="fw-bold mt-1">

                                {{ $date_paiement }}

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>



    {{-- ========================================================= --}}
    {{-- BOUTONS --}}
    {{-- ========================================================= --}}

    <div class="card border-0 shadow-sm mt-4">

        <div
            class="card-body d-flex justify-content-between align-items-center p-3"
        >

            <button
                type="button"
                class="btn btn-light border px-4"
                wire:click="retour"
            >

                <i class="bi bi-arrow-left me-1"></i>

                Retour

            </button>



            <button
                type="button"
                class="btn btn-primary px-4 py-2 shadow-sm"
                wire:click="enregistrer"
                wire:loading.attr="disabled"
            >

                <span
                    wire:loading.remove
                    wire:target="enregistrer"
                >

                    <i class="bi bi-check-circle-fill me-2"></i>

                    Enregistrer l'inscription

                </span>


                <span
                    wire:loading
                    wire:target="enregistrer"
                >

                    <span class="spinner-border spinner-border-sm me-2"></span>

                    Enregistrement...

                </span>

            </button>

        </div>

    </div>

@endif

</div>