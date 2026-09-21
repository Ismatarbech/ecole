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
  <link href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="/assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="/assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="/assets/css/style.css" rel="stylesheet">
  <style>
    .login-feedback {
      border: 0;
      border-left: 4px solid;
      border-radius: 10px;
      box-shadow: 0 4px 14px rgba(0, 0, 0, .06);
      font-size: 14px;
      padding: 12px 14px;
    }

    .login-feedback i {
      font-size: 18px;
      margin-right: 8px;
      vertical-align: -2px;
    }

    .login-feedback-success {
      background: #eaf8f0;
      border-color: #2eca6a;
      color: #187a3d;
    }

    .login-feedback-error {
      background: #fff0f0;
      border-color: #e74c3c;
      color: #a5281d;
    }

    .login-field-error {
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
                  <img src="/assets/img/logo.png" alt="">
                  <span class="d-none d-lg-block">chool</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4"><strong>Connecter a votre compte</strong></h5>
                    <p class="text-center small"><strong>Entre votre mot de passe pour acceder </strong></p>
                  </div>

                 
                    <form method="POST" action="{{ route('password.confirm.store') }}" class="flex flex-col gap-6">
                        @csrf


                    @if (session('status') || session('success'))
                      <div class="col-12">
                        <div class="login-feedback login-feedback-success" role="status">
                          <i class="bi bi-check-circle-fill"></i>
                          {{ session('success') ?? session('status') }}
                        </div>
                      </div>
                    @endif

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Mot de passe</label>
                      <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="yourPassword" required>
                      <div class="invalid-feedback">Veuillez saisir votre mot de passe.</div>
                      @error('password')
                        <div class="login-field-error"><i class="bi bi-info-circle me-1"></i>Veuillez vérifier votre mot de passe.</div>
                      @enderror
                    </div>

                     <div class="col-12">
                      <p class="small mb-0">Vous avez oublié votre mot de passe ? <a href="{{ route('password.request') }}"><strong>Récupérer</strong></a></p>
                    </div>
                    <br>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Vas y</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Annuler si vous voulais pas ? <a href="/"><strong> Retour</strong></a></p>
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
  <script src="/assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="/assets/vendor/chart.js/chart.umd.js"></script>
  <script src="/assets/vendor/echarts/echarts.min.js"></script>
  <script src="/assets/vendor/quill/quill.js"></script>
  <script src="/assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="/assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="/assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="/assets/js/main.js"></script>

</body>

</html>