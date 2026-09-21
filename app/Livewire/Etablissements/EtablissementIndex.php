<?php

namespace App\Livewire\Etablissements;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Etablissement;

class EtablissementIndex extends Component
{
    use WithPagination;
    public string $search = '';

    public function updatedSearch(): void
    {
        $this->search = trim($this->search);
        $this->resetPage();
    }

    public function deleteEtablissement($etablissementId)
    {
        $etablissement = Etablissement::find($etablissementId);

        if ($etablissement) {

            $etablissement->delete(); // 👉 va en corbeille (soft delete)

            session()->flash(
                'message',
                "L'établissement a été envoyé dans la corbeille !"
            );

        } else {

            session()->flash(
                'error',
                "Établissement introuvable."
            );
        }
    }

    public function render()
    {
        $etablissements = Etablissement::when($this->search !== '', function ($query) {
            $query->where('nom', 'like', '%' . $this->search . '%');
        })->paginate(10);

        return view(
            'etablissements.etablissement-index',
            compact('etablissements')
        );
    }
}