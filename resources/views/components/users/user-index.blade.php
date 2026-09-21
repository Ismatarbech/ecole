<div>

    {{-- ALERTS --}}
    @if($successMessage)
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-1"></i>
            {{ $successMessage }}
            <button type="button" class="btn-close" wire:click="$set('successMessage', '')"></button>
        </div>
    @endif

    @if($errorMessage)
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle me-1"></i>
            {{ $errorMessage }}
            <button type="button" class="btn-close" wire:click="$set('errorMessage', '')"></button>
        </div>
    @endif


    {{-- HEADER --}}
    <div class="pagetitle">
        <h1>Utilisateur</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Accueil</a></li>
                <li class="breadcrumb-item active">Utilisateur</li>
            </ol>
        </nav>
    </div>


    {{-- SEARCH + BUTTON --}}
    <div class="d-flex justify-content-end mb-3">

        <div class="input-group me-3 index-search" style="max-width: 360px;">
            <span class="input-group-text bg-primary text-white">
                <i class="bi bi-search"></i>
            </span>

            <input type="search"
                   class="form-control border-primary"
                   wire:model.live="search"
                   placeholder="Rechercher un utilisateur...">
        </div>

        @canany(['create_users'])
            <flux:button
                href="{{ route('users.create') }}"
                icon="user-plus">
                Nouveau utilisateur
            </flux:button>
        @endcanany

    </div>


    {{-- TABLE --}}
    <div class="card">
        <div class="card-body">

            <h5 class="card-title">Liste des utilisateurs</h5>

            <table class="table table-borderless">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Roles</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($users as $user)

                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>

                            <td>
                                @forelse($user->roles as $role)
                                    <span class="badge bg-success">
                                        {{ $role->name }}
                                    </span>
                                @empty
                                    <span class="badge bg-secondary">Aucun rôle</span>
                                @endforelse
                            </td>

                            <td>
                                @canany('update_users')
                                    <flux:button
                                        href="{{ route('users.edit', $user->id) }}"
                                        variant="primary"
                                        color="white"
                                        icon:trailing="pencil" />
                                @endcanany

                                @canany('delete_users')
                                    @if(auth()->id() !== $user->id && !$user->hasRole('super-admin'))
                                        <flux:button
                                            wire:confirm="Etes vous vraiment supprimer cet utilisateur ?"
                                            wire:click="deleteUser({{ $user->id }})"
                                            variant="danger"
                                            color="red"
                                            icon:trailing="trash" />
                                    @endif
                                @endcanany
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                <div class="alert alert-info mb-0">
                                    Aucun utilisateur trouvé.
                                </div>
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>


            {{-- ✅ PAGINATION CONDITIONNELLE --}}
            @if ($users->total() > 10)
                <div class="d-flex justify-content-end mt-3">

                    <nav>
                        <ul class="pagination justify-content-end">

                            {{-- PREVIOUS --}}
                            @if ($users->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">précédente</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <button class="page-link" wire:click="previousPage">précédente</button>
                                </li>
                            @endif


                            {{-- NUMBERS --}}
                            @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                                <li class="page-item {{ $users->currentPage() == $page ? 'active' : '' }}">
                                    <button class="page-link" wire:click="gotoPage({{ $page }})">
                                        {{ $page }}
                                    </button>
                                </li>
                            @endforeach


                            {{-- NEXT --}}
                            @if ($users->hasMorePages())
                                <li class="page-item">
                                    <button class="page-link" wire:click="nextPage">Suivant</button>
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