<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Réinitialiser le mot de passe - school</title>
    <link href="/assets/img/favicon.png" rel="icon">
    <link href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
    <style>
        .reset-feedback { border: 0; border-left: 4px solid; border-radius: 10px; box-shadow: 0 4px 14px rgba(0, 0, 0, .06); font-size: 14px; padding: 12px 14px; }
        .reset-feedback i { font-size: 18px; margin-right: 8px; vertical-align: -2px; }
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
                                        <h5 class="card-title text-center pb-0 fs-4"><strong>Nouveau mot de passe</strong></h5>
                                        <p class="text-center small">Choisissez un nouveau mot de passe pour sécuriser votre compte.</p>
                                    </div>

                                    @if ($errors->any())
                                        <div class="reset-feedback reset-feedback-error mb-3" role="alert">
                                            <i class="bi bi-exclamation-circle-fill"></i>
                                            Veuillez corriger les informations indiquées.
                                        </div>
                                    @endif

                                    <form method="POST" action="{{ route('password.update') }}" class="row g-3">
                                        @csrf
                                        <input type="hidden" name="token" value="{{ request()->route('token') }}">

                                        <div class="col-12">
                                            <label for="resetEmail" class="form-label">Adresse e-mail</label>
                                            <input type="email" name="email" value="{{ old('email', request('email')) }}" class="form-control @error('email') is-invalid @enderror" id="resetEmail" required autocomplete="email">
                                            @error('email')
                                                <div class="reset-field-error"><i class="bi bi-info-circle me-1"></i>Veuillez vérifier votre adresse e-mail.</div>
                                            @enderror
                                        </div>

                                        <div class="col-12">
                                            <label for="newPassword" class="form-label">Nouveau mot de passe</label>
                                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="newPassword" required autocomplete="new-password">
                                            @error('password')
                                                <div class="reset-field-error"><i class="bi bi-info-circle me-1"></i>Le mot de passe doit respecter les conditions requises.</div>
                                            @enderror
                                        </div>

                                        <div class="col-12">
                                            <label for="passwordConfirmation" class="form-label">Confirmer le mot de passe</label>
                                            <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" id="passwordConfirmation" required autocomplete="new-password">
                                            @error('password_confirmation')
                                                <div class="reset-field-error"><i class="bi bi-info-circle me-1"></i>Les deux mots de passe doivent être identiques.</div>
                                            @enderror
                                        </div>

                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit">
                                                <i class="bi bi-shield-check me-1"></i> Enregistrer le nouveau mot de passe
                                            </button>
                                        </div>

                                        <div class="col-12 text-center">
                                            <p class="small mb-0"><a href="{{ route('login') }}"><strong>Retour à la connexion</strong></a></p>
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
