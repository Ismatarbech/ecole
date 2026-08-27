<div class="w-2/2">
    @if (session()->has('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session()->has('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
        <div class="card">
            <div class="card-body">
              <h5 class="card-title">Modifier l'utilisateur</h5>

              <!-- General Form Elements -->
              <form wire:submit="updateUser">
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Nom</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" wire:model='name'>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                  <div class="col-sm-10">
                    <input type="email" class="form-control" wire:model="email">
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputPassword" class="col-sm-2 col-form-label" >Mot de passe</label>
                  <div class="col-sm-10">
                    <input type="password" class="form-control" wire:model="password">
                  </div>
                </div>

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
                    <button type="submit" class="btn btn-primary">Modifier</button>
                  </div>
                </div>

              </form><!-- End General Form Elements -->

            </div>
          </div>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>