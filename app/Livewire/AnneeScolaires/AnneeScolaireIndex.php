<?php

namespace App\Livewire\AnneeScolaires;

use Livewire\Component;
use App\Models\AnneeScolaire;
use App\Models\Niveau;

class AnneeScolaireIndex extends Component
{
    public string $search = '';

    public function updatedSearch(): void
    {
        $this->search = trim($this->search);
    }

    public function toggleStatus($id)
    {
        $annee = AnneeScolaire::findOrFail($id);

        if ($annee->status === 'inactive') {

            // Désactiver toutes les autres années
            AnneeScolaire::where('id', '!=', $annee->id)
                ->update(['status' => 'inactive']);

            // Activer l'année sélectionnée
            $annee->update([
                'status' => 'active'
            ]);

            session()->flash('success', 'L’année scolaire a été activée avec succès.');

        } else {

            // Désactiver l'année actuelle
            $annee->update([
                'status' => 'inactive'
            ]);

            session()->flash('success', 'L’année scolaire a été désactivée avec succès.');
        }
    }

    public function deleteAnneescolaire($id)
    {
        $annee = AnneeScolaire::find($id);

        if (!$annee) {
            session()->flash(
                'error',
                "Cette année scolaire n'existe pas."
            );

            return;
        }

        if (Niveau::where('annee_scolaire_id', $annee->id)->exists()) {
            session()->flash(
                'error',
                "Cette année scolaire ne peut pas être supprimée car elle contient des niveaux."
            );

            return;
        }

        try {
            $annee->delete();
        } catch (\Throwable $exception) {
            session()->flash(
                'error',
                "Cette année scolaire ne peut pas être supprimée car elle est utilisée par des données existantes."
            );

            return;
        }

        session()->flash('success', 'Année scolaire supprimée avec succès.');
    }

    public function render()
    {
        $anneescolaires = AnneeScolaire::when($this->search !== '', function ($query) {
            $query->where('scolaire_annee', 'like', '%' . $this->search . '%')
                ->orWhere('status', 'like', '%' . $this->search . '%');
        })->orderBy('id', 'desc')->get();

        return view('anneescolaires.anneescolaire-index', compact('anneescolaires'));
    }
}
