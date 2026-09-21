<div>

    {{-- =====================================================
        MESSAGES
    ====================================================== --}}

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-1"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif


    {{-- =====================================================
        TITRE
    ====================================================== --}}

    <div class="pagetitle">
        <h1>Année scolaire</h1>

        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Accueil</a></li>
                <li class="breadcrumb-item active">Année scolaire</li>
            </ol>
        </nav>
    </div>


    {{-- =====================================================
        SEARCH + CREATE
    ====================================================== --}}

    <div class="d-flex justify-content-end mb-3">

        <div class="input-group me-3 index-search" style="max-width: 360px;">
            <span class="input-group-text bg-primary text-white">
                <i class="bi bi-search"></i>
            </span>

            <input type="search"
                   class="form-control border-primary"
                   wire:model.live="search"
                   placeholder="Rechercher une année...">
        </div>

        @canany(['create_annee_scolaire'])
            <flux:button href="{{ route('anneescolaire.create') }}" icon="user-plus">
                Nouvelle année scolaire
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
                    Liste des années scolaires <span>| Aujourd'hui</span>
                </h5>


                <table class="table table-borderless datatable">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Année scolaire</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>


                    <tbody>

                        @forelse($anneescolaires as $annee)

                            <tr wire:key="annee-{{ $annee->id }}">

                                <th>{{ $annee->id }}</th>

                                <td>{{ $annee->scolaire_annee }}</td>

                                <td>
                                    @if($annee->status === 'active')
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>

                                <td class="d-flex gap-1">

                                    {{-- TOGGLE --}}
                                    @if($annee->status === 'inactive')

                                        <button class="btn btn-sm btn-success"
                                                wire:click="toggleStatus({{ $annee->id }})">
                                            <i class="bi bi-check-circle"></i>
                                        </button>

                                    @else

                                        <button class="btn btn-sm btn-danger"
                                                wire:click="toggleStatus({{ $annee->id }})">
                                            <i class="bi bi-exclamation-octagon"></i>
                                        </button>

                                    @endif


                                    {{-- EDIT --}}
                                    @canany(['update_annee_scolaire'])
                                        <flux:button href="{{ route('anneescolaire.edit', $annee->id) }}"
                                                     variant="primary"
                                                     color="white"
                                                     icon:trailing="pencil" />
                                    @endcanany


                                    {{-- DELETE --}}
                                    @canany(['delete_annee_scolaire'])
                                        <flux:button wire:click="deleteAnneescolaire({{ $annee->id }})"
                                                     wire:confirm="Voulez-vous vraiment supprimer cette année scolaire ?"
                                                     variant="danger"
                                                     color="red"
                                                     icon:trailing="trash" />
                                    @endcanany

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="4" class="text-center">
                                    <div class="alert alert-info mb-0">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Aucune année scolaire trouvée.
                                    </div>
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>


                {{-- =====================================================
                    PAGINATION (ONLY IF MORE THAN 1 PAGE)
                ====================================================== --}}

                @if($anneescolaires->hasPages())

                    <nav aria-label="Page navigation example" class="mt-3">

                        <ul class="pagination justify-content-end">

                            {{-- Previous --}}
                            <li class="page-item {{ $anneescolaires->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $anneescolaires->previousPageUrl() ?? '#' }}">
                                    précédente
                                </a>
                            </li>

                            {{-- Pages --}}
                            @foreach ($anneescolaires->getUrlRange(1, $anneescolaires->lastPage()) as $page => $url)

                                <li class="page-item {{ $anneescolaires->currentPage() == $page ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url }}">
                                        {{ $page }}
                                    </a>
                                </li>

                            @endforeach

                            {{-- Next --}}
                            <li class="page-item {{ !$anneescolaires->hasMorePages() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $anneescolaires->nextPageUrl() ?? '#' }}">
                                    Suivant
                                </a>
                            </li>

                        </ul>

                    </nav>

                @endif


            </div>

        </div>

    </div>

</div>