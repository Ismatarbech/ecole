<div>

    {{-- =====================================================
        MESSAGES
    ====================================================== --}}

    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">

            <i class="bi bi-check-circle me-1"></i>

            {{ session('message') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close">
            </button>

        </div>
    @endif


    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">

            <i class="bi bi-exclamation-triangle me-1"></i>

            {{ session('error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close">
            </button>

        </div>
    @endif


    {{-- =====================================================
        TITRE
    ====================================================== --}}

    <div class="pagetitle">

        <h1>Etablissement</h1>

        <nav>

            <ol class="breadcrumb">

                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">
                        Accueil
                    </a>
                </li>

                <li class="breadcrumb-item active">
                    Etablissement
                </li>

            </ol>

        </nav>

    </div>


    {{-- =====================================================
        BOUTON CREER
    ====================================================== --}}

    <div class="d-flex justify-content-end mb-3">
        <div class="input-group me-3 index-search" style="max-width: 360px;">
            <span class="input-group-text bg-primary text-white"><i class="bi bi-search"></i></span>
            <input type="search" class="form-control border-primary" wire:model.live="search" placeholder="Rechercher un établissement...">
        </div>

        @canany(['create_etablissements'])

            <flux:button
                href="{{ route('etablissement.create') }}"
                icon="user-plus">

                Créer un établissement

            </flux:button>

        @endcanany

    </div>


    <br>


    {{-- =====================================================
        LISTE DES ETABLISSEMENTS
    ====================================================== --}}

    <div class="col-12">

        <div class="card recent-sales overflow-auto">

            <div class="card-body">

                <h5 class="card-title">
                    Liste des établissements
                    <span>| Aujourd'hui</span>
                </h5>


                <table class="table table-borderless datatable">

                    <thead>

                        <tr>

                            <th scope="col">
                                ID
                            </th>

                            <th scope="col">
                                Nom
                            </th>

                            <th scope="col">
                                Logo
                            </th>

                            <th scope="col">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($etablissements as $etablissement)

                            <tr>

                                {{-- ID --}}
                                <th scope="row">

                                    <a href="#">
                                        {{ $etablissement->id }}
                                    </a>

                                </th>


                                {{-- NOM --}}
                                <td>

                                    {{ $etablissement->nom }}

                                </td>


                                {{-- LOGO --}}
                                <td>

                                    @if ($etablissement->logo)

                                        <img
                                            src="{{ asset('storage/' . $etablissement->logo) }}"
                                            alt="Logo"
                                            class="rounded-circle"
                                            width="40"
                                            height="40"
                                            style="object-fit: cover;"
                                        >

                                    @else

                                        <span class="text-muted">
                                            Aucun logo
                                        </span>

                                    @endif

                                </td>


                                {{-- ACTIONS --}}
                                <td>

                                    {{-- MODIFIER --}}
                                    @canany(['update_etablissements'])

                                        <flux:button
                                            href="{{ route('etablissement.edit', $etablissement->id) }}"
                                           ariant="primary" color="white" icon:trailing="pencil"></flux:button>


                                    @endcanany


                                    {{-- SUPPRIMER --}}
                                    @canany(['delete_etablissements'])

                                        <flux:button
                                            wire:click="deleteEtablissement({{ $etablissement->id }})"
                                           variant="danger" color="red" icon:trailing="trash"></flux:button>
                                    @endcanany

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="4" class="text-center">

                                    <div class="alert alert-info mb-0">

                                        <i class="bi bi-info-circle me-1"></i>

                                        Aucun établissement trouvé.

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>