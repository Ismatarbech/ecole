<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Mot de passe oublié - school</title>
    <link href="/assets/img/favicon.png" rel="icon">
    <link href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
    <style>
        .reset-feedback { border: 0; border-left: 4px solid; border-radius: 10px; box-shadow: 0 4px 14px rgba(0, 0, 0, .06); font-size: 14px; padding: 12px 14px; }
        .reset-feedback i { font-size: 18px; margin-right: 8px; vertical-align: -2px; }
        .reset-feedback-success { background: #eaf8f0; border-color: #2eca6a; color: #187a3d; }
        .reset-feedback-error { background: #fff0f0; border-color: #e74c3c; color: #a5281d; }
        .reset-field-error { color: #c0392b; font-size: 13px; margin-top: 6px; }
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
                                <a href="{{ route('login') }}" class="logo d-flex align-items-center w-auto">
                                    <img src="/assets/img/logo.png" alt="Logo school">
                                    <span class="d-none d-lg-block">chool</span>
                                </a>
                            </div>

                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4"><strong>Mot de passe oublié ?</strong></h5>
                                        <p class="text-center small">Saisissez votre adresse e-mail pour recevoir un lien de réinitialisation.</p>
                                    </div>

                                    @if (session('status'))
                                        <div class="reset-feedback reset-feedback-success mb-3" role="status">
                                            <i class="bi bi-check-circle-fill"></i>
                                            Un lien de réinitialisation a été envoyé à votre adresse e-mail.
                                        </div>
                                    @endif

                                    @if ($errors->any())
                                        <div class="reset-feedback reset-feedback-error mb-3" role="alert">
                                            <i class="bi bi-exclamation-circle-fill"></i>
                                            @if ($errors->has('email'))
                                                Aucun compte ne correspond à cette adresse e-mail. Vérifiez l’adresse saisie.
                                            @else
                                                Veuillez vérifier les informations saisies.
                                            @endif
                                        </div>
                                    @endif

                                    <form method="POST" action="{{ route('password.email') }}" class="row g-3">
                                        @csrf
                                        <div class="col-12">
                                            <label for="resetEmail" class="form-label">Adresse e-mail</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                                <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" id="resetEmail" placeholder="exemple@email.com" required autofocus>
                                            </div>
                                            @error('email')
                                                <div class="reset-field-error"><i class="bi bi-info-circle me-1"></i>Utilisez l’adresse e-mail enregistrée sur votre compte.</div>
                                            @enderror
                                        </div>

                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit">
                                                <i class="bi bi-send me-1"></i> Envoyer le lien
                                            </button>
                                        </div>

                                        <div class="col-12 text-center">
                                            <p class="small mb-0">Vous vous souvenez de votre mot de passe ? <a href="{{ route('login') }}"><strong>Se connecter</strong></a></p>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
</body>

</html>
