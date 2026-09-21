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


    {{-- ================= PAGE TITLE ================= --}}
    <div class="pagetitle">
        <h1>Rôles</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Accueil</a></li>
                <li class="breadcrumb-item active">Rôles</li>
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
                   class="form-control border-primary"
                   wire:model.live="search"
                   placeholder="Rechercher un rôle...">
        </div>

        @canany(['create_roles'])
            <flux:button href="{{ route('roles.create') }}" icon="user-plus">
                Créer un rôle
            </flux:button>
        @endcanany

    </div>


    {{-- ================= TABLE ================= --}}
    <div class="card">

        <div class="card-body">

            <h5 class="card-title">
                Liste des rôles
            </h5>

            <table class="table table-borderless align-middle">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($roles as $role)

                    <tr>

                        {{-- ID --}}
                        <td>{{ $role->id }}</td>

                        {{-- NOM --}}
                        <td>
                            <strong>
                                {{ $role->name }}

                                {{-- 🔥 SUPER ADMIN BADGE --}}
                                @if($role->name === 'super-admin')
                                    <span class="badge bg-dark ms-2">Super Admin</span>
                                @endif
                            </strong>
                        </td>

                        {{-- STATUS --}}
                        <td>
                            @if($role->active)
                                <span class="badge bg-success">
                                    Actif
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    Désactivé
                                </span>
                            @endif
                        </td>

                        {{-- ACTIONS --}}
                        <td class="d-flex gap-1">

                            {{-- EDIT --}}
                            @canany(['update_roles'])
                                  @if($role->name !== 'super-admin')
                                <flux:button
                                    href="{{ route('roles.edit', $role->id) }}"
                                    variant="primary"
                                    icon:trailing="pencil" />
                                @endif
                            @endcanany

                            {{-- TOGGLE --}}
                            @if($role->name !== 'super-admin')
                            <button
                                class="btn btn-sm {{ $role->active ? 'btn-success' : 'btn-danger' }}"
                                wire:click="toggleStatus({{ $role->id }})"
                                wire:confirm="Voulez-vous changer le statut ?">

                                @if($role->active)
                                    <i class="bi bi-check-circle"></i>
                                @else
                                    <i class="bi bi-x-circle"></i>
                                @endif

                            </button>
                            @endif

                            {{-- DELETE --}}
                            @canany(['delete_roles'])
                              @if($role->name !== 'super-admin')
                                <button
                                    class="btn btn-sm btn-danger"
                                    wire:click="deleteRole({{ $role->id }})"
                                    wire:confirm="Voulez-vous supprimer ce rôle ?">
                                    <i class="bi bi-trash"></i>
                                </button>
                                @endif
                            @endcanany

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="4" class="text-center">
                            <div class="alert alert-info mb-0">
                                Aucun rôle trouvé
                            </div>
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>


            {{-- ================= PAGINATION CUSTOM ================= --}}
            <div class="d-flex justify-content-center mt-4 pagination-school">

                @if ($roles->total() > 10)

                    <nav>
                        <ul class="pagination">

                            {{-- PREVIOUS --}}
                            @if ($roles->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">Précédent</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <button class="page-link"
                                            wire:click="previousPage">
                                        Précédent
                                    </button>
                                </li>
                            @endif


                            {{-- NUMBERS --}}
                            @foreach ($roles->getUrlRange(1, $roles->lastPage()) as $page => $url)

                                <li class="page-item {{ $roles->currentPage() == $page ? 'active' : '' }}">
                                    <button class="page-link"
                                            wire:click="gotoPage({{ $page }})">
                                        {{ $page }}
                                    </button>
                                </li>

                            @endforeach


                            {{-- NEXT --}}
                            @if ($roles->hasMorePages())
                                <li class="page-item">
                                    <button class="page-link"
                                            wire:click="nextPage">
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

                @endif

            </div>

        </div>

    </div>

</div>