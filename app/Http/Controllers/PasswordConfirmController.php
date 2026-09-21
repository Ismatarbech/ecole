<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordConfirmController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | PAGE DE CONFIRMATION
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        return view('settings.confirm-password');
    }


    /*
    |--------------------------------------------------------------------------
    | VERIFIER LE MOT DE PASSE
    |--------------------------------------------------------------------------
    */

    public function verify(Request $request)
    {
        $request->validate([
            'password' => [
                'required',
                'current_password',
            ],
        ], [
            'password.required' => 'Veuillez entrer votre mot de passe.',
            'password.current_password' => 'Le mot de passe est incorrect.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | AUTORISER L'ACCES TEMPORAIREMENT
        |--------------------------------------------------------------------------
        */

        session([
            'password_confirmed' => true,
        ]);

        return redirect()
            ->route('settings.security');
    }


    /*
    |--------------------------------------------------------------------------
    | PAGE SECURITY
    |--------------------------------------------------------------------------
    */

    public function security()
    {
        /*
        |--------------------------------------------------------------------------
        | VERIFIER SI LE MOT DE PASSE A ETE CONFIRME
        |--------------------------------------------------------------------------
        */

        if (!session('password_confirmed')) {

            return redirect()
                ->route('password.check');
        }

        return view('settings.security');
    }


    /*
    |--------------------------------------------------------------------------
    | CHANGER LE MOT DE PASSE
    |--------------------------------------------------------------------------
    */

    public function updatePassword(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VERIFICATION DE L'ACCES
        |--------------------------------------------------------------------------
        */

        if (!session('password_confirmed')) {

            return redirect()
                ->route('password.check');
        }

        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'password' => [
                'required',
                'confirmed',
                'min:8',
            ],
        ], [
            'password.required' => 'Le nouveau mot de passe est obligatoire.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | MODIFIER LE MOT DE PASSE
        |--------------------------------------------------------------------------
        */

        $user = Auth::user();

        $user->update([
            'password' => Hash::make(
                $request->password
            ),
        ]);

        /*
        |--------------------------------------------------------------------------
        | SUPPRIMER L'AUTORISATION
        |--------------------------------------------------------------------------
        */

        session()->forget(
            'password_confirmed'
        );

        return redirect()
            ->route('settings.security')
            ->with(
                'success',
                'Votre mot de passe a été modifié avec succès.'
            );
    }
}