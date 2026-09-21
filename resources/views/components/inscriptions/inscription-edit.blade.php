<div>

    {{-- =========================================================
        STYLE
    ========================================================== --}}
    <style>

        .edit-page {
            background: #f6f8fb;
            min-height: 100vh;
            padding: 25px 0 50px;
        }

        .page-card {
            border: 0;
            border-radius: 18px;
            box-shadow: 0 8px 30px rgba(0,0,0,.06);
        }

        .section-card {
            border: 0;
            border-radius: 16px;
            box-shadow: 0 5px 20px rgba(0,0,0,.05);
            overflow: hidden;
            background: #fff;
        }

        .section-header {
            padding: 18px 22px;
            border-bottom: 1px solid #eef1f5;
            background: #fff;
        }

        .section-title {
            font-weight: 700;
            color: #1f2937;
            margin: 0;
        }

        .section-subtitle {
            font-size: 13px;
            color: #8a94a6;
            margin-top: 3px;
        }

        .icon-box {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #eef4ff;
            color: #3b82f6;
            font-size: 20px;
            flex-shrink: 0;
        }

        .photo-small {
            width: 95px;
            height: 95px;
            object-fit: cover;
            border-radius: 14px;
            border: 3px solid #fff;
            box-shadow: 0 5px 18px rgba(0,0,0,.12);
        }

        .photo-placeholder {
            width: 95px;
            height: 95px;
            border-radius: 14px;
            background: #f0f2f5;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9aa3af;
            font-size: 38px;
            border: 2px dashed #d8dde5;
            flex-shrink: 0;
        }

        /* =========================================================
           WEBCAM
        ========================================================== */

        .webcam-box {
            width: 280px;
            max-width: 100%;
            background: #111827;
            border-radius: 12px;
            padding: 6px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0,0,0,.15);
        }

        .webcam-frame {
            position: relative;
            width: 100%;
            height: 210px;
            overflow: hidden;
            border-radius: 8px;
            background: #000;
        }

        .webcam-video {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            border-radius: 8px;
            background: #000;
            transform: scaleX(-1);
        }

        .webcam-guide {
            position: absolute;
            z-index: 5;
            top: 50%;
            left: 50%;
            width: 105px;
            height: 135px;
            transform: translate(-50%, -50%);
            border: 2px dashed rgba(255,255,255,.9);
            border-radius: 45%;
            box-shadow:
                0 0 0 9999px rgba(0,0,0,.10),
                0 0 12px rgba(0,0,0,.25);
            pointer-events: none;
        }

        .webcam-preview {
            width: 95px;
            height: 95px;
            object-fit: cover;
            border-radius: 14px;
            border: 3px solid #fff;
            box-shadow: 0 5px 18px rgba(0,0,0,.12);
        }

        .info-label {
            font-size: 12px;
            color: #8a94a6;
            text-transform: uppercase;
            letter-spacing: .3px;
            margin-bottom: 4px;
        }

        .info-value {
            font-size: 15px;
            font-weight: 600;
            color: #263238;
        }

        .edit-btn {
            border-radius: 9px;
            padding: 7px 11px;
            font-size: 13px;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            min-height: 43px;
            border-color: #dfe4ea;
        }

        .finance-box {
            border-radius: 14px;
            padding: 18px;
            height: 100%;
            background: #fff;
            border: 1px solid #edf0f4;
        }

        .finance-label {
            font-size: 12px;
            color: #8a94a6;
            margin-bottom: 6px;
        }

        .finance-value {
            font-size: 21px;
            font-weight: 800;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 7px 12px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 700;
        }

        .status-paid {
            background: #dff6e8;
            color: #198754;
        }

        .status-unpaid {
            background: #fff0f0;
            color: #dc3545;
        }

        .payment-row {
            border-bottom: 1px solid #edf0f4;
        }

        .payment-row:last-child {
            border-bottom: 0;
        }

        .sticky-summary {
            position: sticky;
            top: 20px;
        }

        .progress-step {
            display: flex;
            align-items: center;
            gap: 9px;
            font-size: 13px;
            color: #8a94a6;
        }

        .progress-number {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #edf1f5;
            font-weight: 700;
        }

        .progress-step.active .progress-number {
            background: #0d6efd;
            color: #fff;
        }

        .progress-step.active {
            color: #0d6efd;
            font-weight: 600;
        }

        .progress-line {
            width: 45px;
            height: 1px;
            background: #e0e4e8;
        }

        @media(max-width:767px) {

            .sticky-summary {
                position: static;
            }

            .progress-line {
                width: 15px;
            }

            .progress-step span:not(.progress-number) {
                display: none;
            }

            .webcam-box {
                width: 280px;
            }

            .webcam-frame {
                height: 210px;
            }

        }

    </style>


    {{-- =========================================================
        PAGE
    ========================================================== --}}
    <div class="edit-page">

        <div class="container-fluid px-3 px-lg-4">

            {{-- =====================================================
                HEADER
            ====================================================== --}}
            <div class="page-card bg-white p-3 p-lg-4 mb-4">

                <div class="d-flex flex-column flex-lg-row
                            justify-content-between
                            align-items-lg-center gap-3">

                    <div>

                        <div class="d-flex align-items-center gap-3">

                            <div class="icon-box">
                                <i class="bi bi-pencil-square"></i>
                            </div>

                            <div>

                                <h4 class="fw-bold mb-1">
                                    Modifier l'inscription
                                </h4>

                                <div class="text-muted small">
                                    Modification des informations de l'élève
                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="text-lg-end">

                        <div class="small text-muted">
                            Matricule
                        </div>

                        <div class="fw-bold fs-5">
                            {{ $matricule }}
                        </div>

                    </div>

                </div>


                {{-- ÉTAPES --}}
                <div class="d-flex align-items-center mt-4">

                    <div class="progress-step active">

                        <div class="progress-number">
                            1
                        </div>

                        <span>
                            Élève
                        </span>

                    </div>

                    <div class="progress-line mx-2"></div>

                    <div class="progress-step active">

                        <div class="progress-number">
                            2
                        </div>

                        <span>
                            Scolarité
                        </span>

                    </div>

                    <div class="progress-line mx-2"></div>

                    <div class="progress-step active">

                        <div class="progress-number">
                            3
                        </div>

                        <span>
                            Paiement
                        </span>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                SUCCESS
            ====================================================== --}}
            @if(session()->has('success'))

                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm">

                    <i class="bi bi-check-circle-fill me-2"></i>

                    {{ session('success') }}

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                    </button>

                </div>

            @endif


            {{-- =====================================================
                ERREURS
            ====================================================== --}}
            @if($errors->any())

                <div class="alert alert-danger border-0 shadow-sm">

                    <strong>
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Erreur
                    </strong>

                    <ul class="mb-0 mt-2">

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            <div class="row g-4">


                {{-- =================================================
                    COLONNE GAUCHE
                ================================================== --}}
                <div class="col-lg-8">


                    {{-- =================================================
                        ÉLÈVE
                    ================================================== --}}
                    <div class="section-card mb-4">

                        <div class="section-header">

                            <div class="d-flex justify-content-between align-items-center">

                                <div class="d-flex align-items-center gap-3">

                                    <div class="icon-box">
                                        <i class="bi bi-person"></i>
                                    </div>

                                    <div>

                                        <h5 class="section-title">
                                            Informations de l'élève
                                        </h5>

                                        <div class="section-subtitle">
                                            Identité et coordonnées
                                        </div>

                                    </div>

                                </div>


                                @if($editing !== 'eleve')

                                    <button
                                        type="button"
                                        wire:click="editBlock('eleve')"
                                        class="btn btn-outline-primary edit-btn">

                                        <i class="bi bi-pencil me-1"></i>

                                        Modifier

                                    </button>

                                @endif

                            </div>

                        </div>


                        <div class="card-body p-4">


                            {{-- =================================================
                                PHOTO
                            ================================================== --}}
                            <div class="mb-4">

                                <div class="d-flex align-items-center gap-3">

                                    @if($photo)

                                        <img
                                            src="{{ $photo->temporaryUrl() }}"
                                            class="photo-small"
                                            alt="Nouvelle photo">

                                    @elseif($photo_existante)

                                        <img
                                            src="{{ asset('storage/' . $photo_existante) }}"
                                            class="photo-small"
                                            alt="Photo élève">

                                    @else

                                        <div class="photo-placeholder">

                                            <i class="bi bi-person"></i>

                                        </div>

                                    @endif


                                    <div>

                                        <div class="fw-bold">
                                            Photo de l'élève
                                        </div>

                                        <div class="small text-muted">
                                            Choisir une photo ou utiliser la webcam.
                                        </div>

                                    </div>

                                </div>


                                {{-- BOUTON MODIFIER PHOTO --}}
                                @if($editing !== 'photo')

                                    <div class="mt-3">

                                        <button
                                            type="button"
                                            wire:click="editBlock('photo')"
                                            class="btn btn-sm btn-outline-secondary">

                                            <i class="bi bi-camera me-1"></i>

                                            Modifier la photo

                                        </button>

                                    </div>

                                @endif


                                {{-- =================================================
                                    MODIFICATION PHOTO
                                ================================================== --}}
                                @if($editing === 'photo')

                                    <div
                                        class="mt-4 p-3 rounded-3 bg-light"
                                        x-data="{
                                            mode: 'upload',
                                            cameraActive: false,
                                            stream: null,
                                            uploading: false,

                                            async startCamera() {

                                                try {

                                                    this.stream =
                                                        await navigator.mediaDevices.getUserMedia({
                                                            video: {
                                                                width: { ideal: 640 },
                                                                height: { ideal: 480 },
                                                                facingMode: 'user'
                                                            },
                                                            audio: false
                                                        });

                                                    this.$refs.video.srcObject =
                                                        this.stream;

                                                    this.cameraActive = true;

                                                } catch (error) {

                                                    console.error(error);

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

                                                if (this.$refs.video) {

                                                    this.$refs.video.srcObject = null;

                                                }

                                                this.cameraActive = false;

                                            },

                                            capturePhoto() {

                                                const video =
                                                    this.$refs.video;

                                                const canvas =
                                                    this.$refs.canvas;

                                                if (
                                                    !video.videoWidth ||
                                                    !video.videoHeight
                                                ) {

                                                    alert(
                                                        'La webcam n’est pas encore prête.'
                                                    );

                                                    return;

                                                }

                                                const size = 480;

                                                canvas.width = size;
                                                canvas.height = size;

                                                const context =
                                                    canvas.getContext('2d');

                                                const videoWidth =
                                                    video.videoWidth;

                                                const videoHeight =
                                                    video.videoHeight;

                                                const cropSize =
                                                    Math.min(
                                                        videoWidth,
                                                        videoHeight
                                                    );

                                                const sourceX =
                                                    (videoWidth - cropSize) / 2;

                                                const sourceY =
                                                    (videoHeight - cropSize) / 2;

                                                /*
                                                 * Le miroir est uniquement
                                                 * pour l'affichage.
                                                 *
                                                 * Pour la photo finale,
                                                 * on remet l'image normalement.
                                                 */

                                                context.drawImage(
                                                    video,
                                                    sourceX,
                                                    sourceY,
                                                    cropSize,
                                                    cropSize,
                                                    0,
                                                    0,
                                                    size,
                                                    size
                                                );

                                                canvas.toBlob(
                                                    (blob) => {

                                                        if (!blob) {

                                                            alert(
                                                                'Impossible de créer la photo.'
                                                            );

                                                            return;

                                                        }

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

                                                        /*
                                                         * IMPORTANT :
                                                         * même méthode que CREATE
                                                         */

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
                                                    0.90
                                                );

                                            }

                                        }"

                                        x-init="
                                            $watch(
                                                'mode',
                                                value => {

                                                    if (value !== 'camera') {
                                                        stopCamera();
                                                    }

                                                }
                                            )
                                        "
                                    >


                                        {{-- =================================================
                                            CHOIX SOURCE
                                        ================================================== --}}
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


                                        {{-- =================================================
                                            ORDINATEUR
                                        ================================================== --}}
                                        <div
                                            x-show="mode === 'upload'"
                                            x-transition
                                        >

                                            <label
                                                class="btn btn-primary w-100"
                                            >

                                                <i class="bi bi-folder2-open me-2"></i>

                                                Choisir une photo

                                                <input
                                                    type="file"
                                                    class="d-none"
                                                    wire:model="photo"
                                                    accept="image/jpeg,image/png,image/jpg,image/webp"
                                                >

                                            </label>


                                            @error('photo')

                                                <div class="text-danger small mt-2">

                                                    <i class="bi bi-exclamation-circle me-1"></i>

                                                    {{ $message }}

                                                </div>

                                            @enderror


                                            <div
                                                wire:loading
                                                wire:target="photo"
                                                class="small text-primary mt-2"
                                            >

                                                <span
                                                    class="spinner-border spinner-border-sm me-1"
                                                ></span>

                                                Chargement de la photo...

                                            </div>


                                            @if($photo)

                                                <div class="mt-3">

                                                    <div class="small text-muted mb-2">

                                                        Aperçu :

                                                    </div>

                                                    <img
                                                        src="{{ $photo->temporaryUrl() }}"
                                                        class="photo-small"
                                                        alt="Aperçu"
                                                    >

                                                </div>

                                            @endif

                                        </div>


                                        {{-- =================================================
                                            WEBCAM
                                        ================================================== --}}
                                        <div
                                            x-show="mode === 'camera'"
                                            x-transition
                                            style="display:none;"
                                        >

                                            <div class="webcam-box">

                                                <div class="webcam-frame">

                                                    <video
                                                        x-ref="video"
                                                        autoplay
                                                        playsinline
                                                        muted
                                                        class="webcam-video"
                                                    ></video>


                                                    {{-- CADRE VISAGE --}}
                                                    <div class="webcam-guide"></div>

                                                </div>

                                            </div>


                                            <div class="small text-muted mt-2">

                                                <i class="bi bi-info-circle me-1"></i>

                                                Placez le visage dans le petit cadre.

                                            </div>


                                            {{-- PRENDRE PHOTO --}}
                                            <button
                                                type="button"
                                                class="btn btn-success w-100 mt-3"
                                                x-show="cameraActive"
                                                :disabled="uploading"
                                                @click="capturePhoto()"
                                            >

                                                <span x-show="!uploading">

                                                    <i class="bi bi-camera-fill me-2"></i>

                                                    Prendre la photo

                                                </span>


                                                <span x-show="uploading">

                                                    <span
                                                        class="spinner-border spinner-border-sm me-2"
                                                    ></span>

                                                    Chargement...

                                                </span>

                                            </button>


                                            {{-- ANNULER WEBCAM --}}
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


                                        {{-- CANVAS CACHÉ --}}
                                        <canvas
                                            x-ref="canvas"
                                            class="d-none"
                                        ></canvas>


                                        {{-- =================================================
                                            ERREUR PHOTO
                                        ================================================== --}}
                                        @error('photo')

                                            <div class="text-danger small mt-3">

                                                <i class="bi bi-exclamation-circle me-1"></i>

                                                {{ $message }}

                                            </div>

                                        @enderror


                                        {{-- =================================================
                                            CHARGEMENT
                                        ================================================== --}}
                                        <div
                                            wire:loading
                                            wire:target="photo"
                                            class="mt-3 text-primary"
                                        >

                                            <span
                                                class="spinner-border spinner-border-sm me-2"
                                            ></span>

                                            Chargement de la photo...

                                        </div>


                                        {{-- =================================================
                                            ENREGISTRER PHOTO
                                        ================================================== --}}
                                        @if($photo)

                                            <div class="d-flex gap-2 mt-3">

                                                <button
                                                    type="button"
                                                    wire:click="savePhoto"
                                                    wire:loading.attr="disabled"
                                                    class="btn btn-success flex-fill"
                                                >

                                                    <span
                                                        wire:loading.remove
                                                        wire:target="savePhoto"
                                                    >

                                                        <i class="bi bi-check-lg me-1"></i>

                                                        Enregistrer la photo

                                                    </span>


                                                    <span
                                                        wire:loading
                                                        wire:target="savePhoto"
                                                    >

                                                        <span
                                                            class="spinner-border spinner-border-sm me-1"
                                                        ></span>

                                                        Enregistrement...

                                                    </span>

                                                </button>


                                                <button
                                                    type="button"
                                                    wire:click="cancel"
                                                    class="btn btn-light border"
                                                >

                                                    Annuler

                                                </button>

                                            </div>

                                        @endif


                                        {{-- ANNULER SANS PHOTO --}}
                                        @if(!$photo)

                                            <button
                                                type="button"
                                                wire:click="cancel"
                                                class="btn btn-light border w-100 mt-3"
                                            >

                                                Annuler

                                            </button>

                                        @endif

                                    </div>

                                @endif

                            </div>


                            <hr class="mb-4">


                            {{-- =================================================
                                AFFICHAGE INFORMATIONS
                            ================================================== --}}
                            @if($editing !== 'eleve')

                                <div class="row g-4">

                                    <div class="col-md-4">

                                        <div class="info-label">
                                            Nom
                                        </div>

                                        <div class="info-value">
                                            {{ $nom ?: '—' }}
                                        </div>

                                    </div>


                                    <div class="col-md-4">

                                        <div class="info-label">
                                            Prénom
                                        </div>

                                        <div class="info-value">
                                            {{ $prenom ?: '—' }}
                                        </div>

                                    </div>


                                    <div class="col-md-4">

                                        <div class="info-label">
                                            Sexe
                                        </div>

                                        <div class="info-value">

                                            @if($sexe === 'M')

                                                Masculin

                                            @elseif($sexe === 'F')

                                                Féminin

                                            @else

                                                —

                                            @endif

                                        </div>

                                    </div>


                                    <div class="col-md-4">

                                        <div class="info-label">
                                            Date de naissance
                                        </div>

                                        <div class="info-value">

                                            {{ $naissance
                                                ? \Carbon\Carbon::parse($naissance)->format('d/m/Y')
                                                : '—' }}

                                        </div>

                                    </div>


                                    <div class="col-md-4">

                                        <div class="info-label">
                                            Lieu de naissance
                                        </div>

                                        <div class="info-value">
                                            {{ $lieu ?: '—' }}
                                        </div>

                                    </div>


                                    <div class="col-md-4">

                                        <div class="info-label">
                                            Contact parent
                                        </div>

                                        <div class="info-value">
                                            {{ $contact_parent ?: '—' }}
                                        </div>

                                    </div>


                                    <div class="col-md-4">

                                        <div class="info-label">
                                            Date d'inscription
                                        </div>

                                        <div class="info-value">

                                            {{ $date_inscription
                                                ? \Carbon\Carbon::parse($date_inscription)->format('d/m/Y')
                                                : '—' }}

                                        </div>

                                    </div>

                                     <div class="col-md-4">

                                        <div class="info-label">
                                            Nom de tuteur
                                        </div>

                                        <div class="info-value">

                                             {{ $tuteur ?: '—' }}

                                        </div>

                                    </div>

                                     <div class="col-md-4">

                                        <div class="info-label">
                                            Numero de tuteur
                                        </div>

                                        <div class="info-value">
                                             {{ $contact_tuteur ?: '—' }}
                                           

                                        </div>

                                    </div>

                                </div>


                            @else

                                {{-- =================================================
                                    FORMULAIRE ÉLÈVE
                                ================================================== --}}
                                <div class="row g-3">

                                    <div class="col-md-4">

                                        <label class="form-label fw-semibold">
                                            Nom
                                        </label>

                                        <input
                                            type="text"
                                            wire:model="nom"
                                            class="form-control @error('nom') is-invalid @enderror"
                                        >

                                        @error('nom')

                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>

                                        @enderror

                                    </div>


                                    <div class="col-md-4">

                                        <label class="form-label fw-semibold">
                                            Prénom
                                        </label>

                                        <input
                                            type="text"
                                            wire:model="prenom"
                                            class="form-control @error('prenom') is-invalid @enderror"
                                        >

                                        @error('prenom')

                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>

                                        @enderror

                                    </div>


                                    <div class="col-md-4">

                                        <label class="form-label fw-semibold">
                                            Sexe
                                        </label>

                                        <select
                                            wire:model="sexe"
                                            class="form-select @error('sexe') is-invalid @enderror"
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


                                    <div class="col-md-4">

                                        <label class="form-label fw-semibold">
                                            Date de naissance
                                        </label>

                                        <input
                                            type="date"
                                            wire:model="naissance"
                                            class="form-control @error('naissance') is-invalid @enderror"
                                        >

                                        @error('naissance')

                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>

                                        @enderror

                                    </div>


                                    <div class="col-md-4">

                                        <label class="form-label fw-semibold">
                                            Lieu de naissance
                                        </label>

                                        <input
                                            type="text"
                                            wire:model="lieu"
                                            class="form-control"
                                        >

                                    </div>


                                    <div class="col-md-4">

                                        <label class="form-label fw-semibold">
                                            Contact parent
                                        </label>

                                        <input
                                            type="text"
                                            wire:model="contact_parent"
                                            class="form-control"
                                        >

                                    </div>


                                    <div class="col-md-4">

                                        <label class="form-label fw-semibold">
                                            Date d'inscription
                                        </label>

                                        <input
                                            type="date"
                                            wire:model="date_inscription"
                                            class="form-control"
                                        >

                                    </div>

                                    <div class="col-md-4">

                                        <label class="form-label fw-semibold">
                                            Tuteur
                                        </label>

                                        <input
                                            type="text"
                                            wire:model="tuteur"
                                            class="form-control @error('tuteur') is-invalid @enderror"
                                        >

                                        @error('tuteur')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>


                                    <div class="col-md-4">

                                        <label class="form-label fw-semibold">
                                            Contact tuteur
                                        </label>

                                        <input
                                            type="text"
                                            wire:model="contact_tuteur"
                                            class="form-control @error('contact_tuteur') is-invalid @enderror"
                                        >

                                        @error('contact_tuteur')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>


                                    <div class="col-12">

                                        <div class="d-flex gap-2 justify-content-end">

                                            <button
                                                type="button"
                                                wire:click="cancel"
                                                class="btn btn-light border"
                                            >

                                                Annuler

                                            </button>


                                            <button
                                                type="button"
                                                wire:click="saveEleve"
                                                wire:loading.attr="disabled"
                                                class="btn btn-primary"
                                            >

                                                <span
                                                    wire:loading.remove
                                                    wire:target="saveEleve"
                                                >

                                                    <i class="bi bi-check-lg me-1"></i>

                                                    Enregistrer

                                                </span>


                                                <span
                                                    wire:loading
                                                    wire:target="saveEleve"
                                                >

                                                    <span
                                                        class="spinner-border spinner-border-sm me-1"
                                                    ></span>

                                                    Enregistrement...

                                                </span>

                                            </button>

                                        </div>

                                    </div>

                                </div>

                            @endif

                        </div>

                    </div>


                    {{-- =================================================
                        SCOLARITÉ
                    ================================================== --}}
                    <div class="section-card mb-4">

                        <div class="section-header">

                            <div class="d-flex justify-content-between align-items-center">

                                <div class="d-flex align-items-center gap-3">

                                    <div
                                        class="icon-box"
                                        style="background:#eefaf3;color:#198754;"
                                    >

                                        <i class="bi bi-mortarboard"></i>

                                    </div>

                                    <div>

                                        <h5 class="section-title">
                                            Scolarité
                                        </h5>

                                        <div class="section-subtitle">
                                            Année scolaire, niveau et classe
                                        </div>

                                    </div>

                                </div>


                                @if($editing !== 'scolarite')

                                    <button
                                        type="button"
                                        wire:click="editBlock('scolarite')"
                                        class="btn btn-outline-primary edit-btn"
                                    >

                                        <i class="bi bi-pencil me-1"></i>

                                        Modifier

                                    </button>

                                @endif

                            </div>

                        </div>


                        <div class="card-body p-4">

                            @if($editing !== 'scolarite')

                                <div class="row g-4">

                                    <div class="col-md-4">

                                        <div class="info-label">
                                            Année scolaire
                                        </div>

                                        <div class="info-value">
                                            {{ optional($eleve->anneeScolaire)->scolaire_annee ?? '—' }}
                                        </div>

                                    </div>


                                    <div class="col-md-4">

                                        <div class="info-label">
                                            Niveau
                                        </div>

                                        <div class="info-value">
                                            {{ optional($eleve->classe?->niveau)->libelle ?? '—' }}
                                        </div>

                                    </div>


                                    <div class="col-md-4">

                                        <div class="info-label">
                                            Classe
                                        </div>

                                        <div class="info-value">
                                            {{ optional($eleve->classe)->name ?? '—' }}
                                        </div>

                                    </div>

                                </div>

                            @else

                                <div class="row g-3">

                                    <div class="col-md-4">

                                        <label class="form-label fw-semibold">
                                            Année scolaire
                                        </label>

                                        <select
                                            wire:model="annee_scolaire_id"
                                            class="form-select @error('annee_scolaire_id') is-invalid @enderror"
                                        >

                                            <option value="">
                                                Sélectionner
                                            </option>

                                            @foreach($annees as $annee)

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
                                    


                                    <div class="col-md-4">

                                        <label class="form-label fw-semibold">
                                            Niveau
                                        </label>

                                        <select
                                            wire:model.live="niveau_id"
                                            class="form-select @error('niveau_id') is-invalid @enderror"
                                        >

                                            <option value="">
                                                Sélectionner
                                            </option>

                                            @foreach($niveaux as $niveau)

                                                <option value="{{ $niveau->id }}">
                                                    {{ $niveau->libelle }}
                                                </option>

                                            @endforeach

                                        </select>

                                        @error('niveau_id')

                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>

                                        @enderror

                                    </div>


                                    <div class="col-md-4">

                                        <label class="form-label fw-semibold">
                                            Classe
                                        </label>

                                        <select
                                            wire:model="classe_id"
                                            class="form-select @error('classe_id') is-invalid @enderror"
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

                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>

                                        @enderror

                                    </div>


                                    <div class="col-12">

                                        <div class="d-flex gap-2 justify-content-end">

                                            <button
                                                type="button"
                                                wire:click="cancel"
                                                class="btn btn-light border"
                                            >

                                                Annuler

                                            </button>


                                            <button
                                                type="button"
                                                wire:click="saveScolarite"
                                                wire:loading.attr="disabled"
                                                class="btn btn-success"
                                            >

                                                <span
                                                    wire:loading.remove
                                                    wire:target="saveScolarite"
                                                >

                                                    <i class="bi bi-check-lg me-1"></i>

                                                    Enregistrer

                                                </span>


                                                <span
                                                    wire:loading
                                                    wire:target="saveScolarite"
                                                >

                                                    <span
                                                        class="spinner-border spinner-border-sm me-1"
                                                    ></span>

                                                    Enregistrement...

                                                </span>

                                            </button>

                                        </div>

                                    </div>

                                </div>

                            @endif

                        </div>

                    </div>


                    {{-- =================================================
                        HISTORIQUE PAIEMENTS
                    ================================================== --}}
                    {{-- =========================================================
    HISTORIQUE DES PAIEMENTS
========================================================= --}}
<div class="section-card mt-4">

    <div class="section-header">
        <div>
            <div class="section-title">
                <i class="bi bi-clock-history me-2"></i>
                Historique des paiements
            </div>

            <div class="section-subtitle">
                Liste des paiements effectués pour cet élève
            </div>
        </div>
    </div>

    <div class="card-body p-0">

        @if($paiements->count() > 0)

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th class="px-3">#</th>
                            <th>Date</th>
                            <th>Montant</th>
                            <th>Mode de paiement</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($paiements as $index => $paiement)

                            <tr>

                                {{-- Numéro --}}
                                <td class="px-3">
                                    <span class="text-muted">
                                        {{ $index + 1 }}
                                    </span>
                                </td>

                                {{-- Date --}}
                                <td>
                                    <div class="fw-semibold">
                                        {{ \Carbon\Carbon::parse($paiement->date_paiement)->format('d/m/Y') }}
                                    </div>
                                </td>

                                {{-- Montant --}}
                                <td>
                                    <span class="fw-bold text-success">
                                        {{ number_format($paiement->montant, 0, ',', ' ') }}
                                        FCFA
                                    </span>
                                </td>

                                {{-- Mode --}}
                                <td>

                                    @if($paiement->mode_paiement === 'Especes')

                                        <span class="badge bg-success-subtle text-success px-2 py-1">
                                            <i class="bi bi-cash me-1"></i>
                                            Espèces
                                        </span>

                                    @elseif($paiement->mode_paiement === 'Mobile Money')

                                        <span class="badge bg-primary-subtle text-primary px-2 py-1">
                                            <i class="bi bi-phone me-1"></i>
                                            Mobile Money
                                        </span>

                                    @elseif($paiement->mode_paiement === 'Virement')

                                        <span class="badge bg-info-subtle text-info px-2 py-1">
                                            <i class="bi bi-bank me-1"></i>
                                            Virement
                                        </span>

                                    @elseif($paiement->mode_paiement === 'Cheque')

                                        <span class="badge bg-warning-subtle text-warning px-2 py-1">
                                            <i class="bi bi-receipt me-1"></i>
                                            Chèque
                                        </span>

                                    @else

                                        <span class="badge bg-secondary-subtle text-secondary px-2 py-1">
                                            {{ $paiement->mode_paiement }}
                                        </span>

                                    @endif

                                </td>

                                {{-- ACTIONS --}}
                                <td class="text-center">

                                    <div class="d-flex justify-content-center gap-1">

                                        {{-- Supprimer --}}
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-outline-danger"
                                            wire:click="deletePaiement({{ $paiement->id }})"
                                            wire:confirm="Voulez-vous vraiment supprimer ce paiement ?"
                                            title="Supprimer le paiement"
                                        >
                                            <i class="bi bi-trash"></i>
                                        </button>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="text-center py-5">

                <div
                    class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto mb-3"
                    style="width:70px;height:70px;"
                >
                    <i class="bi bi-receipt text-muted fs-3"></i>
                </div>

                <h6 class="fw-bold mb-1">
                    Aucun paiement
                </h6>

                <p class="text-muted small mb-0">
                    Aucun paiement n'a encore été enregistré pour cet élève.
                </p>

            </div>

        @endif

    </div>

</div>

                </div>


                {{-- =================================================
                    COLONNE DROITE
                ================================================== --}}
                <div class="col-lg-4">

                    <div class="sticky-summary">


                        {{-- =================================================
                            SITUATION FINANCIÈRE
                        ================================================== --}}
                        <div class="section-card mb-4">

                            <div class="section-header">

                                <div class="d-flex align-items-center gap-3">

                                    <div
                                        class="icon-box"
                                        style="background:#eaf7ff;color:#0d6efd;"
                                    >

                                        <i class="bi bi-wallet2"></i>

                                    </div>

                                    <div>

                                        <h5 class="section-title">
                                            Situation financière
                                        </h5>

                                        <div class="section-subtitle">
                                            Montant annuel et paiements
                                        </div>

                                    </div>

                                </div>

                            </div>


                            <div class="card-body p-3">

                                <div class="row g-3">

                                    <div class="col-12">

                                        <div class="finance-box">

                                            <div class="finance-label">
                                                Montant annuel
                                            </div>

                                            <div class="finance-value text-primary">

                                                {{ number_format(
                                                    $montantAnnuel,
                                                    0,
                                                    ',',
                                                    ' '
                                                ) }}

                                                <small>FCFA</small>

                                            </div>

                                            <div class="small text-muted mt-1">

                                                Montant défini pour le niveau

                                                <strong>
                                                    {{ optional($eleve->classe?->niveau)->libelle ?? '—' }}
                                                </strong>

                                            </div>

                                        </div>

                                    </div>


                                    <div class="col-6">

                                        <div class="finance-box">

                                            <div class="finance-label">
                                                Total payé
                                            </div>

                                            <div class="finance-value text-success">

                                                {{ number_format(
                                                    $totalPaye,
                                                    0,
                                                    ',',
                                                    ' '
                                                ) }}

                                                <small>FCFA</small>

                                            </div>

                                        </div>

                                    </div>


                                    <div class="col-6">

                                        <div class="finance-box">

                                            <div class="finance-label">
                                                Reste à payer
                                            </div>

                                            <div
                                                class="finance-value
                                                {{ $reste > 0
                                                    ? 'text-danger'
                                                    : 'text-success' }}"
                                            >

                                                {{ number_format(
                                                    $reste,
                                                    0,
                                                    ',',
                                                    ' '
                                                ) }}

                                                <small>FCFA</small>

                                            </div>

                                        </div>

                                    </div>

                                </div>


                                <div class="mt-3 p-3 rounded-3 bg-light">

                                    <div class="small text-muted mb-2">
                                        Calcul
                                    </div>

                                    <div class="d-flex justify-content-between small">

                                        <span>
                                            Montant annuel
                                        </span>

                                        <strong>

                                            {{ number_format(
                                                $montantAnnuel,
                                                0,
                                                ',',
                                                ' '
                                            ) }}

                                            FCFA

                                        </strong>

                                    </div>


                                    <div class="d-flex justify-content-between small mt-1">

                                        <span>
                                            − Total payé
                                        </span>

                                        <strong class="text-success">

                                            {{ number_format(
                                                $totalPaye,
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
                                            Reste
                                        </strong>

                                        <strong
                                            class="{{ $reste > 0
                                                ? 'text-danger'
                                                : 'text-success' }}"
                                        >

                                            {{ number_format(
                                                $reste,
                                                0,
                                                ',',
                                                ' '
                                            ) }}

                                            FCFA

                                        </strong>

                                    </div>

                                </div>


                                <div class="text-center mt-3">

                                    @if($estSolde)

                                        <span class="status-badge status-paid">

                                            <i class="bi bi-check-circle-fill"></i>

                                            SCOLARITÉ SOLDÉE

                                        </span>

                                    @else

                                        <span class="status-badge status-unpaid">

                                            <i class="bi bi-exclamation-circle-fill"></i>

                                            RESTE À PAYER

                                        </span>

                                    @endif

                                </div>

                            </div>

                        </div>


                        {{-- =================================================
                            NOUVEAU PAIEMENT
                        ================================================== --}}
                        <div class="section-card">

                            <div class="section-header">

                                <div class="d-flex justify-content-between align-items-center">

                                    <div class="d-flex align-items-center gap-3">

                                        <div
                                            class="icon-box"
                                            style="background:#fff5e8;color:#f59e0b;"
                                        >

                                            <i class="bi bi-cash-coin"></i>

                                        </div>

                                        <div>

                                            <h5 class="section-title">
                                                Nouveau paiement
                                            </h5>

                                            <div class="section-subtitle">
                                                Enregistrer un versement
                                            </div>

                                        </div>

                                    </div>


                                    @if($editing !== 'paiement')

                                        <button
                                            type="button"
                                            wire:click="editBlock('paiement')"
                                            class="btn btn-outline-primary edit-btn"
                                        >

                                            <i class="bi bi-plus-lg"></i>

                                        </button>

                                    @endif

                                </div>

                            </div>


                            <div class="card-body p-4">

                                @if($editing === 'paiement')

                                    <div class="mb-3">

                                        <label class="form-label fw-semibold">
                                            Montant
                                        </label>

                                        <div class="input-group">

                                            <input
                                                type="number"
                                                wire:model="montant"
                                                min="1"
                                                max="{{ $reste }}"
                                                class="form-control @error('montant') is-invalid @enderror"
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


                                        <div class="small text-muted mt-2">

                                            Reste actuel :

                                            <strong>

                                                {{ number_format(
                                                    $reste,
                                                    0,
                                                    ',',
                                                    ' '
                                                ) }}

                                                FCFA

                                            </strong>

                                        </div>

                                    </div>


                                    <div class="mb-3">

                                        <label class="form-label fw-semibold">
                                            Mode de paiement
                                        </label>

                                        <select
                                            wire:model="mode_paiement"
                                            class="form-select @error('mode_paiement') is-invalid @enderror"
                                        >

                                            <option value="Especes">
                                                Espèces
                                            </option>

                                            <option value="Mobile Money">
                                                Mobile Money
                                            </option>

                                            <option value="Virement">
                                                Virement bancaire
                                            </option>

                                            <option value="Cheque">
                                                Chèque
                                            </option>

                                            <option value="Autre">
                                                Autre
                                            </option>

                                        </select>

                                        @error('mode_paiement')

                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>

                                        @enderror

                                    </div>


                                    <div class="mb-3">

                                        <label class="form-label fw-semibold">
                                            Date du paiement
                                        </label>

                                        <input
                                            type="date"
                                            wire:model="date_paiement"
                                            class="form-control @error('date_paiement') is-invalid @enderror"
                                        >

                                        @error('date_paiement')

                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>

                                        @enderror

                                    </div>


                                    <div class="d-flex gap-2">

                                        <button
                                            type="button"
                                            wire:click="cancel"
                                            class="btn btn-light border flex-fill"
                                        >

                                            Annuler

                                        </button>


                                        <button
                                            type="button"
                                            wire:click="savePaiement"
                                            wire:loading.attr="disabled"
                                            class="btn btn-success flex-fill"
                                            @disabled($reste <= 0)
                                        >

                                            <span
                                                wire:loading.remove
                                                wire:target="savePaiement"
                                            >

                                                <i class="bi bi-check-lg me-1"></i>

                                                Enregistrer

                                            </span>


                                            <span
                                                wire:loading
                                                wire:target="savePaiement"
                                            >

                                                <span
                                                    class="spinner-border spinner-border-sm me-1"
                                                ></span>

                                                Enregistrement...

                                            </span>

                                        </button>

                                    </div>

                                @else

                                    @if($estSolde)

                                        <div class="text-center py-2">

                                            <i
                                                class="bi bi-check-circle-fill text-success"
                                                style="font-size:42px;"
                                            ></i>

                                            <div class="fw-bold text-success mt-2">
                                                Paiement terminé
                                            </div>

                                            <div class="small text-muted">
                                                Aucun montant restant.
                                            </div>

                                        </div>

                                    @else

                                        <div class="text-center py-2">

                                            <div class="small text-muted">
                                                Reste à payer
                                            </div>

                                            <div class="fw-bold text-danger fs-3">

                                                {{ number_format(
                                                    $reste,
                                                    0,
                                                    ',',
                                                    ' '
                                                ) }}

                                                FCFA

                                            </div>


                                            <button
                                                type="button"
                                                wire:click="editBlock('paiement')"
                                                class="btn btn-success mt-3"
                                            >

                                                <i class="bi bi-plus-lg me-1"></i>

                                                Ajouter un paiement

                                            </button>

                                        </div>

                                    @endif

                                @endif

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>