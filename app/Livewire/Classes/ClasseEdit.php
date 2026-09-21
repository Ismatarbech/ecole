<?php

namespace App\Livewire\Classes;

use Livewire\Component;
use App\Models\Niveau;
use App\Models\AnneeScolaire;
use App\Models\Classe;

class ClasseEdit extends Component
{
    public $classe;
    public $niveau_id;
    public $name;
    public $annee;

    public function mount($classe)
    {
        $this->classe = Classe::findOrFail($classe);

        $this->name = $this->classe->name;
        $this->niveau_id = $this->classe->niveau_id;

        // liste des niveaux
        $this->annee = Niveau::all();
    }

    public function updateClasse()
    {
        $this->validate([
            'niveau_id' => 'required|exists:niveaux,id',
            'name' => 'required|string|max:255',
        ]);

        $this->classe->update([
            'name' => $this->name,
            'niveau_id' => $this->niveau_id,
        ]);

        return redirect()->route('classe.index')
            ->with('success', 'Classe modifiée avec succès.');
    }

    public function render()
    {
        $anneeScolaire = AnneeScolaire::where('status', 'active')->first();

        $anneecurrent = Niveau::where('annee_scolaire_id', $anneeScolaire->id)->get();

        return view('classes.classe-edit', compact('anneecurrent'));
    }
}