<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>school</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <style>
    .register-feedback {
      border: 0;
      border-left: 4px solid;
      border-radius: 10px;
      box-shadow: 0 4px 14px rgba(0, 0, 0, .06);
      font-size: 14px;
      padding: 12px 14px;
    }

    .register-feedback i {
      font-size: 18px;
      margin-right: 8px;
      vertical-align: -2px;
    }

    .register-feedback-success {
      background: #eaf8f0;
      border-color: #2eca6a;
      color: #187a3d;
    }

    .register-feedback-error {
      background: #fff0f0;
      border-color: #e74c3c;
      color: #a5281d;
    }

    .register-field-error {
      color: #c0392b;
      font-size: 13px;
      margin-top: 6px;
    }
  </style>

</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="/dashboard" class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/logo.png" alt="">
                  <span class="d-none d-lg-block">chool</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4"><strong>Créer un compte</strong></h5>
                    <p class="text-center small"><strong>Entre notre données personnelle detaillé</strong></p>
                  </div>

                  <form method="POST" action="{{ route('register.store') }}" class="row g-3 needs-validation" novalidate>
                      @csrf

                    @if (session('status') || session('success'))
                      <div class="col-12">
                        <div class="register-feedback register-feedback-success" role="status">
                          <i class="bi bi-check-circle-fill"></i>
                          {{ session('success') ?? session('status') }}
                        </div>
                      </div>
                    @endif

                    @if ($errors->any())
                      <div class="col-12">
                        <div class="register-feedback register-feedback-error" role="alert">
                          <i class="bi bi-exclamation-circle-fill"></i>
                          Veuillez corriger les informations indiquées avant de continuer.
                        </div>
                      </div>
                    @endif

                    <div class="col-12">
                      <label for="yourName" class="form-label">Notre nom</label>
                      <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" id="yourName" required>
                      <div class="invalid-feedback">Veuillez saisir votre nom.</div>
                      @error('name')
                        <div class="register-field-error"><i class="bi bi-info-circle me-1"></i>Veuillez saisir un nom valide.</div>
                      @enderror
                    </div>


                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Email</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" id="yourUsername" required>
                        <div class="invalid-feedback">Veuillez saisir une adresse e-mail valide.</div>
                      </div>
                      @error('email')
                        <div class="register-field-error"><i class="bi bi-info-circle me-1"></i>Cette adresse e-mail est obligatoire et doit être valide.</div>
                      @enderror
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Mot de passe</label>
                      <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="yourPassword" required>
                      <div class="invalid-feedback">Veuillez saisir un mot de passe.</div>
                      @error('password')
                        <div class="register-field-error"><i class="bi bi-info-circle me-1"></i>Le mot de passe doit respecter les conditions requises.</div>
                      @enderror
                    </div>

                      <div class="col-12">
                      <label for="yourPassword" class="form-label">Confirmer votre mot de passe</label>
                      <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" id="yourPasswordConfirmation" required>
                      <div class="invalid-feedback">Veuillez confirmer votre mot de passe.</div>
                      @error('password_confirmation')
                        <div class="register-field-error"><i class="bi bi-info-circle me-1"></i>Les deux mots de passe doivent être identiques.</div>
                      @enderror
                    </div>

                    <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" name="terms" type="checkbox" value="" id="acceptTerms" required>
                        <label class="form-check-label" for="acceptTerms">Je suis d’accord et j'accepte les <a href="#"><strong>termes et les conditions</strong></a></label>
                        <div class="invalid-feedback">Vous devez accepter les conditions avant de continuer.</div>
                        @error('terms')
                          <div class="register-field-error"><i class="bi bi-info-circle me-1"></i>Veuillez accepter les termes et conditions.</div>
                        @enderror
                      </div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Créer un compte</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Vous avez déjà un compte ? <a href="login"><strong>Connecte moi</strong></a></p>
                    </div>
                  </form>

                </div>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

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