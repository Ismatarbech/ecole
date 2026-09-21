<?php

namespace App\Livewire\Matieres;

use Livewire\Component;
use App\Models\Matiere;
use App\Models\Niveau;
use Illuminate\Validation\Rule;

class MatiereCreate extends Component
{
    public $nom;
    public $coefficient;
    public $niveau_id;

    public function save()
    {
        $this->validate([
            'nom' => [
                'required',
                'string',
                'max:255',
                Rule::unique('matieres', 'nom')->where(function ($query) {
                    return $query->where('niveau_id', $this->niveau_id);
                }),
            ],
       
            'coefficient' =>'required|integer|max:10',
            'niveau_id' => 'required|exists:niveaux,id',
        ], [
            'nom.unique' => 'Cette matière existe déjà pour le niveau sélectionné.',
        ]);

        try {
            Matiere::create([
                'nom' => $this->nom,
                'coefficient' => $this->coefficient,
                'niveau_id' => $this->niveau_id,
            ]);
        } catch (\Throwable $exception) {
            session()->flash('error', "La matière n'a pas pu être créée.");
            return;
        }

        return redirect('matieres')->with('success', 'Matière créée avec succès.');
    }

        

    public function render()
    {
        return view('matieres.matiere-create',['niveau' => Niveau::all(),]);
    }
}