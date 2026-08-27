<?php 

namespace App\Livewire\AnneeScolaires;

use Livewire\Component;
use App\Models\AnneeScolaire;
use Illuminate\Validation\Rule;


class AnneeScolaireEdit extends Component
{
    public AnneeScolaire $anneescolaire;
    public string $annee = '';

    public function mount(AnneeScolaire $anneescolaire)
    {
        $this->anneescolaire = $anneescolaire;
        $this->annee = $anneescolaire->scolaire_annee;
    }

    public function updateAnnee()
    {
        $this->validate([
            'annee' => [
                'required',
                'string',
                'max:255',
                Rule::unique('annee_scolaires', 'scolaire_annee')
                    ->ignore($this->anneescolaire->id),
            ],
        ]);

        $this->anneescolaire->update([
            'scolaire_annee' => $this->annee,
        ]);

        return redirect()
            ->route('anneescolaire.index')
            ->with('success', 'Année scolaire modifiée avec succès.');
    }

    public function render()
    {
        return view('anneescolaires.anneescolaire-edit');
    }
}