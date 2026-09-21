<div>

    {{-- ================= MESSAGES ================= --}}
    @if ($successMessage)
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-1"></i>
            {{ $successMessage }}
            <button class="btn-close" wire:click="$set('successMessage', '')"></button>
        </div>
    @endif

    @if ($errorMessage)
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle me-1"></i>
            {{ $errorMessage }}
            <button class="btn-close" wire:click="$set('errorMessage', '')"></button>
        </div>
    @endif


    {{-- ================= TITRE ================= --}}
    <div class="pagetitle">
        <h1>Classe</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Accueil</a></li>
                <li class="breadcrumb-item active">Classe</li>
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
                   placeholder="Rechercher une classe...">
        </div>

        @canany('create_classes')
            <flux:button href="{{ route('classe.create') }}" icon="user-plus">
                Nouvelle classe
            </flux:button>
        @endcanany

    </div>


    {{-- ================= TABLE ================= --}}
    <div class="card">
        <div class="card-body">

            <h5 class="card-title">Liste des classes</h5>

            <table class="table table-borderless">

                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Libellé</th>
                        <th>Niveau</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($classe as $classes)

                        <tr wire:key="classe-{{ $classes->id }}">

                           
                            <td>{{ $classes->name }}</td>
                            <td>{{ $classes->niveau->libelle ?? '-' }}</td>

                            <td>
                                <span class="badge bg-success">
                                    {{ $classes->niveau->code ?? '-' }}
                                </span>
                            </td>

                            <td class="d-flex gap-1">

                                @canany('update_classes')
                                    <flux:button
                                        href="{{ route('classe.edit', $classes->id) }}"
                                        variant="primary"
                                        color="white"
                                        icon:trailing="pencil" />
                                @endcanany

                                @canany('delete_classes')
                                    <flux:button
                                        wire:click="deleteClasse({{ $classes->id }})"
                                        wire:confirm="Supprimer cette classe ?"
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
                                    Aucune classe trouvée
                                </div>
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>


            {{-- ================= PAGINATION BOOTSTRAP STYLE ================= --}}
            @if ($classe->hasPages())
                <nav aria-label="Page navigation example" class="mt-3">
                    <ul class="pagination justify-content-end">

                        {{-- PREVIOUS --}}
                        <li class="page-item {{ $classe->onFirstPage() ? 'disabled' : '' }}">
                            <button class="page-link"
                                    wire:click="previousPage"
                                    @disabled($classe->onFirstPage())>
                                précédente
                            </button>
                        </li>

                        {{-- NUMBERS --}}
                        @foreach ($classe->getUrlRange(1, $classe->lastPage()) as $page => $url)
                            <li class="page-item {{ $classe->currentPage() == $page ? 'active' : '' }}">
                                <button class="page-link"
                                        wire:click="gotoPage({{ $page }})">
                                    {{ $page }}
                                </button>
                            </li>
                        @endforeach

                        {{-- NEXT --}}
                        <li class="page-item {{ $classe->hasMorePages() ? '' : 'disabled' }}">
                            <button class="page-link"
                                    wire:click="nextPage"
                                    @disabled(!$classe->hasMorePages())>
                                Suivant
                            </button>
                        </li>

                    </ul>
                </nav>
            @endif

        </div>
    </div>

</div>