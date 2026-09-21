<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $profile = UserProfile::firstOrCreate(
            [
                'user_id' => $user->id,
            ]
        );

        return view('settings.profile', [
            'user' => $user,
            'profile' => $profile,
        ]);
    }


    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([

            'name' => 'required|string|max:255',

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')
                    ->ignore($user->id),
            ],

            'apropos' => 'nullable|string|max:1000',

            'etablissement' => 'nullable|string|max:255',

            'poste' => 'nullable|string|max:255',

            'pays' => 'nullable|string|max:255',

            'adresse' => 'nullable|string|max:255',

            'telephone' => 'nullable|string|max:50',

            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);


        /*
        |--------------------------------------------------------------------------
        | MODIFIER LES INFORMATIONS USER
        |--------------------------------------------------------------------------
        */

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);


        /*
        |--------------------------------------------------------------------------
        | RECUPERER LE PROFIL DE L'UTILISATEUR CONNECTE
        |--------------------------------------------------------------------------
        */

        $profile = UserProfile::firstOrCreate([
            'user_id' => $user->id,
        ]);


        /*
        |--------------------------------------------------------------------------
        | PHOTO
        |--------------------------------------------------------------------------
        */

        $photoPath = $profile->profile_image;

        if ($request->hasFile('profile_image')) {

            if (
                $profile->profile_image &&
                Storage::disk('public')
                    ->exists($profile->profile_image)
            ) {
                Storage::disk('public')
                    ->delete($profile->profile_image);
            }

            $photoPath = $request
                ->file('profile_image')
                ->store('profiles', 'public');
        }


        /*
        |--------------------------------------------------------------------------
        | ENREGISTRER LE PROFIL
        |--------------------------------------------------------------------------
        */

        $profile->updateOrCreate(
            [
                'user_id' => $user->id,
            ],
            [
                'apropos' => $validated['apropos'] ?? null,
                'etablissement' => $validated['etablissement'] ?? null,
                'poste' => $validated['poste'] ?? null,
                'pays' => $validated['pays'] ?? null,
                'adresse' => $validated['adresse'] ?? null,
                'telephone' => $validated['telephone'] ?? null,
                'profile_image' => $photoPath,
            ]
        );


        return redirect()
            ->route('settings.profile')
            ->with(
                'success',
                'Votre profil a été modifié avec succès.'
            );
    }
}