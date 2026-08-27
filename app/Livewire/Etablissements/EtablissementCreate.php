<?php

namespace App\Livewire\Etablissements;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Etablissement;

class EtablissementCreate extends Component
{
    use WithFileUploads;

    public $nom;
    public $logo;

    protected $rules = [
        'nom' => 'required|string|max:255|unique:etablissements,nom',
        'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ];

    public function enregistrer()
    {
        // Validation
        $this->validate();

        // Chemin du logo
        $logoPath = null;

        // Enregistrer le logo
        if ($this->logo) {
            $logoPath = $this->logo->store(
                'etablissements',
                'public'
            );
        }

        // Création de l'établissement
        Etablissement::create([
            'nom' => $this->nom,
            'logo' => $logoPath,
        ]);

        // Message de succès
        session()->flash(
            'message',
            "L'établissement a été créé avec succès !"
        );

        // Réinitialiser le formulaire
        $this->reset(['nom', 'logo']);

        // Redirection
        return redirect()->route('etablissement.index');
    }

    public function render()
    {
        return view('etablissements.etablissement-create');
    }
}