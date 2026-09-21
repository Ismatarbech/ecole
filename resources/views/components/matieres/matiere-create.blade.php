<div class="w-2/2">
  @if (session()->has('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
  @endif
        <div class="card">
            <div class="card-body">
              <h5 class="card-title">Ajouter une eleve</h5>

              <!-- General Form Elements -->
              <form wire:submit="save">

                <div class="row mb-3">
                  <label for="inputEmail" class="col-sm-2 col-form-label">Nom de la matière</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control @error('nom') is-invalid @enderror" wire:model="nom">
                    @error('nom')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>


                 <div class="row mb-3">
                  <label for="inputEmail" class="col-sm-2 col-form-label">Coefficient </label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control" wire:model="coefficient">
                  </div>
                </div>

                 <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label"></label>
                  <div class="col-sm-10">
             
                <flux:select wire:model="niveau_id" class="@error('niveau_id') is-invalid @enderror">
                <option value="">Sélectionner un niveau</option>
                    @foreach($niveau as $item)
                        <option value="{{ $item->id }}">{{ $item->libelle }}</option>
                    @endforeach
                </flux:select>
                @error('niveau_id')
                  <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
                 </div>
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