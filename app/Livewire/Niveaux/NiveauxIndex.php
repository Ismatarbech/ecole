<?php

namespace App\Livewire\Niveaux;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Niveau;

class NiveauxIndex extends Component
{
    use WithPagination;

    public string $search = '';

    protected $paginationTheme = 'bootstrap';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function deleteNiveau($niveauId)
    {
        $niveau = Niveau::find($niveauId);

        if (!$niveau) {

            session()->flash(
                'error',
                "Le niveau n'existe pas."
            );

            return;
        }

        $nomNiveau = $niveau->libelle;

        $niveau->delete();

        session()->flash(
            'message',
            "Le niveau « {$nomNiveau} » a été supprimé avec succès !"
        );
    }

    public function render()
    {
        $niveaux = Niveau::with('anneeScolaire')
            ->whereHas('anneeScolaire', function ($query) {
                $query->where('status', 'active');
            })
            ->when($this->search !== '', function ($query) {
                $query->where(function ($query) {
                    $query->where('code', 'like', '%' . $this->search . '%')
                        ->orWhere('libelle', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()
            ->paginate(10);

        return view(
            'niveaux.niveau-index',
            compact('niveaux')
        );
    }
}