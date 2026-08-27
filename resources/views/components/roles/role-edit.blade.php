<div>

    {{-- =====================================================
        TITRE
    ====================================================== --}}

    <div class="pagetitle">

        <h1>Modifier le rôle</h1>

        <nav>

            <ol class="breadcrumb">

                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">
                        Accueil
                    </a>
                </li>

                <li class="breadcrumb-item">

                    <a href="{{ route('roles.index') }}">
                        Rôles
                    </a>

                </li>

                <li class="breadcrumb-item active">
                    Modifier
                </li>

            </ol>

        </nav>

    </div>


    {{-- =====================================================
        FORMULAIRE
    ====================================================== --}}

    <div class="card">

        <div class="card-body">

            <h5 class="card-title">
                Modifier le rôle
            </h5>


            <form wire:submit="updateRole">


                {{-- =================================================
                    NOM DU RÔLE
                ================================================== --}}

                <div class="row mb-3">

                    <label
                        for="name"
                        class="col-sm-2 col-form-label">

                        Nom du rôle

                    </label>

                    <div class="col-sm-10">

                        <input
                            type="text"
                            id="name"
                            class="form-control"
                            wire:model="name"
                        >

                        @error('name')

                            <div class="text-danger mt-1">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                </div>


                {{-- =================================================
                    PERMISSIONS
                ================================================== --}}

                <div class="row mb-3">

                    <label class="col-sm-2 col-form-label">

                        Permissions

                    </label>

                    <div class="col-sm-10">

                        @forelse ($allPermissions as $permission)

                            <div class="form-check mb-2">

                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    wire:model="selectedPermissions"
                                    value="{{ $permission }}"
                                    id="permission_{{ $loop->index }}"
                                >

                                <label
                                    class="form-check-label"
                                    for="permission_{{ $loop->index }}"
                                >

                                    {{ $permission }}

                                </label>

                            </div>

                        @empty

                            <div class="alert alert-warning">

                                <i class="bi bi-exclamation-triangle me-1"></i>

                                Aucune permission disponible.

                            </div>

                        @endforelse


                        @error('selectedPermissions')

                            <div class="text-danger mt-1">

                                {{ $message }}

                            </div>

                        @enderror


                        @error('selectedPermissions.*')

                            <div class="text-danger mt-1">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                </div>


                {{-- =================================================
                    BOUTONS
                ================================================== --}}

                <div class="row mb-3">

                    <label class="col-sm-2 col-form-label">
                    </label>

                    <div class="col-sm-10">

                        <button
                            type="submit"
                            class="btn btn-primary"
                            wire:loading.attr="disabled"
                            wire:target="updateRole"
                        >

                            {{-- Normal --}}
                            <span
                                wire:loading.remove
                                wire:target="updateRole"
                            >

                                <i class="bi bi-save"></i>

                                Enregistrer

                            </span>


                            {{-- Chargement --}}
                            <span
                                wire:loading
                                wire:target="updateRole"
                            >

                                <span
                                    class="spinner-border spinner-border-sm me-1">
                                </span>

                                Modification...

                            </span>

                        </button>


                        <a
                            href="{{ route('roles.index') }}"
                            class="btn btn-secondary"
                        >

                            Annuler

                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>

</div>