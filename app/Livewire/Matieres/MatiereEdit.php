<?php

namespace App\Livewire\Matieres;

use Livewire\Component;
use App\Models\Matiere;

class MatiereEdit extends Component
{
    public $nom;
    public $coefficient;
    public $description;
    public $niveau_id;

    public function save()
    {
        $this->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'coefficient' =>'required|integer|max:10',
            'niveau_id' =>'required|integer|max:10'
        ]);

        Matiere::create([
            'nom' => $this->nom,
            'description' => $this->description,
            'coefficient' =>$this->coefficient,
            'niveau_is' =>$this->niveau_is
        ]);

       return redirect('matieres')->session()->flash('success', 'Matière ajoutée avec succès');

        $this->reset(['nom', 'description','coefficient','niveau_is']);
    }

    public function render()
    {
        return view('matieres.matiere-edit');
    }
}