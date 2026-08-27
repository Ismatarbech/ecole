<div class="w-2/2">
        @if($errorMessage)
          <div class="alert alert-danger">{{ $errorMessage }}</div>
        @endif
        @if(session()->has('error'))
          <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <div class="card">
            <div class="card-body">
              <h5 class="card-title">Dernière paiement</h5>

              <!-- General Form Elements -->
              <form wire:submit="save">

                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">Classe</label>
                  <div class="col-sm-10">
                    <select class="form-select @error('classe_id') is-invalid @enderror" wire:model.live="classe_id">
                      <option value="">Sélectionner une classe</option>
                      @foreach($classes as $classe)
                        <option value="{{ $classe->id }}">{{ $classe->name }}</option>
                      @endforeach
                    </select>
                    @error('classe_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                  </div>
                </div>

                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">Matricule</label>
                  <div class="col-sm-10">
                    <select class="form-select @error('eleve_id') is-invalid @enderror" wire:model="eleve_id">
                      <option value="">Sélectionner un matricule</option>
                      @foreach($eleves as $eleve)
                        <option value="{{ $eleve->id }}">{{ $eleve->matricule }} - {{ $eleve->nom }} {{ $eleve->prenom }}</option>
                      @endforeach
                    </select>
                    @error('eleve_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                  </div>
                </div>

                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">Montant de la tranche</label>
                  <div class="col-sm-10">
                    <input type="number" min="1" class="form-control @error('montant') is-invalid @enderror" wire:model="montant">
                    @error('montant') <div class="invalid-feedback">{{ $message }}</div> @enderror
                  </div>
                </div>

                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">Mode de paiement</label>
                  <div class="col-sm-10">
                    <select class="form-select" wire:model="mode_paiement">
                      <option>Especes</option><option>Mobile Money</option><option>Virement</option><option>Cheque</option>
                    </select>
                  </div>
                </div>

                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">Date de paiement</label>
                  <div class="col-sm-10"><input type="date" class="form-control" wire:model="date_paiement"></div>
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