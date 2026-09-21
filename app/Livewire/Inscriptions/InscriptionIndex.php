<?php

namespace App\Livewire\Inscriptions;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Eleve;
use App\livewire\Inscriptions;

use App\Models\Classe;
use App\Models\AnneeScolaire;
use App\Models\Note;
use App\Exports\ElevesExport;
use Maatwebsite\Excel\Facades\Excel;


class InscriptionIndex extends Component
{
    use WithPagination;
    public string $errorMessage = '';
    public string $search = '';
    public string $selectedClasseId = '';

    public function updatedSearch(): void
    {
        $this->search = trim($this->search);
        $this->resetPage();
    }

    public function updatedSelectedClasseId(): void
    {
        $this->resetPage();
    }

    public function exporterClasse()
    {
        if ($this->selectedClasseId === '') {
            $this->errorMessage = 'Sélectionnez une classe avant de télécharger la liste.';
            return null;
        }

        $classe = Classe::findOrFail($this->selectedClasseId);

        return Excel::download(
            new ElevesExport($this->selectedClasseId),
            'eleves-' . str($classe->name)->slug() . '.xlsx'
        );
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
            $eleves = Eleve::whereIn('id', [])->paginate(10);
            $classes = collect();

            return view('inscriptions.inscription-index', compact('eleves', 'classes'));
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
            ->orderBy('nom')
            ->orderBy('prenom')
            ->paginate(10);
        
        return view('inscriptions.inscription-index', compact('eleves', 'classes'));
    }
}