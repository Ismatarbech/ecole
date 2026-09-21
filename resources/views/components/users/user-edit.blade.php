<div class="w-100">

    {{-- ================= SUCCESS ================= --}}
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-1"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ================= ERROR ================= --}}
    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle me-1"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">

        <div class="card-body">

            <h5 class="card-title">
                Modifier utilisateur
            </h5>

            <form wire:submit.prevent="updateUser">

                {{-- NOM --}}
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Nom</label>
                    <div class="col-sm-10">
                        <input type="text"
                               class="form-control"
                               wire:model="name">
                    </div>
                </div>

                {{-- EMAIL --}}
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email"
                               class="form-control"
                               wire:model="email">
                    </div>
                </div>

                {{-- PASSWORD --}}
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Mot de passe</label>
                    <div class="col-sm-10">
                        <input type="password"
                               class="form-control"
                               wire:model="password">
                        <small class="text-muted">
                            Laisser vide pour ne pas changer
                        </small>
                    </div>
                </div>

                {{-- ROLES --}}
                <div class="row mb-3">

                    <label class="col-sm-2 col-form-label">
                        Rôles
                    </label>

                    <div class="col-sm-10">

                        @forelse($allRoles as $role)

                            <div class="form-check">

                                <input class="form-check-input"
                                       type="checkbox"
                                       wire:model="selectedRoles"
                                       value="{{ $role }}"
                                       id="role_{{ $loop->index }}">

                                <label class="form-check-label"
                                       for="role_{{ $loop->index }}">
                                    {{ $role }}
                                </label>

                            </div>

                        @empty
                            <div class="text-muted">
                                Aucun rôle disponible
                            </div>
                        @endforelse

                    </div>
                </div>

                {{-- BUTTON --}}
                <div class="row mt-4">
                    <div class="col-sm-10 offset-sm-2">

                        <button class="btn btn-primary"
                                type="submit"
                                wire:loading.attr="disabled">

                            <span wire:loading.remove>
                                Modifier
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