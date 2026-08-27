<?php

namespace App\Livewire\Classes;

use Livewire\Component;
use App\Models\Niveau;
use App\Models\AnneeScolaire;
use App\Models\Classe;

class ClasseCreate extends Component
{
    public $niveau_id;
    public $name;

    public function saveClasse(Classe $classe)
    {
        try {

            $this->validate([
                'niveau_id' => 'string|required|max:255',
                'name' => 'required|string|max:255|unique:classes,name',
            ]);

            $classe->name = $this->name;
            $classe->niveau_id = $this->niveau_id;

            $classe->save();

            session()->flash(
                'success',
                'Classe créée avec succès.'
            );

            return redirect()->route('classe.index');

        } catch (\Exception $e) {

            session()->flash(
                'error',
                "La classe n'a pas été créée. Cette classe existe déjà."
            );

            return back();
        }
    }

    public function render()
    {
        $anneeScolaire = AnneeScolaire::where('status', 'active')->first();

        $anneecurrent = Niveau::where(
            'annee_scolaire_id',
            $anneeScolaire->id
        )->get();

        return view(
            'classes.classe-create',
            compact('anneecurrent')
        );
    }
}