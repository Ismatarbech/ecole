<?php

namespace App\Livewire\Paiements;

use Livewire\Component;
use App\Models\Paiement;
use App\Models\Eleve;
use App\Models\Classe;
use App\Models\AnneeScolaire;

class PaiementIndex extends Component
{
    public string $errorMessage = '';
    public string $search = '';

    public function updatedSearch(): void
    {
        $this->search = trim($this->search);
    }

    public function render()
    {
        $anneeScolaire = AnneeScolaire::where('status', 'active')->first();

        if (!$anneeScolaire) {
            $this->errorMessage = "Aucune année scolaire active n'a été trouvée.";
            $paiement = collect();

            return view('paiements.paiement-index', compact('paiement'));
        }

        $this->errorMessage = '';
        $paiement = Paiement::with([
            'eleve.paiements',
            'eleve.classe.niveau',
            'classe.niveau',
            'anneeScolaire'
        ])->where('annee_scolaire_id', $anneeScolaire->id)
            ->when($this->search !== '', function ($query) {
                $query->where(function ($query) {
                    $query->whereHas('eleve', function ($query) {
                        $query->where('nom', 'like', '%' . $this->search . '%')
                            ->orWhere('prenom', 'like', '%' . $this->search . '%')
                            ->orWhere('matricule', 'like', '%' . $this->search . '%');
                    })->orWhereHas('classe', function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%');
                    });
                });
            })->get();

        return view('paiements.paiement-index', [
            'paiement' => $paiement,
        ]);
    }
}