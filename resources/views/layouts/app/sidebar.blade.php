<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">

@php
    $contactsDashboard = \App\Models\Contact::latest()->take(4)->get();
    $contactsDashboardCount = \App\Models\Contact::count();
@endphp


{{-- ===================================================== --}}
{{-- HEADER --}}
{{-- ===================================================== --}}

<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">

        <a href="/" class="logo d-flex align-items-center">

            <img src="/assets/img/logo.png" alt="Logo">

            <span class="d-none d-lg-block">
                School
            </span>

        </a>

        {{-- BOUTON AGRANDIR / RÉDUIRE --}}
        <i class="bi bi-list toggle-sidebar-btn"></i>

    </div>


    {{-- ===================================================== --}}
    {{-- NAVIGATION DROITE --}}
    {{-- ===================================================== --}}

    <nav class="header-nav ms-auto">

        <ul class="d-flex align-items-center">


            {{-- ================================================= --}}
            {{-- MESSAGES --}}
            {{-- ================================================= --}}
            @canany(['view_contacts'])
            <li class="nav-item dropdown">

                <a class="nav-link nav-icon"
                   href="#"
                   data-bs-toggle="dropdown">

                    <i class="bi bi-chat-left-text"></i>

                    <span class="badge bg-success badge-number">
                        {{ $contactsDashboardCount }}
                    </span>

                </a>

               
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">

                    <li class="dropdown-header">

                        {{ $contactsDashboardCount }}
                        nouveau(x) message(s)

                    </li>


                    <li>
                        <hr class="dropdown-divider">
                    </li>


                    @forelse($contactsDashboard as $contact)

                        @php
                            $eleveContact = \App\Models\Eleve::where(
                                'matricule',
                                $contact->matricule
                            )->first();
                        @endphp


                        <li class="message-item">

                            <a href="#">

                                @if(
                                    $eleveContact?->photo &&
                                    file_exists(
                                        storage_path(
                                            'app/public/' . $eleveContact->photo
                                        )
                                    )
                                )

                                    <img
                                        src="{{ asset('storage/' . $eleveContact->photo) }}"
                                        alt="Photo de {{ $contact->nom }}"
                                        class="message-avatar rounded-circle"
                                    >

                                @else

                                    <span class="message-avatar message-avatar-fallback rounded-circle">

                                        <i class="bi bi-person-fill"></i>

                                    </span>

                                @endif


                                <div class="message-content">

                                    <h4>

                                        {{ $contact->nom }}

                                        {{ $eleveContact?->prenom }}

                                    </h4>


                                    <p class="message-subject">

                                        {{ $contact->sujet }}

                                    </p>


                                    <p class="message-preview">

                                        {{ $contact->reclammation }}

                                    </p>


                                    <p class="message-time">

                                        {{
                                            $contact->created_at
                                                ?->locale('fr')
                                                ->diffForHumans()
                                            ?? '-'
                                        }}

                                    </p>

                                </div>

                            </a>

                        </li>


                        @if(!$loop->last)

                            <li>
                                <hr class="dropdown-divider">
                            </li>

                        @endif

                    @empty

                        <li class="message-item">

                            <a href="#">

                                <i class="bi bi-info-circle text-primary"></i>

                                <div>

                                    <p>
                                        Aucun message.
                                    </p>

                                </div>

                            </a>

                        </li>

                    @endforelse


                    <li class="dropdown-footer">

                        <a href="/contacts">

                            Tous les messages

                        </a>

                    </li>

                </ul>
              

            </li>
            @endcanany


            {{-- ================================================= --}}
            {{-- PROFIL --}}
            {{-- ================================================= --}}

            <li class="nav-item dropdown pe-3">

                <a
                    class="nav-link nav-profile d-flex align-items-center pe-0"
                    href="#"
                    data-bs-toggle="dropdown"
                >

                    <img
                        src="/assets/img/profile-img.jpg"
                        alt="Profile"
                        class="rounded-circle"
                    >

                    <span class="d-none d-md-block dropdown-toggle ps-2">

                        {{ auth()->user()->name }}

                    </span>

                </a>


                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">


                    <li class="dropdown-header">

                        <h6>

                            {{ auth()->user()->name }}

                        </h6>

                        <span>

                            {{ auth()->user()->email }}

                        </span>

                    </li>


                    <li>

                        <hr class="dropdown-divider">

                    </li>


                    {{-- MON PROFIL --}}

                    <li>

                        <flux:menu.item
                            :href="route('profile.edit')"
                            class="dropdown-item d-flex align-items-center"
                            wire:navigate
                        >

                            <i class="bi bi-person"></i>

                            <span>
                                Mon profil
                            </span>

                        </flux:menu.item>

                    </li>


                    <li>

                        <hr class="dropdown-divider">

                    </li>


                    {{-- SÉCURITÉ --}}

                    <li>

                        <flux:menu.item
                            :href="route('security.edit')"
                            class="dropdown-item d-flex align-items-center"
                            wire:navigate
                        >

                            <i class="bi bi-shield-lock"></i>

                            <span>
                                Mot de passe et sécurité
                            </span>

                        </flux:menu.item>

                    </li>


                    <li>

                        <hr class="dropdown-divider">

                    </li>


                    {{-- DÉCONNEXION --}}

                    <li>

                        <form
                            method="POST"
                            action="{{ route('logout') }}"
                        >

                            @csrf

                            <flux:menu.item
                                as="button"
                                type="submit"
                                data-test="logout-button"
                                class="dropdown-item d-flex align-items-center"
                            >

                                <i class="bi bi-box-arrow-right"></i>

                                <span>
                                    Decoonecté
                                </span>

                            </flux:menu.item>

                        </form>

                    </li>

                </ul>

            </li>

        </ul>

    </nav>

</header>



{{-- ===================================================== --}}
{{-- SIDEBAR --}}
{{-- ===================================================== --}}

<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">


        {{-- DASHBOARD --}}

        <li class="nav-item">

            <a class="nav-link" href="/">

                <i class="bi bi-grid"></i>

                <span>
                    Dashboard
                </span>

            </a>

        </li>


        {{-- DONNÉES --}}

        @canany(['view_donnees', 'view_any_donnees'])

            <li class="nav-item">

                <a class="nav-link collapsed" href="/donnees">

                    <i class="bi bi-bar-chart"></i>

                    <span>
                        Données
                    </span>

                </a>

            </li>

        @endcanany


        <li class="nav-heading">
            Pages
        </li>


        {{-- ETABLISSEMENTS --}}

        @canany(['view_etablissements', 'view_any_etablissements'])

            <li class="nav-item">

                <a class="nav-link collapsed" href="/etablissements">

                    <i class="bi bi-house-door"></i>

                    <span>
                        Etablissements
                    </span>

                </a>

            </li>

        @endcanany


        {{-- UTILISATEURS --}}

        @canany(['view_users', 'view_any_users'])

            <li class="nav-item">

                <a class="nav-link collapsed" href="/users">

                    <i class="bi bi-person"></i>

                    <span>
                        Utilisateurs
                    </span>

                </a>

            </li>

        @endcanany


        {{-- PERMISSIONS --}}

        @canany(['view_permissions', 'view_any_permissions'])

            <li class="nav-item">

                <a class="nav-link collapsed" href="/permissions">

                    <i class="bi bi-clipboard-check"></i>

                    <span>
                        Permissions
                    </span>

                </a>

            </li>

        @endcanany


        {{-- ROLES --}}

        @canany([
            'view_roles',
            'view_any_roles',
            'view_permissions',
            'view_any_permissions'
        ])

            <li class="nav-item">

                <a class="nav-link collapsed" href="/roles">

                    <i class="bi bi-columns-gap"></i>

                    <span>
                        Roles
                    </span>

                </a>

            </li>

        @endcanany


        {{-- ANNÉE SCOLAIRE --}}

        @canany([
            'view_annee_scolaire',
            'view_any_annee_scolaire'
        ])

            <li class="nav-item">

                <a class="nav-link collapsed" href="/anneescolaire">

                    <i class="bi bi-calendar-date"></i>

                    <span>
                        Année scolaire
                    </span>

                </a>

            </li>

        @endcanany


        {{-- PÉRIODES --}}
          @canany([
            'view_periode',
            'view_any_periodes'
        ])

        <li class="nav-item">

            <a
                class="nav-link collapsed"
                href="{{ route('periodes.index') }}"
            >

                <i class="bi bi-calendar3"></i>

                <span>
                    Périodes scolaires
                </span>

            </a>

        </li>
        @endcanany


        {{-- NIVEAUX --}}

        @canany(['view_niveaux', 'view_any_niveaux'])

            <li class="nav-item">

                <a class="nav-link collapsed" href="/niveaux">

                    <i class="bi bi-door-open"></i>

                    <span>
                        Niveaux
                    </span>

                </a>

            </li>

        @endcanany


        {{-- CLASSES --}}

        @canany(['view_classes', 'view_any_classes'])

            <li class="nav-item">

                <a class="nav-link collapsed" href="/classes">

                    <i class="bi bi-shop"></i>

                    <span>
                        Classes
                    </span>

                </a>

            </li>

        @endcanany

          {{-- MATIÈRES --}}

        @canany([
            'view_matieres',
            'view_any_matieres'
        ])

            <li class="nav-item">

                <a
                    class="nav-link collapsed"
                    href="/matieres"
                >

                    <i class="bi bi-book"></i>

                    <span>
                        Matières
                    </span>

                </a>

            </li>

        @endcanany


        {{-- ENSEIGNANTS --}}

        @canany(['view_enseignants', 'view_any_enseignants'])

            <li class="nav-item">

                <a
                    class="nav-link collapsed"
                    href="/enseignants"
                >

                    <i class="bi bi-person-workspace"></i>

                    <span>
                        Enseignants
                    </span>

                </a>

            </li>

        @endcanany


        {{-- INSCRIPTIONS --}}

        @canany([
            'view_inscriptions',
            'view_any_inscriptions'
        ])

            <li class="nav-item">

                <a
                    class="nav-link collapsed"
                    href="/inscriptions"
                >

                    <i class="bi bi-people"></i>

                    <span>
                        Eleves
                    </span>

                </a>

            </li>

        @endcanany


        {{-- NOTES --}}

        @canany([
            'view_notes',
            'view_any_notes'
        ])

            <li class="nav-item">

                <a
                    class="nav-link collapsed"
                    href="/notes"
                >

                    <i class="bi bi-card-list"></i>

                    <span>
                        Notes
                    </span>

                </a>

            </li>

        @endcanany


        {{-- RÉCLAMATION --}}

        @canany([
            'view_contacts',
            'view_any_contacts'
        ])

            <li class="nav-item">

                <a
                    class="nav-link collapsed"
                    href="/contacts/create"
                >

                    <i class="bi bi-telephone"></i>

                    <span>
                        Revendication
                    </span>

                </a>

            </li>

        @endcanany


         {{-- RÉCLAMATION --}}

        @canany([
            'view_corbeille',
            'view_any_corbeille'
        ])

            <li class="nav-item">

                <a
                    class="nav-link collapsed"
                    href="/corbeilles"
                >

                    <i class="bi bi-trash"></i>

                    <span>
                        Corbeille
                    </span>

                </a>

            </li>

        @endcanany

    </ul>

</aside>



{{-- ===================================================== --}}
{{-- CONTENU PRINCIPAL --}}
{{-- ===================================================== --}}

<main id="main" class="main">

    {{ $slot }}

</main>



{{-- ===================================================== --}}
{{-- TOAST --}}
{{-- ===================================================== --}}

@persist('toast')

    <flux:toast.group>

        <flux:toast />

    </flux:toast.group>

@endpersist


@fluxScripts


{{-- ===================================================== --}}
{{-- SIDEBAR TOGGLE --}}
{{-- ===================================================== --}}

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const toggleButton = document.querySelector(
            '.toggle-sidebar-btn'
        );

        if (toggleButton) {

            toggleButton.addEventListener(
                'click',
                function () {

                    document.body.classList.toggle(
                        'toggle-sidebar'
                    );

                }
            );

        }

    });
</script>


{{-- ===================================================== --}}
{{-- CSS DU BOUTON SIDEBAR --}}
{{-- ===================================================== --}}

<style>

    #sidebar {
        transition: all 0.3s ease;
    }

    #main {
        transition: all 0.3s ease;
    }


    /* =========================
       ORDINATEUR
    ========================= */

    @media (min-width: 1200px) {

        .toggle-sidebar #sidebar {
            margin-left: -300px;
        }

        .toggle-sidebar #main {
            margin-left: 0;
        }

    }


    /* =========================
       TABLETTE / MOBILE
    ========================= */

    @media (max-width: 1199px) {

        #sidebar {
            left: -300px;
        }

        .toggle-sidebar #sidebar {
            left: 0;
        }

    }

</style>


</body>

</html>
