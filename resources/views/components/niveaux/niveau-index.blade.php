<div>

    {{-- =====================================================
        MESSAGES
    ====================================================== --}}

    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-1"></i>
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle me-1"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif


    {{-- =====================================================
        TITRE
    ====================================================== --}}

    <div class="pagetitle">
        <h1>Niveaux</h1>

        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Accueil</a></li>
                <li class="breadcrumb-item active">Niveaux</li>
            </ol>
        </nav>
    </div>


    {{-- =====================================================
        ACTIONS
    ====================================================== --}}

    <div class="d-flex justify-content-end mb-3">

        <div class="input-group me-3 index-search" style="max-width: 360px;">
            <span class="input-group-text bg-primary text-white">
                <i class="bi bi-search"></i>
            </span>

            <input type="search"
                   class="form-control border-primary"
                   wire:model.live="search"
                   placeholder="Rechercher un niveau...">
        </div>

        @canany(['create_niveaux'])
            <flux:button
                href="{{ route('niveaux.create') }}"
                icon="user-plus">
                Créer un niveau
            </flux:button>
        @endcanany

    </div>


    {{-- =====================================================
        TABLE
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
                            <th>Code</th>
                            <th>Libellé</th>
                            <th>Montant</th>
                            <th>Année scolaire</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($niveaux as $niveau)

                            <tr>

                                <td>
                                    <span class="badge bg-primary">
                                        {{ $niveau->code }}
                                    </span>
                                </td>

                                <td>{{ $niveau->libelle }}</td>

                                <td>
                                    {{ number_format($niveau->montant ?? 0, 0, ',', ' ') }} FCFA
                                </td>

                                <td>
                                    @if($niveau->anneeScolaire)
                                        <span class="badge bg-success">
                                            {{ $niveau->anneeScolaire->scolaire_annee }}
                                        </span>
                                    @else
                                        <span class="text-muted">Aucune année</span>
                                    @endif
                                </td>

                                <td class="d-flex gap-1">

                                    @canany(['update_niveaux'])
                                        <flux:button
                                            href="{{ route('niveaux.edit', $niveau->id) }}"
                                            variant="primary"
                                            color="white"
                                            icon:trailing="pencil" />
                                    @endcanany

                                    @canany(['delete_niveaux'])
                                        <flux:button
                                            wire:confirm="Etes vous vraiment supprimer ce niveau ?"
                                            wire:click="deleteNiveau({{ $niveau->id }})"
                                            variant="danger"
                                            color="red"
                                            icon:trailing="trash" />
                                    @endcanany

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="5" class="text-center">
                                    <div class="alert alert-info mb-0">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Aucun niveau trouvé.
                                    </div>
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

                {{-- =====================================================
                    PAGINATION CUSTOM (condition >= 10)
                ====================================================== --}}

                @if($niveaux->count() >= 10)

                    <nav aria-label="Page navigation example" class="mt-3">
                        <ul class="pagination justify-content-end">

                            {{-- PREVIOUS --}}
                            <li class="page-item {{ $niveaux->onFirstPage() ? 'disabled' : '' }}">
                                <button class="page-link" wire:click="previousPage">
                                    Previous
                                </button>
                            </li>

                            {{-- NUMBERS --}}
                            @foreach ($niveaux->getUrlRange(1, $niveaux->lastPage()) as $page => $url)
                                <li class="page-item {{ $niveaux->currentPage() == $page ? 'active' : '' }}">
                                    <button class="page-link" wire:click="gotoPage({{ $page }})">
                                        {{ $page }}
                                    </button>
                                </li>
                            @endforeach

                            {{-- NEXT --}}
                            <li class="page-item {{ $niveaux->hasMorePages() ? '' : 'disabled' }}">
                                <button class="page-link" wire:click="nextPage">
                                    Next
                                </button>
                            </li>

                        </ul>
                    </nav>

                @endif

            </div>

        </div>

    </div>

</div>