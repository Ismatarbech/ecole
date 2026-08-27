<?php

namespace App\Livewire\Etablissements;

use Livewire\Component;
use App\Models\Etablissement;

class EtablissementIndex extends Component
{
    public string $search = '';

    public function updatedSearch(): void
    {
        $this->search = trim($this->search);
    }

    public function deleteEtablissement($etablissementId)
    {
        $etablissement = Etablissement::find($etablissementId);

        if ($etablissement) {

            // Supprimer l'établissement
            $etablissement->delete();

            // Message de succès
            session()->flash(
                'message',
                "L'établissement a été supprimé avec succès !"
            );

        } else {

            // Message d'erreur
            session()->flash(
                'error',
                "L'établissement n'a pas été supprimé."
            );
        }
    }

    public function render()
    {
        $etablissements = Etablissement::when($this->search !== '', function ($query) {
            $query->where('nom', 'like', '%' . $this->search . '%');
        })->get();

        return view(
            'etablissements.etablissement-index',
            compact('etablissements')
        );
    }
}