<?php

namespace App\Livewire\Inscriptions;

use Livewire\Component;
use App\Models\Eleve;
use App\livewire\Inscriptions;

use App\Models\Classe;
use App\Models\AnneeScolaire;
use App\Models\Note;


class InscriptionIndex extends Component
{
    public string $errorMessage = '';
    public string $search = '';
    public string $selectedClasseId = '';

    public function updatedSearch(): void
    {
        $this->search = trim($this->search);
    }

    public function deleteEleve($eleveId)
    {
        $eleve = Eleve::findOrFail($eleveId);
        $eleve->delete();
    }

    public function render()
    {   
        $anneScolaire = AnneeScolaire::where('status', 'active')->first();

        if (!$anneScolaire) {
            $this->errorMessage = "Aucune année scolaire active n'a été trouvée.";
            $elevesParClasse = collect();
            $classes = collect();

            return view('inscriptions.inscription-index', compact('elevesParClasse', 'classes'));
        }

        $this->errorMessage = '';
        $classes = Classe::whereHas('niveau', function ($query) use ($anneScolaire) {
            $query->where('annee_scolaire_id', $anneScolaire->id);
        })->orderBy('name')->get();

        $eleves = Eleve::with(['notes.matiere', 'classe', 'anneeScolaire'])
            ->where('annee_scolaire_id', $anneScolaire->id)
            ->when($this->selectedClasseId !== '', function ($query) {
                $query->where('classe_id', $this->selectedClasseId);
            })
            ->when($this->search !== '', function ($query) {
                $query->where(function ($query) {
                    $query->where('nom', 'like', '%' . $this->search . '%')
                        ->orWhere('prenom', 'like', '%' . $this->search . '%')
                        ->orWhere('matricule', 'like', '%' . $this->search . '%')
                        ->orWhereHas('classe', function ($query) {
                            $query->where('name', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->get();

        $elevesParClasse = $eleves
            ->sortBy(fn ($eleve) => $eleve->classe?->name ?? 'Classe non affectée')
            ->groupBy(fn ($eleve) => $eleve->classe_id ?? 'sans-classe');
        
        return view('inscriptions.inscription-index', compact('elevesParClasse', 'classes'));
    }
}