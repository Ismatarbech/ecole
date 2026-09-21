<div>

    {{-- ================= MESSAGES ================= --}}
    @if($successMessage)
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-1"></i>
            {{ $successMessage }}
            <button type="button"
                    class="btn-close"
                    wire:click="$set('successMessage', '')">
            </button>
        </div>
    @endif

    @if($errorMessage)
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle me-1"></i>
            {{ $errorMessage }}
            <button type="button"
                    class="btn-close"
                    wire:click="$set('errorMessage', '')">
            </button>
        </div>
    @endif


    {{-- ================= HEADER ================= --}}
    <div class="pagetitle">
        <h1>Permissions</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Accueil</a></li>
                <li class="breadcrumb-item active">Permissions</li>
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
                   placeholder="Rechercher une permission...">
        </div>

        @canany(['create_permissions'])
            <flux:button
                href="{{ route('permissions.create') }}"
                icon="user-plus">
                Créer une permission
            </flux:button>
        @endcanany

    </div>


    {{-- ================= TABLE ================= --}}
    <div class="col-12">

        <div class="card recent-sales overflow-auto">

            <div class="card-body">

                <h5 class="card-title">
                    Liste des permissions <span>| Aujourd'hui</span>
                </h5>

                <table class="table table-borderless datatable">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($permissions as $permission)

                            <tr>
                                <th scope="row">{{ $permission->id }}</th>

                                <td>{{ $permission->name }}</td>

                                <td>
                                    @if($permission->active)
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle me-1"></i>
                                            Actif
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            <i class="bi bi-x-circle me-1"></i>
                                            Désactivé
                                        </span>
                                    @endif
                                </td>

                                <td class="d-flex gap-1">

                                    @canany(['update_permissions'])
                                        <flux:button
                                            href="{{ route('permissions.edit', $permission->id) }}"
                                            variant="primary"
                                            color="white"
                                            icon:trailing="pencil" />
                                    @endcanany

                                    <button
                                        type="button"
                                        class="btn btn-sm {{ $permission->active ? 'btn-success' : 'btn-danger' }}"
                                        wire:click="toggleStatus({{ $permission->id }})"
                                        wire:confirm="Voulez-vous changer le statut de cette permission ?">

                                        @if($permission->active)
                                            <i class="bi bi-check-circle"></i>
                                        @else
                                            <i class="bi bi-x-circle"></i>
                                        @endif

                                    </button>

                                    @canany(['delete_permissions'])
                                        <flux:button
                                            wire:click="deletePermission({{ $permission->id }})"
                                            wire:confirm="Voulez-vous vraiment supprimer cette permission ?"
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
                                        Aucune permission trouvée.
                                    </div>
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>


                {{-- ================= PAGINATION CONDITIONNELLE ================= --}}
                @if ($permissions->total() > 10)

                    <div class="d-flex justify-content-center mt-3 pagination-school">

                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-end">

                                {{-- PREVIOUS --}}
                                @if ($permissions->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">précédente</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <button class="page-link" wire:click="previousPage">
                                            précédente
                                        </button>
                                    </li>
                                @endif


                                {{-- NUMBERS --}}
                                @foreach ($permissions->getUrlRange(1, $permissions->lastPage()) as $page => $url)

                                    <li class="page-item {{ $permissions->currentPage() == $page ? 'active' : '' }}">
                                        <button class="page-link" wire:click="gotoPage({{ $page }})">
                                            {{ $page }}
                                        </button>
                                    </li>

                                @endforeach


                                {{-- NEXT --}}
                                @if ($permissions->hasMorePages())
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