<div>
  @if (session()->has('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif
<div class="w-2/2">
        <div class="card">
            <div class="card-body">
              <h5 class="card-title">Ajouter une salle de classe</h5>

              <!-- General Form Elements -->
              <form wire:submit="save">

                <div class="row mb-3">
                  <label for="classe_id" class="col-sm-2 col-form-label">Classe</label>
                  <div class="col-sm-10">
                    <flux:select id="classe_id" wire:model.live="classe_id">
                      <option value="">Sélectionner une classe</option>
                      @foreach($classes as $classe)
                        <option value="{{ $classe->id }}">{{ $classe->name }}</option>
                      @endforeach
                    </flux:select>
                    @error('classe_id') <div class="text-danger small">{{ $message }}</div> @enderror
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label"></label>
                  <div class="col-sm-10">
                  <flux:select wire:model="eleve_id" :disabled="!$classe_id">
                   <option value="">Sélectionner matricule d'eleve</option>
                    @foreach($eleves as $eleve)
                        <option value="{{ $eleve->id }}">{{ $eleve->matricule }}</option>
                    @endforeach
                 </flux:select>
                 </div>
                </div>
       

               <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label"></label>
                  <div class="col-sm-10">
             
                <flux:select wire:model="matiere_id" :disabled="!$classe_id">
                <option value="">Sélectionner un matiere</option>
                    @foreach($matieres as $matiere)
                        <option value="{{ $matiere->id }}">{{ $matiere->description }}</option>
                    @endforeach
                </flux:select>
                 </div>
                </div>

                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Dévoir / 20</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control"  wire:model="devoir">
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Composition / 20</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control"  wire:model="composition">
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