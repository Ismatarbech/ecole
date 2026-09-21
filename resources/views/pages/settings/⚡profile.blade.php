<?php

use App\Concerns\ProfileValidationRules;
use App\Models\UserProfile;
use Flux\Flux;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

new #[Title('Paramètres du profil')] class extends Component
{
    use ProfileValidationRules;
    use WithFileUploads;

    /*
    |--------------------------------------------------------------------------
    | INFORMATIONS UTILISATEUR
    |--------------------------------------------------------------------------
    */

    public string $name = '';
    public string $email = '';

    /*
    |--------------------------------------------------------------------------
    | INFORMATIONS PROFIL
    |--------------------------------------------------------------------------
    */

    public string $apropos = '';
    public string $etablissement = '';
    public string $poste = '';
    public string $pays = '';
    public string $adresse = '';
    public string $telephone = '';

    /*
    |--------------------------------------------------------------------------
    | PHOTO
    |--------------------------------------------------------------------------
    */

    public $profile_image = null;

    public ?string $ancienne_photo = null;

    /*
    |--------------------------------------------------------------------------
    | MOT DE PASSE
    |--------------------------------------------------------------------------
    */

    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /*
    |--------------------------------------------------------------------------
    | ETAT CONFIRMATION
    |--------------------------------------------------------------------------
    */

    public bool $passwordConfirmed = false;

    /*
    |--------------------------------------------------------------------------
    | MOUNT
    |--------------------------------------------------------------------------
    */

    public function mount(): void
    {
        $user = Auth::user();

        $profile = UserProfile::firstOrCreate([
            'user_id' => $user->id,
        ]);

        /*
        |--------------------------------------------------------------------------
        | USER
        |--------------------------------------------------------------------------
        */

        $this->name = $user->name ?? '';
        $this->email = $user->email ?? '';

        /*
        |--------------------------------------------------------------------------
        | PROFILE
        |--------------------------------------------------------------------------
        */

        $this->apropos = $profile->apropos ?? '';
        $this->etablissement = $profile->etablissement ?? '';
        $this->poste = $profile->poste ?? '';
        $this->pays = $profile->pays ?? '';
        $this->adresse = $profile->adresse ?? '';
        $this->telephone = $profile->telephone ?? '';

        /*
        |--------------------------------------------------------------------------
        | PHOTO ACTUELLE
        |--------------------------------------------------------------------------
        */

        $this->ancienne_photo = $profile->profile_image ?? null;
    }

    /*
    |--------------------------------------------------------------------------
    | MODIFIER LE PROFIL
    |--------------------------------------------------------------------------
    */

    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $this->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')
                    ->ignore($user->id),
            ],

            'apropos' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'etablissement' => [
                'nullable',
                'string',
                'max:255',
            ],

            'poste' => [
                'nullable',
                'string',
                'max:255',
            ],

            'pays' => [
                'nullable',
                'string',
                'max:255',
            ],

            'adresse' => [
                'nullable',
                'string',
                'max:255',
            ],

            'telephone' => [
                'nullable',
                'string',
                'max:50',
            ],

            'profile_image' => [
                'nullable',
                'image',
                'max:4096',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | MODIFIER UTILISATEUR
        |--------------------------------------------------------------------------
        */

        $user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        /*
        |--------------------------------------------------------------------------
        | RECUPERER LE PROFIL
        |--------------------------------------------------------------------------
        */

        $profile = UserProfile::firstOrCreate([
            'user_id' => $user->id,
        ]);

        /*
        |--------------------------------------------------------------------------
        | GARDER LA PHOTO ACTUELLE
        |--------------------------------------------------------------------------
        */

        $photoPath = $profile->profile_image;

        /*
        |--------------------------------------------------------------------------
        | ENREGISTRER UNE NOUVELLE PHOTO
        |--------------------------------------------------------------------------
        */

        if ($this->profile_image) {

            /*
            |--------------------------------------------------------------------------
            | SUPPRIMER L'ANCIENNE PHOTO
            |--------------------------------------------------------------------------
            */

            if (
                $photoPath &&
                Storage::disk('public')->exists($photoPath)
            ) {
                Storage::disk('public')->delete($photoPath);
            }

            /*
            |--------------------------------------------------------------------------
            | ENREGISTRER LA NOUVELLE PHOTO
            |--------------------------------------------------------------------------
            */

            $photoPath = $this->profile_image->store(
                'profiles',
                'public'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | METTRE A JOUR LE PROFIL
        |--------------------------------------------------------------------------
        */

        $profile->update([
            'apropos' => $this->apropos,
            'etablissement' => $this->etablissement,
            'poste' => $this->poste,
            'pays' => $this->pays,
            'adresse' => $this->adresse,
            'telephone' => $this->telephone,
            'profile_image' => $photoPath,
        ]);

        /*
        |--------------------------------------------------------------------------
        | RAFRAICHIR LE MODELE
        |--------------------------------------------------------------------------
        */

        $profile->refresh();

        /*
        |--------------------------------------------------------------------------
        | IMPORTANT : RECUPERER LA NOUVELLE PHOTO
        |--------------------------------------------------------------------------
        */

        $this->ancienne_photo = $profile->profile_image;

        /*
        |--------------------------------------------------------------------------
        | VIDER LE FICHIER TEMPORAIRE LIVEWIRE
        |--------------------------------------------------------------------------
        */

        $this->profile_image = null;

        /*
        |--------------------------------------------------------------------------
        | MESSAGE
        |--------------------------------------------------------------------------
        */

        Flux::toast(
            variant: 'success',
            text: 'Profil modifié avec succès.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CONFIRMER LE MOT DE PASSE ACTUEL
    |--------------------------------------------------------------------------
    */

    public function confirmPassword(): void
    {
        $this->validate([
            'current_password' => [
                'required',
            ],
        ], [
            'current_password.required' =>
                'Veuillez entrer votre mot de passe.',
        ]);

        if (
            ! Hash::check(
                $this->current_password,
                Auth::user()->password
            )
        ) {
            $this->addError(
                'current_password',
                'Le mot de passe est incorrect.'
            );

            return;
        }

        $this->passwordConfirmed = true;

        $this->resetErrorBag('current_password');

        $this->current_password = '';

        Flux::toast(
            variant: 'success',
            text: 'Mot de passe confirmé. Vous pouvez maintenant le modifier.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CHANGER LE MOT DE PASSE
    |--------------------------------------------------------------------------
    */

    public function updatePassword(): void
    {
        if (! $this->passwordConfirmed) {

            $this->addError(
                'current_password',
                'Veuillez d\'abord confirmer votre mot de passe actuel.'
            );

            return;
        }

        $this->validate([
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')
                    ->ignore(Auth::id()),
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ], [
            'password.required' =>
                'Le nouveau mot de passe est obligatoire.',

            'password.min' =>
                'Le mot de passe doit contenir au moins 8 caractères.',

            'password.confirmed' =>
                'Les mots de passe ne correspondent pas.',
        ]);

        Auth::user()->update([
            'email' => $this->email,

            'password' => Hash::make(
                $this->password
            ),
        ]);

        $this->reset([
            'password',
            'password_confirmation',
            'current_password',
        ]);

        $this->passwordConfirmed = false;

        Flux::toast(
            variant: 'success',
            text: 'Votre mot de passe a été modifié avec succès.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | VERIFICATION EMAIL
    |--------------------------------------------------------------------------
    */

    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            return;
        }

        $user->sendEmailVerificationNotification();

        session()->flash(
            'status',
            'verification-link-sent'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | EMAIL NON VERIFIE
    |--------------------------------------------------------------------------
    */

    #[Computed]
    public function hasUnverifiedEmail(): bool
    {
        return Auth::user() instanceof MustVerifyEmail
            && ! Auth::user()->hasVerifiedEmail();
    }

    /*
    |--------------------------------------------------------------------------
    | SUPPRESSION UTILISATEUR
    |--------------------------------------------------------------------------
    */

    #[Computed]
    public function showDeleteUser(): bool
    {
        return ! Auth::user() instanceof MustVerifyEmail
            || (
                Auth::user() instanceof MustVerifyEmail
                && Auth::user()->hasVerifiedEmail()
            );
    }
};

?>

<section class="w-full">

    <main id="main" class="main">

        {{-- ===================================================== --}}
        {{-- TITRE --}}
        {{-- ===================================================== --}}

        <div class="pagetitle">

            <h1>Paramètres du profil</h1>

            <nav>

                <ol class="breadcrumb">

                    <li class="breadcrumb-item">
                        Accueil
                    </li>

                    <li class="breadcrumb-item">
                        Utilisateurs
                    </li>

                    <li class="breadcrumb-item active">
                        Paramètres du profil
                    </li>

                </ol>

            </nav>

        </div>


        <section class="section profile">

            <div class="row">


                {{-- ===================================================== --}}
                {{-- PROFIL GAUCHE --}}
                {{-- ===================================================== --}}

                <div class="col-xl-4">

                    <div class="card">

                        <div
                            class="card-body profile-card pt-4 d-flex flex-column align-items-center"
                        >

                            {{-- ========================================== --}}
                            {{-- PHOTO --}}
                            {{-- ========================================== --}}

                            @if ($profile_image)

                                <img
                                    src="{{ $profile_image->temporaryUrl() }}"
                                    alt="Profile"
                                    class="rounded-circle"
                                    style="
                                        width: 120px;
                                        height: 120px;
                                        object-fit: cover;
                                    "
                                >

                            @elseif ($ancienne_photo)

                                <img
                                    src="{{ asset('storage/' . $ancienne_photo) }}?v={{ md5($ancienne_photo) }}"
                                    alt="Profile"
                                    class="rounded-circle"
                                    style="
                                        width: 120px;
                                        height: 120px;
                                        object-fit: cover;
                                    "
                                >

                            @else

                                <img
                                    src="{{ asset('assets/img/profile-img.jpg') }}"
                                    alt="Profile"
                                    class="rounded-circle"
                                    style="
                                        width: 120px;
                                        height: 120px;
                                        object-fit: cover;
                                    "
                                >

                            @endif


                            <h2>{{ $name }}</h2>

                            <h3>{{ $email }}</h3>

                        </div>

                    </div>

                </div>


                {{-- ===================================================== --}}
                {{-- PROFIL DROITE --}}
                {{-- ===================================================== --}}

                <div class="col-xl-8">

                    <div class="card">

                        <div class="card-body pt-3">


                            {{-- ================================================= --}}
                            {{-- NAVIGATION --}}
                            {{-- ================================================= --}}

                            <ul class="nav nav-tabs nav-tabs-bordered">


                                <li class="nav-item">

                                    <button
                                        class="nav-link active"
                                        data-bs-toggle="tab"
                                        data-bs-target="#profile-overview"
                                        type="button"
                                    >
                                        Aperçu
                                    </button>

                                </li>


                                <li class="nav-item">

                                    <button
                                        class="nav-link"
                                        data-bs-toggle="tab"
                                        data-bs-target="#profile-edit"
                                        type="button"
                                    >
                                        Modifier le profil
                                    </button>

                                </li>


                                <li class="nav-item">

                                    <button
                                        class="nav-link"
                                        data-bs-toggle="tab"
                                        data-bs-target="#profile-settings"
                                        type="button"
                                    >
                                        Paramètres
                                    </button>

                                </li>


                                <li class="nav-item">

                                    <button
                                        class="nav-link"
                                        data-bs-toggle="tab"
                                        data-bs-target="#profile-change-password"
                                        type="button"
                                    >
                                        Changer le mot de passe
                                    </button>

                                </li>

                            </ul>


                            <div class="tab-content pt-2">


                                {{-- ================================================= --}}
                                {{-- APERCU --}}
                                {{-- ================================================= --}}

                                <div
                                    class="tab-pane fade show active profile-overview"
                                    id="profile-overview"
                                >

                                    <h5 class="card-title">
                                        À propos
                                    </h5>

                                    <p class="small fst-italic">

                                        {{
                                            $apropos
                                            ?: 'Aucune information disponible.'
                                        }}

                                    </p>


                                    <h5 class="card-title">
                                        Détails du profil
                                    </h5>


                                    <div class="row">

                                        <div class="col-lg-3 col-md-4 label">
                                            Nom complet
                                        </div>

                                        <div class="col-lg-9 col-md-8">
                                            {{ $name }}
                                        </div>

                                    </div>


                                    <div class="row">

                                        <div class="col-lg-3 col-md-4 label">
                                            Établissement
                                        </div>

                                        <div class="col-lg-9 col-md-8">
                                            {{ $etablissement ?: '-' }}
                                        </div>

                                    </div>


                                    <div class="row">

                                        <div class="col-lg-3 col-md-4 label">
                                            Poste
                                        </div>

                                        <div class="col-lg-9 col-md-8">
                                            {{ $poste ?: '-' }}
                                        </div>

                                    </div>


                                    <div class="row">

                                        <div class="col-lg-3 col-md-4 label">
                                            Pays
                                        </div>

                                        <div class="col-lg-9 col-md-8">
                                            {{ $pays ?: '-' }}
                                        </div>

                                    </div>


                                    <div class="row">

                                        <div class="col-lg-3 col-md-4 label">
                                            Adresse
                                        </div>

                                        <div class="col-lg-9 col-md-8">
                                            {{ $adresse ?: '-' }}
                                        </div>

                                    </div>


                                    <div class="row">

                                        <div class="col-lg-3 col-md-4 label">
                                            Téléphone
                                        </div>

                                        <div class="col-lg-9 col-md-8">
                                            {{ $telephone ?: '-' }}
                                        </div>

                                    </div>


                                    <div class="row">

                                        <div class="col-lg-3 col-md-4 label">
                                            Email
                                        </div>

                                        <div class="col-lg-9 col-md-8">
                                            {{ $email }}
                                        </div>

                                    </div>

                                </div>


                                {{-- ================================================= --}}
                                {{-- MODIFIER LE PROFIL --}}
                                {{-- ================================================= --}}

                                <div
                                    class="tab-pane fade profile-edit pt-3"
                                    id="profile-edit"
                                >

                                    <form
                                        wire:submit="updateProfileInformation"
                                    >


                                        {{-- PHOTO --}}

                                        <div class="row mb-3">

                                            <label
                                                class="col-md-4 col-lg-3 col-form-label"
                                            >
                                                Photo
                                            </label>

                                            <div class="col-md-8 col-lg-9">

                                                <input
                                                    wire:model="profile_image"
                                                    type="file"
                                                    class="form-control @error('profile_image') is-invalid @enderror"
                                                    accept="image/*"
                                                >

                                                <div
                                                    wire:loading
                                                    wire:target="profile_image"
                                                    class="small text-primary mt-2"
                                                >

                                                    <span
                                                        class="spinner-border spinner-border-sm me-1"
                                                    ></span>

                                                    Chargement de l'image...

                                                </div>

                                                @error('profile_image')

                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>

                                                @enderror

                                            </div>

                                        </div>


                                        {{-- NOM --}}

                                        <div class="row mb-3">

                                            <label
                                                class="col-md-4 col-lg-3 col-form-label"
                                            >
                                                Nom
                                            </label>

                                            <div class="col-md-8 col-lg-9">

                                                <input
                                                    wire:model="name"
                                                    type="text"
                                                    class="form-control"
                                                >

                                            </div>

                                        </div>


                                        {{-- A PROPOS --}}

                                        <div class="row mb-3">

                                            <label
                                                class="col-md-4 col-lg-3 col-form-label"
                                            >
                                                À propos
                                            </label>

                                            <div class="col-md-8 col-lg-9">

                                                <textarea
                                                    wire:model="apropos"
                                                    class="form-control"
                                                    style="height: 100px"
                                                ></textarea>

                                            </div>

                                        </div>


                                        {{-- ETABLISSEMENT --}}

                                        <div class="row mb-3">

                                            <label
                                                class="col-md-4 col-lg-3 col-form-label"
                                            >
                                                Établissement
                                            </label>

                                            <div class="col-md-8 col-lg-9">

                                                <input
                                                    wire:model="etablissement"
                                                    type="text"
                                                    class="form-control"
                                                >

                                            </div>

                                        </div>


                                        {{-- POSTE --}}

                                        <div class="row mb-3">

                                            <label
                                                class="col-md-4 col-lg-3 col-form-label"
                                            >
                                                Poste
                                            </label>

                                            <div class="col-md-8 col-lg-9">

                                                <input
                                                    wire:model="poste"
                                                    type="text"
                                                    class="form-control"
                                                >

                                            </div>

                                        </div>


                                        {{-- PAYS --}}

                                        <div class="row mb-3">

                                            <label
                                                class="col-md-4 col-lg-3 col-form-label"
                                            >
                                                Pays
                                            </label>

                                            <div class="col-md-8 col-lg-9">

                                                <input
                                                    wire:model="pays"
                                                    type="text"
                                                    class="form-control"
                                                >

                                            </div>

                                        </div>


                                        {{-- ADRESSE --}}

                                        <div class="row mb-3">

                                            <label
                                                class="col-md-4 col-lg-3 col-form-label"
                                            >
                                                Adresse
                                            </label>

                                            <div class="col-md-8 col-lg-9">

                                                <input
                                                    wire:model="adresse"
                                                    type="text"
                                                    class="form-control"
                                                >

                                            </div>

                                        </div>


                                        {{-- TELEPHONE --}}

                                        <div class="row mb-3">

                                            <label
                                                class="col-md-4 col-lg-3 col-form-label"
                                            >
                                                Téléphone
                                            </label>

                                            <div class="col-md-8 col-lg-9">

                                                <input
                                                    wire:model="telephone"
                                                    type="text"
                                                    class="form-control"
                                                >

                                            </div>

                                        </div>


                                        {{-- BOUTON --}}

                                        <div class="text-center">

                                            <button
                                                type="submit"
                                                class="btn btn-primary"
                                                wire:loading.attr="disabled"
                                                wire:target="updateProfileInformation,profile_image"
                                            >

                                                <span
                                                    wire:loading.remove
                                                    wire:target="updateProfileInformation"
                                                >

                                                    <i class="bi bi-save me-1"></i>

                                                    Sauvegarder les modifications

                                                </span>

                                                <span
                                                    wire:loading
                                                    wire:target="updateProfileInformation"
                                                >

                                                    <span
                                                        class="spinner-border spinner-border-sm me-1"
                                                    ></span>

                                                    Sauvegarde...

                                                </span>

                                            </button>

                                        </div>

                                    </form>

                                </div>


                                {{-- ================================================= --}}
                                {{-- CONFIRMER PASSWORD --}}
                                {{-- ================================================= --}}

                                <div
                                    class="tab-pane fade pt-3"
                                    id="profile-settings"
                                >

                                    @if (! $passwordConfirmed)

                                        <form
                                            wire:submit="confirmPassword"
                                        >

                                            <div class="row mb-3">

                                                <label
                                                    class="col-md-4 col-lg-3 col-form-label"
                                                >
                                                    Confirmer votre mot de passe
                                                </label>

                                                <div class="col-md-8 col-lg-9">

                                                    <input
                                                        wire:model="current_password"
                                                        type="password"
                                                        class="form-control @error('current_password') is-invalid @enderror"
                                                        required
                                                        autocomplete="current-password"
                                                        placeholder="Entrez votre mot de passe"
                                                    >

                                                    @error('current_password')

                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>

                                                    @enderror

                                                </div>

                                            </div>


                                            <div class="text-center">

                                                <button
                                                    type="submit"
                                                    class="btn btn-primary"
                                                >

                                                    <i class="bi bi-check-circle me-1"></i>

                                                    Confirmer

                                                </button>

                                            </div>

                                        </form>

                                    @else

                                        <div class="alert alert-success">

                                            <i class="bi bi-check-circle me-2"></i>

                                            Votre mot de passe a été confirmé.
                                            Vous pouvez maintenant aller dans

                                            <strong>
                                                Changer le mot de passe
                                            </strong>.

                                        </div>

                                    @endif

                                </div>


                                {{-- ================================================= --}}
                                {{-- CHANGER PASSWORD --}}
                                {{-- ================================================= --}}

                                <div
                                    class="tab-pane fade pt-3"
                                    id="profile-change-password"
                                >

                                    @if (! $passwordConfirmed)

                                        <div class="alert alert-warning">

                                            <i
                                                class="bi bi-shield-lock me-2"
                                            ></i>

                                            Veuillez d'abord confirmer votre mot
                                            de passe dans l'onglet

                                            <strong>
                                                Paramètres
                                            </strong>.

                                        </div>

                                    @else

                                        <form
                                            wire:submit="updatePassword"
                                        >


                                            {{-- EMAIL --}}

                                            <div class="row mb-3">

                                                <label
                                                    class="col-md-4 col-lg-3 col-form-label"
                                                >
                                                    Email
                                                </label>

                                                <div class="col-md-8 col-lg-9">

                                                    <input
                                                        wire:model="email"
                                                        type="email"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        required
                                                    >

                                                    @error('email')

                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>

                                                    @enderror

                                                </div>

                                            </div>


                                            {{-- NOUVEAU PASSWORD --}}

                                            <div class="row mb-3">

                                                <label
                                                    class="col-md-4 col-lg-3 col-form-label"
                                                >
                                                    Nouveau mot de passe
                                                </label>

                                                <div class="col-md-8 col-lg-9">

                                                    <input
                                                        wire:model="password"
                                                        type="password"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        required
                                                        autocomplete="new-password"
                                                    >

                                                    @error('password')

                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>

                                                    @enderror

                                                </div>

                                            </div>


                                            {{-- CONFIRMATION --}}

                                            <div class="row mb-3">

                                                <label
                                                    class="col-md-4 col-lg-3 col-form-label"
                                                >
                                                    Confirmer le mot de passe
                                                </label>

                                                <div class="col-md-8 col-lg-9">

                                                    <input
                                                        wire:model="password_confirmation"
                                                        type="password"
                                                        class="form-control"
                                                        required
                                                        autocomplete="new-password"
                                                    >

                                                </div>

                                            </div>


                                            {{-- BOUTON --}}

                                            <div class="text-center">

                                                <button
                                                    type="submit"
                                                    class="btn btn-primary"
                                                >

                                                    <i
                                                        class="bi bi-save me-1"
                                                    ></i>

                                                    Enregistrer

                                                </button>

                                            </div>

                                        </form>

                                    @endif

                                </div>


                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>

    </main>

</section>