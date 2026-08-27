<?php 

namespace App\Livewire\AnneeScolaires;

use Livewire\Component;
use App\Models\AnneeScolaire;
use Carbon\Carbon;


class AnneeScolaireCreate extends Component
{
    public $annee;

    public function save(AnneeScolaire $AnneeScolaire)
    {
        $this->validate([
            'annee' => 'required|string|unique:annee_scolaires,scolaire_annee|max:255',
        ]);

        $current_annee = Carbon::now()->format('Y');
        $AnneeScolaire->scolaire_annee = $this->annee;
        $AnneeScolaire->current_annee = $current_annee;

        $AnneeScolaire->save();

        return redirect()->route('anneescolaire.index')->with('success', 'Année scolaire créée avec succès.');
    }

    public function render()
    {
        return view('anneescolaires.anneescolaire-create');
    }
}