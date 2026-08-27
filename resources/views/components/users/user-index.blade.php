<div>
    @if (session()->has('success') || session()->has('message'))
        <div class="alert alert-success">{{ session('success') ?? session('message') }}</div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- MESSAGE SUCCÈS --}}
    @if($successMessage)

        <div
            class="alert alert-success alert-dismissible fade show"
            role="alert"
        >
            <i class="bi bi-check-circle me-1"></i>

            {{ $successMessage }}

            <button
                type="button"
                class="btn-close"
                wire:click="$set('successMessage', '')"
            ></button>
        </div>

    @endif


    {{-- MESSAGE ERREUR --}}
    @if($errorMessage)

        <div
            class="alert alert-danger alert-dismissible fade show"
            role="alert"
        >
            <i class="bi bi-exclamation-triangle me-1"></i>

            {{ $errorMessage }}

            <button
                type="button"
                class="btn-close"
                wire:click="$set('errorMessage', '')"
            ></button>
        </div>

    @endif


    <div class="pagetitle">

        <h1>Utilisateur</h1>

        <nav>
            <ol class="breadcrumb">

                <li class="breadcrumb-item">
                    <a href="/dashboard">
                        Accueil
                    </a>
                </li>

                <li class="breadcrumb-item active">
                    Utilisateur
                </li>

            </ol>
        </nav>

    </div>


    <div class="user-index-toolbar d-flex justify-content-end align-items-center gap-2 mb-3">

        <div class="input-group index-search">
            <span class="input-group-text" aria-hidden="true">
                <i class="bi bi-search"></i>
            </span>
            <input type="search" class="form-control border-primary" wire:model.live="search" placeholder="Rechercher un utilisateur...">
        </div>

        @canany('create_users')

            <flux:button
                href="{{ route('users.create') }}"
                icon="user-plus"
                class="user-index-create"
            >
                Nouveau utilisateur
            </flux:button>

        @endcanany

    </div>


    <div class="col-12">

        <div class="card recent-sales overflow-auto">

            <div class="card-body">

                <h5 class="card-title">
                    Liste des utilisateurs
                </h5>


                <table class="table table-borderless datatable">

                    <thead>

                        <tr>

                            <th>Matricule</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Actions</th>
                            <th>Roles</th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($users as $user)

                            <tr>

                                <th>
                                    {{ $user->id }}
                                </th>

                                <td>
                                    {{ $user->name }}
                                </td>

                                <td>
                                    {{ $user->email }}
                                </td>


                                <td>

                                    @canany('update_users')

                                        <flux:button
                                            href="{{ route('users.edit', $user->id) }}"
                                            variant="primary"
                                            color="white"
                                            icon:trailing="pencil"
                                        />

                                    @endcanany


                                    @canany('delete_users')

                                        <flux:button
                                            wire:click="deleteUser({{ $user->id }})"
                                            variant="danger"
                                            color="red"
                                            icon:trailing="trash"
                                        />

                                    @endcanany

                                </td>


                                <td>

                                    @forelse($user->roles as $role)

                                        <span class="badge bg-success me-1">
                                            {{ $role->name }}
                                        </span>

                                    @empty

                                        <span class="badge bg-secondary">
                                            Aucun rôle
                                        </span>

                                    @endforelse

                                </td>

                            </tr>

                        @empty
                            <tr>
                                <td colspan="5" class="text-center">
                                    <div class="alert alert-info mb-0">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Aucun utilisateur trouvé.
                                    </div>
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>


                <div class="mt-3">
                    {{ $users->links() }}
                </div>

            </div>

        </div>

    </div>

</div>