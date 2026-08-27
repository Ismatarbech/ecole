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
                    <input type="text" class="form-control" wire:model="nom">
                  </div>
                </div>

                 <div class="row mb-3">
                  <label for="inputEmail" class="col-sm-2 col-form-label">description </label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" wire:model="description">
                  </div>
                </div>

                 <div class="row mb-3">
                  <label for="inputEmail" class="col-sm-2 col-form-label">Coefficient </label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control" wire:model="coefficient">
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