  <div class="card">
            <div class="card-body">
              <h5 class="card-title">RECLAMMATION </h5>

              <!-- Floating Labels Form -->
              <form class="row g-3" wire:submit="saveContact">

                 <div class="col-md-6">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="floatingName" placeholder="Your Name" wire:model="matricule">
                    <label for="floatingName">MATRICULE</label>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="floatingName" placeholder="Your Name" wire:model="nom">
                    <label for="floatingName">NOM &  PRENOM</label>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="floatingEmail" placeholder="Your Email" wire:model="niveau">
                    <label for="floatingEmail">NIVEAU</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="floatingPassword" placeholder="Password" wire:model="sujet">
                    <label for="floatingPassword">SUJET</label>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-floating">
                    <textarea class="form-control" placeholder="Address" id="floatingTextarea" style="height: 100px;" wire:model="reclammation"></textarea>
                    <label for="floatingTextarea">RECLAMMATION</label>
                  </div>
                </div>
           
                <div>
                  <button type="submit" class="btn btn-primary">ENVOYER</button>
                  <button type="reset" class="btn btn-secondary">ANNULER</button>
                </div>
              </form><!-- End floating Labels Form -->

            </div>
          </div>