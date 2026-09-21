<div>
  @if (session()->has('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if (session()->has('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif
<div class="w-2/2">
        <div class="card">
            <div class="card-body">
              <h5 class="card-title">Modifier une salle de classe</h5>

              <!-- General Form Elements -->
              <form wire:submit="updateClasse">

                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Nom</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control"  wire:model="name">
                  </div>
                </div>

                  <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label"></label>
                  <div class="col-sm-10">
             
                <flux:select wire:model="niveau_id">
                <option value="">Sélectionner un niveau</option>
                    @foreach($anneecurrent as $annee)
                        <option value="{{ $annee->id }}">{{ $annee->libelle }}</option>
                    @endforeach
                </flux:select>
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
