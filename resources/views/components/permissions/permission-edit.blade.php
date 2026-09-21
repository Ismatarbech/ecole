<div class="w-100">

    {{-- SUCCESS --}}
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- ERROR --}}
    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card shadow-sm">

        <div class="card-body">

            <h5 class="card-title">
                Modifier permission
            </h5>

            <form wire:submit.prevent="updatePermission">

                {{-- NOM --}}
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">
                        Nom permission
                    </label>

                    <div class="col-sm-10">
                        <input type="text"
                               class="form-control"
                               wire:model="name">
                    </div>
                </div>

                {{-- ROLES --}}
                <div class="row mb-3">

                    <label class="col-sm-2 col-form-label">
                        Rôles
                    </label>

                    <div class="col-sm-10">

                        @foreach ($allRoles as $role)

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

                        @endforeach

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