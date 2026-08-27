<div class="w-2/2">

    {{-- Message de succès --}}
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Succès !</strong>
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close">
            </button>
        </div>
    @endif

    {{-- Message d'erreur --}}
    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Erreur !</strong>
            {{ session('error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close">
            </button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">

            <h5 class="card-title">Créer un utilisateur</h5>

            <form wire:submit="CreateUser">

                {{-- Nom --}}
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">
                        Nom
                    </label>

                    <div class="col-sm-10">
                        <input
                            type="text"
                            class="form-control @error('name') is-invalid @enderror"
                            wire:model="name"
                        >

                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                {{-- Email --}}
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">
                        Email
                    </label>

                    <div class="col-sm-10">
                        <input
                            type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            wire:model="email"
                        >

                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                {{-- Mot de passe --}}
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">
                        Mot de passe
                    </label>

                    <div class="col-sm-10">
                        <input
                            type="password"
                            class="form-control @error('password') is-invalid @enderror"
                            wire:model="password"
                        >

                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                {{-- Rôles --}}
                <div class="row mb-3">

                    <legend class="col-form-label col-sm-2 pt-0">
                        Sélectionner le rôle
                    </legend>

                    <div class="col-sm-10">

                        @foreach ($allRoles as $role)

                            <div class="form-check mb-2">

                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    wire:model="selectedRoles"
                                    value="{{ $role }}"
                                    id="role_{{ $loop->index }}"
                                >

                                <label
                                    class="form-check-label"
                                    for="role_{{ $loop->index }}"
                                >
                                    {{ $role }}
                                </label>

                            </div>

                        @endforeach

                    </div>
                </div>

                {{-- Bouton --}}
                <div class="row mb-3">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-10">

                        <button
                            type="submit"
                            class="btn btn-primary"
                            wire:loading.attr="disabled"
                        >
                            <span wire:loading.remove>
                                Enregistrer
                            </span>

                            <span wire:loading>
                                Enregistrement...
                            </span>
                        </button>

                    </div>

                </div>

            </form>

        </div>
    </div>

</div>