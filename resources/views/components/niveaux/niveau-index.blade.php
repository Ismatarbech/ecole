<div>

    {{-- =====================================================
        MESSAGE DE SUCCÈS
    ====================================================== --}}

    @if (session()->has('message'))

        <div
            class="alert alert-success alert-dismissible fade show"
            role="alert"
        >

            <i class="bi bi-check-circle me-1"></i>

            {{ session('message') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close">
            </button>

        </div>

    @endif


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
                aria-label="Close">
            </button>

        </div>

    @endif


    {{-- =====================================================
        TITRE
    ====================================================== --}}

    <div class="pagetitle">

        <h1>Niveaux</h1>

        <nav>

            <ol class="breadcrumb">

                <li class="breadcrumb-item">

                    <a href="{{ url('/dashbord') }}">
                        Accueil
                    </a>

                </li>

                <li class="breadcrumb-item active">
                    Niveaux
                </li>

            </ol>

        </nav>

    </div>


    {{-- =====================================================
        BOUTON AJOUTER
    ====================================================== --}}

    <div class="d-flex justify-content-end mb-3">
        <div class="input-group me-3 index-search" style="max-width: 360px;">
            <span class="input-group-text bg-primary text-white"><i class="bi bi-search"></i></span>
            <input type="search" class="form-control border-primary" wire:model.live="search" placeholder="Rechercher un niveau...">
        </div>

        @canany(['create_niveaux'])

            <flux:button
                href="{{ route('niveaux.create') }}"
                icon="plus"
            >

                Ajouter un niveau

            </flux:button>

        @endcanany

    </div>


    {{-- =====================================================
        TABLEAU
    ====================================================== --}}

    <div class="col-12">

        <div class="card recent-sales overflow-auto">

            <div class="card-body">

                <h5 class="card-title">

                    Liste des niveaux

                </h5>


                <table class="table table-borderless datatable">

                    <thead>

                        <tr>

                            <th scope="col">
                                ID
                            </th>

                            <th scope="col">
                                Code
                            </th>

                            <th scope="col">
                                Libellé
                            </th>

                            <th scope="col">
                                Montant
                            </th>

                            <th scope="col">
                                Année scolaire
                            </th>

                            <th scope="col">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($niveaux as $niveau)

                            <tr>

                                {{-- ID --}}
                                <th scope="row">

                                    {{ $niveau->id }}

                                </th>


                                {{-- CODE --}}
                                <td>

                                    <span class="badge bg-primary">

                                        {{ $niveau->code }}

                                    </span>

                                </td>


                                {{-- LIBELLÉ --}}
                                <td>

                                    {{ $niveau->libelle }}

                                </td>


                                {{-- MONTANT --}}
                                <td>

                                    {{ number_format(
                                        $niveau->montant ?? 0,
                                        0,
                                        ',',
                                        ' '
                                    ) }}

                                    FCFA

                                </td>


                                {{-- ANNÉE SCOLAIRE --}}
                                <td>

                                    @if ($niveau->anneeScolaire)

                                        <span class="badge bg-success">

                                            {{ $niveau->anneeScolaire->scolaire_annee }}

                                        </span>

                                    @else

                                        <span class="text-muted">

                                            Aucune année

                                        </span>

                                    @endif

                                </td>


                                {{-- ACTIONS --}}
                                <td>

                                    @canany(['update_niveaux'])

                                        <flux:button
                                            href="{{ route('niveaux.edit', $niveau->id) }}"
                                           variant="primary" color="white" icon:trailing="pencil"></flux:button>


                                    @endcanany


                                    @canany(['delete_niveaux'])

                                        <flux:button
                                            wire:click="deleteNiveau({{ $niveau->id }})"
                                             variant="danger" color="red" icon:trailing="trash"></flux:button>


                                    @endcanany

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    class="text-center"
                                >

                                    <div class="alert alert-info mb-0">

                                        <i class="bi bi-info-circle me-1"></i>

                                        Aucun niveau trouvé.

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>


                {{-- =================================================
                    PAGINATION
                ================================================== --}}

                <div class="mt-3">

                    {{ $niveaux->links() }}

                </div>

            </div>

        </div>

    </div>

</div>