<?php

namespace App\Livewire\Etablissements;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Etablissement;
use Illuminate\Support\Facades\Storage;

class EtablissementEdit extends Component
{
    use WithFileUploads;

    public Etablissement $etablissement;

    public $nom = '';
    public $logo;
    public $ancienLogo;

    protected $rules = [
        'nom' => 'required|string|max:255',
        'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ];

    public function mount(Etablissement $etablissement)
    {
        $this->etablissement = $etablissement;

        $this->nom = $etablissement->nom;

        $this->ancienLogo = $etablissement->logo;
    }

    public function mettreAJour()
    {
        $this->validate();

        // Garder l'ancien logo par défaut
        $logoPath = $this->ancienLogo;

        /*
        |--------------------------------------------------------------------------
        | NOUVEAU LOGO
        |--------------------------------------------------------------------------
        */

        if ($this->logo) {

            // Supprimer l'ancien logo
            if (
                $this->ancienLogo &&
                Storage::disk('public')->exists($this->ancienLogo)
            ) {
                Storage::disk('public')->delete($this->ancienLogo);
            }

            // Enregistrer le nouveau logo
            $logoPath = $this->logo->store(
                'etablissements',
                'public'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | METTRE À JOUR L'ÉTABLISSEMENT
        |--------------------------------------------------------------------------
        */

        $this->etablissement->update([
            'nom' => $this->nom,
            'logo' => $logoPath,
        ]);

        /*
        |--------------------------------------------------------------------------
        | METTRE À JOUR LES VARIABLES
        |--------------------------------------------------------------------------
        */

        $this->ancienLogo = $logoPath;

        $this->reset('logo');

        /*
        |--------------------------------------------------------------------------
        | MESSAGE DE SUCCÈS
        |--------------------------------------------------------------------------
        */

        session()->flash(
            'message',
            "L'établissement a été modifié avec succès !"
        );

        /*
        |--------------------------------------------------------------------------
        | REDIRECTION
        |--------------------------------------------------------------------------
        */

        return redirect()->route('etablissement.index');
    }

    public function render()
    {
        return view('etablissements.etablissement-edit');
    }
}