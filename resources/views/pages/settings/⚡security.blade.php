<?php

use Flux\Flux;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;
use Laravel\Fortify\Features;
use Laravel\Fortify\Fortify;
use Laravel\Passkeys\Actions\DeletePasskey;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Sécurité')] class extends Component
{
    /*
    |--------------------------------------------------------------------------
    | TWO FACTOR AUTHENTICATION
    |--------------------------------------------------------------------------
    */

    public bool $canManageTwoFactor = false;
    public bool $twoFactorEnabled = false;
    public bool $requiresConfirmation = false;

    /*
    |--------------------------------------------------------------------------
    | PASSKEYS
    |--------------------------------------------------------------------------
    */

    #[Locked]
    public bool $canManagePasskeys = false;

    #[Locked]
    public array $passkeys = [];

    /*
    |--------------------------------------------------------------------------
    | SUPPRESSION PASSKEY
    |--------------------------------------------------------------------------
    */

    public bool $showDeleteModal = false;

    #[Locked]
    public ?int $deletingPasskeyId = null;

    #[Locked]
    public string $deletingPasskeyName = '';

    /*
    |--------------------------------------------------------------------------
    | MOUNT
    |--------------------------------------------------------------------------
    */

    public function mount(
        DisableTwoFactorAuthentication $disableTwoFactorAuthentication
    ): void {
        /*
        |--------------------------------------------------------------------------
        | TWO FACTOR AUTHENTICATION
        |--------------------------------------------------------------------------
        */

        $this->canManageTwoFactor =
            Features::canManageTwoFactorAuthentication();

        if ($this->canManageTwoFactor) {

            /*
            | Si la confirmation 2FA est incomplète,
            | on désactive l'ancienne configuration.
            */

            if (
                Fortify::confirmsTwoFactorAuthentication()
                &&
                is_null(auth()->user()->two_factor_confirmed_at)
            ) {
                $disableTwoFactorAuthentication(
                    auth()->user()
                );
            }

            $this->twoFactorEnabled =
                auth()
                    ->user()
                    ->hasEnabledTwoFactorAuthentication();

            $this->requiresConfirmation =
                Features::optionEnabled(
                    Features::twoFactorAuthentication(),
                    'confirm'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | PASSKEYS
        |--------------------------------------------------------------------------
        */

        $this->canManagePasskeys =
            Features::canManagePasskeys();

        if ($this->canManagePasskeys) {
            $this->loadPasskeys();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | CHARGER LES PASSKEYS
    |--------------------------------------------------------------------------
    */

    public function loadPasskeys(): void
    {
        $this->passkeys =
            auth()
                ->user()
                ->passkeys()
                ->latest()
                ->get()
                ->map(function ($passkey) {

                    return [
                        'id' => $passkey->id,

                        'name' => $passkey->name,

                        'authenticator' =>
                            $passkey->authenticator ?? null,

                        'created_at_diff' =>
                            $passkey->created_at
                                ?->diffForHumans(),

                        'last_used_at_diff' =>
                            $passkey->last_used_at
                                ?->diffForHumans(),
                    ];
                })
                ->toArray();
    }

    /*
    |--------------------------------------------------------------------------
    | CONFIRMER SUPPRESSION PASSKEY
    |--------------------------------------------------------------------------
    */

    public function confirmDelete(
        int $passkeyId
    ): void {
        $passkey =
            auth()
                ->user()
                ->passkeys()
                ->findOrFail($passkeyId);

        $this->deletingPasskeyId =
            $passkey->id;

        $this->deletingPasskeyName =
            $passkey->name;

        $this->showDeleteModal = true;
    }

    /*
    |--------------------------------------------------------------------------
    | SUPPRIMER PASSKEY
    |--------------------------------------------------------------------------
    */

    public function deletePasskey(
        DeletePasskey $deletePasskey
    ): void {
        if (! $this->deletingPasskeyId) {
            return;
        }

        $passkey =
            auth()
                ->user()
                ->passkeys()
                ->findOrFail(
                    $this->deletingPasskeyId
                );

        $deletePasskey(
            auth()->user(),
            $passkey
        );

        $this->closeDeleteModal();

        $this->loadPasskeys();

        Flux::toast(
            variant: 'success',
            text: 'Clé d’accès supprimée avec succès.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | FERMER MODAL
    |--------------------------------------------------------------------------
    */

    public function closeDeleteModal(): void
    {
        $this->showDeleteModal = false;

        $this->deletingPasskeyId = null;

        $this->deletingPasskeyName = '';
    }

    /*
    |--------------------------------------------------------------------------
    | EVENEMENT 2FA ACTIVE
    |--------------------------------------------------------------------------
    */

    #[On('two-factor-enabled')]
    public function onTwoFactorEnabled(): void
    {
        $this->twoFactorEnabled = true;
    }

    /*
    |--------------------------------------------------------------------------
    | DESACTIVER 2FA
    |--------------------------------------------------------------------------
    */

    public function disable(
        DisableTwoFactorAuthentication $disableTwoFactorAuthentication
    ): void {
        $disableTwoFactorAuthentication(
            auth()->user()
        );

        $this->twoFactorEnabled = false;

        Flux::toast(
            variant: 'success',
            text: 'Authentification à deux facteurs désactivée.'
        );
    }
};

?>

<section class="section">

{{-- ========================================================= --}}
{{-- PAGE TITLE --}}
{{-- ========================================================= --}}

<div class="pagetitle">
    <h1>Sécurité du compte</h1>

    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Accueil
                </a>
            </li>

            <li class="breadcrumb-item">
                Paramètres
            </li>

            <li class="breadcrumb-item active">
                Sécurité
            </li>
        </ol>
    </nav>
</div>

{{-- ========================================================= --}}
{{-- TWO FACTOR AUTHENTICATION --}}
{{-- ========================================================= --}}

@if ($canManageTwoFactor)

    <div class="card">

        <div class="card-body">

            {{-- TITRE --}}

            <div class="d-flex align-items-center pt-4 pb-3">

                <div
                    class="rounded-circle d-flex align-items-center justify-content-center me-3"
                    style="
                        width: 52px;
                        height: 52px;
                        background-color: #f6f9ff;
                    "
                >
                    <i
                        class="bi bi-shield-lock"
                        style="
                            font-size: 25px;
                            color: #4154f1;
                        "
                    ></i>
                </div>

                <div>

                    <h5 class="mb-1">
                        Authentification à deux facteurs
                    </h5>

                    <p class="text-muted small mb-0">
                        Protégez votre compte avec une vérification supplémentaire.
                    </p>

                </div>

            </div>

            <hr>

            <div wire:cloak>

                {{-- ================================================= --}}
                {{-- 2FA ACTIVE --}}
                {{-- ================================================= --}}

                @if ($twoFactorEnabled)

                    <div class="alert alert-success border-0">

                        <div class="d-flex align-items-center">

                            <i
                                class="bi bi-shield-check me-3"
                                style="font-size: 28px;"
                            ></i>

                            <div>

                                <strong>
                                    Protection activée
                                </strong>

                                <div class="small">

                                    L'authentification à deux facteurs
                                    est active sur votre compte.

                                </div>

                            </div>

                        </div>

                    </div>

                    <p class="text-muted">

                        Lors de votre prochaine connexion,
                        vous devrez utiliser un code provenant
                        de votre application d'authentification.

                    </p>

                    {{-- BOUTON DESACTIVER --}}

                    <div class="mt-4 mb-4">

                        <button
                            type="button"
                            class="btn btn-outline-danger"
                            wire:click="disable"
                            wire:loading.attr="disabled"
                        >

                            <span
                                wire:loading.remove
                                wire:target="disable"
                            >

                                <i class="bi bi-shield-x me-1"></i>

                                Désactiver la protection

                            </span>

                            <span
                                wire:loading
                                wire:target="disable"
                            >

                                <span
                                    class="spinner-border spinner-border-sm me-1"
                                ></span>

                                Désactivation...

                            </span>

                        </button>

                    </div>

                    {{-- ================================================= --}}
                    {{-- CODES DE RECUPERATION --}}
                    {{-- COMPOSANT ORIGINAL --}}
                    {{-- ================================================= --}}

                    <div class="border-top pt-4">

                        <livewire:pages::settings.two-factor.recovery-codes
                            :$requiresConfirmation
                        />

                    </div>


                {{-- ================================================= --}}
                {{-- 2FA NON ACTIVE --}}
                {{-- ================================================= --}}

                @else

                    <div class="row align-items-center">

                        <div class="col-lg-8">

                            <div class="mb-3 mb-lg-0">

                                <h6>
                                    Activez une protection supplémentaire
                                </h6>

                                <p class="text-muted mb-0">

                                    Utilisez une application comme
                                    Google Authenticator, Microsoft Authenticator
                                    ou une autre application compatible pour
                                    générer un code sécurisé.

                                </p>

                            </div>

                        </div>

                        <div
                            class="col-lg-4 text-lg-end"
                        >

                            {{-- ================================================= --}}
                            {{-- BOUTON ORIGINAL --}}
                            {{-- IMPORTANT : OUVRE LE QR CODE --}}
                            {{-- ================================================= --}}

                            <flux:modal.trigger
                                name="two-factor-setup-modal"
                            >

                                <button
                                    type="button"
                                    class="btn btn-primary"
                                    wire:click="$dispatch('start-two-factor-setup')"
                                >

                                    <i class="bi bi-qr-code me-1"></i>

                                    Activer le 2FA

                                </button>

                            </flux:modal.trigger>

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- IMPORTANT --}}
                    {{-- CE COMPOSANT CONTIENT LE QR CODE ORIGINAL --}}
                    {{-- NE PAS SUPPRIMER --}}
                    {{-- ================================================= --}}

                    <livewire:pages::settings.two-factor-setup-modal
                        :requires-confirmation="$requiresConfirmation"
                    />

                @endif

            </div>

        </div>

    </div>

@endif


{{-- ========================================================= --}}
{{-- PASSKEYS --}}
{{-- ========================================================= --}}

@if ($canManagePasskeys)

    <div class="card mt-4">

        <div class="card-body">

            {{-- TITRE --}}

            <div class="d-flex align-items-center pt-4 pb-3">

                <div
                    class="rounded-circle d-flex align-items-center justify-content-center me-3"
                    style="
                        width: 52px;
                        height: 52px;
                        background-color: #f6f9ff;
                    "
                >

                    <i
                        class="bi bi-key"
                        style="
                            font-size: 25px;
                            color: #4154f1;
                        "
                    ></i>

                </div>

                <div>

                    <h5 class="mb-1">
                        Clés d'accès
                    </h5>

                    <p class="text-muted small mb-0">

                        Connectez-vous de manière sécurisée
                        sans utiliser votre mot de passe.

                    </p>

                </div>

            </div>

            <hr>

            <div wire:cloak>

                {{-- ================================================= --}}
                {{-- LISTE PASSKEYS --}}
                {{-- ================================================= --}}

                @forelse ($passkeys as $passkey)

                    <div
                        class="border rounded p-3 mb-3"
                        wire:key="passkey-{{ $passkey['id'] }}"
                    >

                        <div class="d-flex align-items-center">

                            {{-- ICON --}}

                            <div
                                class="rounded-circle d-flex align-items-center justify-content-center me-3"
                                style="
                                    width: 45px;
                                    height: 45px;
                                    background-color: #f6f9ff;
                                "
                            >

                                <i
                                    class="bi bi-key-fill"
                                    style="
                                        color: #4154f1;
                                        font-size: 20px;
                                    "
                                ></i>

                            </div>


                            {{-- INFORMATIONS --}}

                            <div class="flex-grow-1">

                                <div class="d-flex align-items-center">

                                    <strong>
                                        {{ $passkey['name'] }}
                                    </strong>

                                    @if ($passkey['authenticator'])

                                        <span
                                            class="badge bg-light text-dark ms-2"
                                        >

                                            {{ $passkey['authenticator'] }}

                                        </span>

                                    @endif

                                </div>


                                <small class="text-muted">

                                    Ajoutée
                                    {{ $passkey['created_at_diff'] }}

                                    @if ($passkey['last_used_at_diff'])

                                        <span class="mx-1">
                                            •
                                        </span>

                                        Dernière utilisation
                                        {{ $passkey['last_used_at_diff'] }}

                                    @endif

                                </small>

                            </div>


                            {{-- SUPPRIMER --}}

                            <button
                                type="button"
                                class="btn btn-outline-danger btn-sm"
                                wire:click="confirmDelete({{ $passkey['id'] }})"
                            >

                                <i class="bi bi-trash"></i>

                            </button>

                        </div>

                    </div>

                @empty

                    <div class="text-center py-5">

                        <div
                            class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                            style="
                                width: 65px;
                                height: 65px;
                                background-color: #f6f9ff;
                            "
                        >

                            <i
                                class="bi bi-key"
                                style="
                                    font-size: 30px;
                                    color: #4154f1;
                                "
                            ></i>

                        </div>

                        <h6>
                            Aucune clé d'accès
                        </h6>

                        <p class="text-muted small mb-0">

                            Ajoutez une clé d'accès pour vous connecter
                            sans utiliser votre mot de passe.

                        </p>

                    </div>

                @endforelse


                {{-- ================================================= --}}
                {{-- AJOUT PASSKEY --}}
                {{-- ================================================= --}}

                <div class="border-top pt-4 mt-4">

                    <h6>
                        Ajouter une clé d'accès
                    </h6>

                    <p class="text-muted small">

                        Vous pouvez utiliser votre téléphone,
                        votre ordinateur ou un gestionnaire
                        de mots de passe compatible.

                    </p>

                    <x-passkey-registration />

                </div>

            </div>

        </div>

    </div>

@endif


{{-- ========================================================= --}}
{{-- MODAL SUPPRESSION PASSKEY --}}
{{-- ========================================================= --}}

<flux:modal
    name="delete-passkey-modal"
    class="max-w-md md:min-w-md"
    wire:model="showDeleteModal"
    @close="closeDeleteModal"
>

    <div class="p-2">

        <div class="text-center mb-4">

            <div
                class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                style="
                    width: 60px;
                    height: 60px;
                    background-color: #fff1f1;
                "
            >

                <i
                    class="bi bi-exclamation-triangle"
                    style="
                        font-size: 28px;
                        color: #dc3545;
                    "
                ></i>

            </div>

            <h5>
                Supprimer cette clé ?
            </h5>

            <p class="text-muted small">

                Voulez-vous vraiment supprimer la clé d'accès

                <strong>
                    "{{ $deletingPasskeyName }}"
                </strong>

                ?

                <br>

                Cette action est irréversible.

            </p>

        </div>


        <div class="d-flex justify-content-center gap-2">

            <button
                type="button"
                class="btn btn-light"
                wire:click="closeDeleteModal"
            >

                Annuler

            </button>


            <button
                type="button"
                class="btn btn-danger"
                wire:click="deletePasskey"
                wire:loading.attr="disabled"
            >

                <span
                    wire:loading.remove
                    wire:target="deletePasskey"
                >

                    <i class="bi bi-trash me-1"></i>

                    Supprimer

                </span>


                <span
                    wire:loading
                    wire:target="deletePasskey"
                >

                    <span
                        class="spinner-border spinner-border-sm me-1"
                    ></span>

                    Suppression...

                </span>

            </button>

        </div>

    </div>

</flux:modal>

</section>
