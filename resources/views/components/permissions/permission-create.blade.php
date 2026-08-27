<div class="w-2/2">
    @if (session()->has('success') || session()->has('message'))
      <div class="alert alert-success">{{ session('success') ?? session('message') }}</div>
    @endif
    @if (session()->has('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
        <div class="card">
            <div class="card-body">
              <h5 class="card-title">Ajouter de permission</h5>

              <!-- General Form Elements -->
              <form wire:submit="createPermission">

                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Nom de permission</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" wire:model='name' wire:model="name">
                  </div>
                </div>
                 @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

                  <div class="row mb-3">

                  <legend class="col-form-label col-sm-2 pt-0">
                      Selectionner le role
                  </legend>

                  <div class="col-sm-10">

                      {{-- Rôles --}}
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


                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label"></label>
                  <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                  </div>
                </div>

              </form><!-- End General Form Elements -->

            </div>
          </div>