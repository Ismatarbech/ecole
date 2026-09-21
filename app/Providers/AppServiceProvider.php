<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Gate;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();

        VerifyEmail::toMailUsing(function (object $notifiable, string $url): MailMessage {
            return (new MailMessage)
                ->subject('Confirmez votre adresse email - School')
                ->greeting('Bienvenue sur School')
                ->line('Merci de vous être inscrit sur la plateforme School.')
                ->line('Cliquez sur le bouton ci-dessous pour confirmer votre adresse email.')
                ->action('Confirmer mon adresse email', $url)
                ->line('Ce lien est valable pendant la durée prévue par Laravel.');
        });

        ResetPassword::toMailUsing(function (object $notifiable, string $token): MailMessage {
            $url = url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));

            return (new MailMessage)
                ->subject('Réinitialisation de votre mot de passe - School')
                ->greeting('Bonjour,')
                ->line('Vous recevez cet email car une demande de réinitialisation du mot de passe a été effectuée pour votre compte School.')
                ->action('Réinitialiser mon mot de passe', $url)
                ->line('Ce lien expirera prochainement. Si vous n’êtes pas à l’origine de cette demande, aucune action n’est nécessaire.');
        });

     Gate::before(function ($user, $ability) {
        return $user->hasRole('super_admin') ? true : null;
    });
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }
}
