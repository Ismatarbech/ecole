<?php

namespace App\Livewire\Matieres;

use Livewire\Component;
use App\Models\Matiere;
use App\Models\Niveau;

class MatiereEdit extends Component
{
    public Matiere $matiere;

    public $nom = '';
    public $coefficient = '';
    public $niveau_id = '';

    public $niveaux = [];

    /**
     * Récupérer la matière à modifier
     */
    public function mount(Matiere $matiere)
    {
        $this->matiere = $matiere;

        // Récupérer les anciennes valeurs
        $this->nom = $matiere->nom;
        $this->coefficient = $matiere->coefficient;
        $this->niveau_id = $matiere->niveau_id;

        // Récupérer tous les niveaux
        $this->niveaux = Niveau::orderBy('code')->get();
    }

    /**
     * Modifier la matière
     */
    public function save()
    {
        $this->validate([
            'nom' => 'required|string|max:255',

            'coefficient' => 'required|integer|min:1|max:10',

            'niveau_id' => 'required|exists:niveaux,id',
        ]);

        $this->matiere->update([
            'nom' => $this->nom,
            'coefficient' => $this->coefficient,
            'niveau_id' => $this->niveau_id,
        ]);

        session()->flash(
            'success',
            'Matière modifiée avec succès.'
        );

        return redirect()->route('matiere.index');
    }

    /**
     * Annuler
     */
    public function cancel()
    {
        return redirect()->route('matiere.index');
    }

    public function render()
    {
        return view('matieres.matiere-edit');
    }
}