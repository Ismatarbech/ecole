<div>

    {{-- =========================================================
        MESSAGE DE SUCCÈS
    ========================================================== --}}
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i>
            {{ session('message') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close">
            </button>
        </div>
    @endif


    {{-- =========================================================
        MESSAGE D'ERREUR
    ========================================================== --}}
    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-1"></i>
            {{ session('error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close">
            </button>
        </div>
    @endif


    {{-- =========================================================
        TITRE DE LA PAGE
    ========================================================== --}}
    <div class="pagetitle">

        <h1>Rôles</h1>

        <nav>
            <ol class="breadcrumb">

                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">
                        Home
                    </a>
                </li>

                <li class="breadcrumb-item active">
                    Rôles
                </li>

            </ol>
        </nav>

    </div>


    {{-- =========================================================
        BOUTON NOUVEAU RÔLE
    ========================================================== --}}
    <div class="d-flex justify-content-end mb-3">
        <div class="input-group me-3 index-search" style="max-width: 360px;">
            <span class="input-group-text bg-primary text-white"><i class="bi bi-search"></i></span>
            <input type="search" class="form-control border-primary" wire:model.live="search" placeholder="Rechercher un rôle...">
        </div>

        @canany(['create_roles'])

            <flux:button
                href="{{ route('roles.create') }}"
                icon="user-plus">

                Nouveau rôle

            </flux:button>

        @endcanany

    </div>


    {{-- =========================================================
        TABLEAU DES RÔLES
    ========================================================== --}}
    <div class="col-12">

        <div class="card recent-sales overflow-auto">

            <div class="card-body">

                <h5 class="card-title">
                    Liste des rôles
                    <span>| Aujourd'hui</span>
                </h5>


                <table class="table table-borderless datatable">

                    <thead>

                        <tr>

                            <th scope="col">
                                ID
                            </th>

                            <th scope="col">
                                Nom
                            </th>

                            <th scope="col">
                                Rôle
                            </th>

                            <th scope="col">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($roles as $role)

                            <tr>

                                {{-- ID --}}
                                <th scope="row">

                                    <a href="#">
                                        {{ $role->id }}
                                    </a>

                                </th>


                                {{-- NOM --}}
                                <td>

                                    {{ $role->name }}

                                </td>


                                {{-- RÔLE --}}
                                <td>

                                    <span class="badge bg-success">
                                        {{ $role->name }}
                                    </span>

                                </td>


                                {{-- ACTIONS --}}
                                <td>

                                    {{-- MODIFIER --}}
                                    @canany(['update_roles'])

                                        <flux:button
                                            href="{{ route('roles.edit', $role->id) }}"
                                           variant="primary" color="white" icon:trailing="pencil"></flux:button>

                                    @endcanany


                                    {{-- SUPPRIMER --}}
                                    @canany(['delete_roles'])

                                        <flux:button
                                            wire:click="deleteRole({{ $role->id }})"variant="danger" color="red" icon:trailing="trash"></flux:button>

                                    @endcanany

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="4"
                                    class="text-center">

                                    <div class="alert alert-info mb-0">

                                        <i class="bi bi-info-circle me-1"></i>

                                        Aucun rôle trouvé.

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>