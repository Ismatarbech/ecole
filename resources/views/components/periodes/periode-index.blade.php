<div>

    {{-- ================= ALERTS ================= --}}
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-1"></i>
            {{ session('success') }}
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


    {{-- ================= HEADER ================= --}}
    <div class="pagetitle">
        <h1>Semestre</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Accueil</a></li>
                <li class="breadcrumb-item active">Semestre</li>
            </ol>
        </nav>
    </div>


    {{-- ================= SEARCH + CREATE ================= --}}
    <div class="d-flex justify-content-end mb-3">

        <div class="input-group me-3 index-search" style="max-width: 360px;">
            <span class="input-group-text bg-primary text-white">
                <i class="bi bi-search"></i>
            </span>

            <input type="search"
                   class="form-control border-primary"
                   wire:model.live="search"
                   placeholder="Rechercher une période...">
        </div>

        @canany(['create_periodes'])
            <flux:button href="{{ route('periodes.create') }}" icon="user-plus">
                Nouveau semestre
            </flux:button>
        @endcanany

    </div>


    {{-- ================= TABLE ================= --}}
    <div class="col-12">

        <div class="card recent-sales overflow-auto">

            <div class="card-body">

                <h5 class="card-title">
                    Liste des périodes <span>| Aujourd'hui</span>
                </h5>

                <table class="table table-borderless datatable">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Année scolaire</th>
                            <th>Nom</th>
                            <th>Type</th>
                            <th>Ordre</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($periodes as $periode)

                            <tr wire:key="periode-{{ $periode->id }}">

                                <th scope="row">
                                    {{ $periode->id }}
                                </th>

                                <td>
                                    {{ $periode->anneeScolaire->scolaire_annee ?? '-' }}
                                </td>

                                <td>{{ $periode->nom }}</td>

                                <td>
                                    <span class="badge bg-info">
                                        {{ $periode->type }}
                                    </span>
                                </td>

                                <td>{{ $periode->ordre }}</td>

                                <td>
                                    @if($periode->statut === 'active')
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>

                                <td class="d-flex gap-1">

                                    {{-- TOGGLE --}}
                                    @if($periode->statut === 'inactive')
                                        <button class="btn btn-success"
                                                wire:click="toggleStatus({{ $periode->id }})"
                                                wire:confirm="Activer cette période ?">
                                            <i class="bi bi-check-circle"></i>
                                        </button>
                                    @else
                                        <button class="btn btn-danger"
                                                wire:click="toggleStatus({{ $periode->id }})"
                                                wire:confirm="Désactiver cette période ?">
                                            <i class="bi bi-exclamation-octagon"></i>
                                        </button>
                                    @endif

                                    {{-- EDIT --}}
                                    @canany(['update_periode'])
                                        <flux:button
                                            href="{{ route('periodes.edit', $periode->id) }}"
                                            variant="primary"
                                            color="white"
                                            icon:trailing="pencil" />
                                    @endcanany

                                    {{-- DELETE --}}
                                    @canany(['delete_periode'])
                                        <flux:button
                                            wire:click="deletePeriode({{ $periode->id }})"
                                            wire:confirm="Supprimer cette période ?"
                                            variant="danger"
                                            color="red"
                                            icon:trailing="trash" />
                                    @endcanany

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="7" class="text-center">
                                    <div class="alert alert-info mb-0">
                                        Aucune période trouvée.
                                    </div>
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>


                {{-- ================= PAGINATION CONDITIONNELLE ================= --}}
                @if ($periodes->total() > 10)

                    <div class="d-flex justify-content-end mt-3">

                        <nav>
                            <ul class="pagination justify-content-end">

                                {{-- PREVIOUS --}}
                                @if ($periodes->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">Précédente</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <button class="page-link" wire:click="previousPage">
                                            Précédente
                                        </button>
                                    </li>
                                @endif


                                {{-- NUMBERS --}}
                                @foreach ($periodes->getUrlRange(1, $periodes->lastPage()) as $page => $url)

                                    <li class="page-item {{ $periodes->currentPage() == $page ? 'active' : '' }}">
                                        <button class="page-link" wire:click="gotoPage({{ $page }})">
                                            {{ $page }}
                                        </button>
                                    </li>

                                @endforeach


                                {{-- NEXT --}}
                                @if ($periodes->hasMorePages())
                                    <li class="page-item">
                                        <button class="page-link" wire:click="nextPage">
                                            Suivant
                                        </button>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link">Suivant</span>
                                    </li>
                                @endif

                            </ul>
                        </nav>

                    </div>

                @endif


            </div>
        </div>

    </div>

</div>