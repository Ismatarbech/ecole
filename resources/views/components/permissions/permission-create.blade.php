<div class="w-100">

    {{-- MESSAGES --}}
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">

            <h5 class="card-title mb-4">
                Ajouter une permission (Super Admin uniquement)
            </h5>

            <form wire:submit.prevent="createPermission">

                {{-- NOM PERMISSION --}}
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">
                        Nom de permission
                    </label>

                    <div class="col-sm-9">
                        <input type="text"
                               class="form-control"
                               wire:model="name"
                               placeholder="Ex: create_users">

                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- ROLES --}}
                <div class="row mb-3">

                    <label class="col-sm-3 col-form-label">
                        Rôle autorisé
                    </label>

                    <div class="col-sm-9">

                        @foreach ($allRoles as $role)

                            <div class="form-check mb-2">

                                <input class="form-check-input"
                                       type="checkbox"
                                       wire:model="selectedRoles"
                                       value="{{ $role }}"
                                       id="role_{{ $loop->index }}"
                                       @if($role === 'super-admin') checked disabled @endif
                                >

                                <label class="form-check-label"
                                       for="role_{{ $loop->index }}">
                                    {{ $role }}
                                </label>

                            </div>

                        @endforeach

                        @error('selectedRoles')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                    </div>
                </div>

                {{-- BUTTON --}}
                <div class="row mt-4">
                    <div class="col-sm-9 offset-sm-3">
                        <button class="btn btn-primary">
                            Enregistrer
                        </button>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>