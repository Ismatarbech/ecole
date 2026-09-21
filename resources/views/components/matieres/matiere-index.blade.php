<div>

    {{-- ================= MESSAGES ================= --}}
    @if (session()->has('success') || session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-1"></i>
            {{ session('success') ?? session('message') }}
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


    {{-- ================= TITRE ================= --}}
    <div class="pagetitle">
        <h1>Matières</h1>

        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active">Matières</li>
            </ol>
        </nav>
    </div>


    {{-- ================= SEARCH + BUTTON ================= --}}
    <div class="d-flex justify-content-end mb-3">

        <div class="input-group me-3" style="max-width: 360px;">
            <span class="input-group-text bg-primary text-white">
                <i class="bi bi-search"></i>
            </span>

            <input type="search"
                   class="form-control"
                   wire:model.live="search"
                   placeholder="Rechercher une matière...">
        </div>

        @canany('create_matieres')
            <flux:button href="{{ route('matiere.create') }}" icon="user-plus">
                Insérer une matière
            </flux:button>
        @endcanany

    </div>


    {{-- ================= TABLE ================= --}}
    <div class="card">
        <div class="card-body">

            <h5 class="card-title">Liste des matières</h5>

            <table class="table table-borderless">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Coefficient</th>
                        <th>Niveau</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($matieres as $matiere)

                        <tr wire:key="matiere-{{ $matiere->id }}">

                            <td>{{ $matiere->id }}</td>

                            <td>{{ $matiere->nom }}</td>

                            <td>{{ $matiere->coefficient }}</td>

                            <td>
                                <span class="badge bg-success">
                                    {{ $matiere->niveau->code ?? '-' }}
                                </span>
                            </td>

                            <td class="d-flex gap-1">

                                @canany('update_matieres')
                                    <flux:button
                                        href="{{ route('matiere.edit', $matiere->id) }}"
                                        variant="primary"
                                        color="white"
                                        icon:trailing="pencil" />
                                @endcanany

                                @canany('delete_matieres')
                                    <flux:button
                                        wire:click="deleteMatiere({{ $matiere->id }})"
                                        wire:confirm="Êtes-vous sûr de supprimer cette matière ?"
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
                                    Aucune matière trouvée
                                </div>
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>


            {{-- ================= PAGINATION FIX ================= --}}
            @if($matieres->hasPages())

                <nav aria-label="Page navigation" class="mt-3">
                    <ul class="pagination justify-content-end">

                        {{-- PREVIOUS --}}
                        <li class="page-item {{ $matieres->onFirstPage() ? 'disabled' : '' }}">
                            <button class="page-link"
                                    wire:click="previousPage"
                                    @disabled($matieres->onFirstPage())>
                                précédente
                            </button>
                        </li>

                        {{-- NUMBERS --}}
                        @foreach ($matieres->getUrlRange(1, $matieres->lastPage()) as $page => $url)

                            <li class="page-item {{ $matieres->currentPage() == $page ? 'active' : '' }}">
                                <button class="page-link"
                                        wire:click="gotoPage({{ $page }})">
                                    {{ $page }}
                                </button>
                            </li>

                        @endforeach

                        {{-- NEXT --}}
                        <li class="page-item {{ $matieres->hasMorePages() ? '' : 'disabled' }}">
                            <button class="page-link"
                                    wire:click="nextPage"
                                    @disabled(!$matieres->hasMorePages())>
                                Suivant
                            </button>
                        </li>

                    </ul>
                </nav>

            @endif


        </div>
    </div>

</div>