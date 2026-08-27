<?php
// filepath: c:\Users\Isma Tar\Desktop\projet\ecole\app\Livewire\Matieres\MatiereIndex.php

namespace App\Livewire\Matieres;

use App\Models\Matiere;
use App\Models\Niveau;
use App\Models\AnneeScolaire;
use Livewire\Component;

class MatiereIndex extends Component
{
    public string $errorMessage = '';
    public string $successMessage = '';
    public string $search = '';

    public function updatedSearch(): void
    {
        $this->search = trim($this->search);
    }

    public function deleteMatiere($matiereId)
    {
        $this->successMessage = '';
        $this->errorMessage = '';

        try {
            $matiere = Matiere::find($matiereId);

            if (!$matiere) {
                $this->errorMessage = "La matière n'existe pas.";
                return;
            }

            $matiere->delete();
            $this->successMessage = 'Matière supprimée avec succès.';
        } catch (\Throwable $exception) {
            $this->errorMessage = "La matière n'a pas pu être supprimée.";
        }

    }
    public $niveau_id = '';

    public function render()
    {
        $anneeScolaire = AnneeScolaire::where('status', 'active')->first();

        if (!$anneeScolaire) {
            $this->errorMessage = "Aucune année scolaire active n'a été trouvée.";
            $niveaux = collect();
            $matieres = collect();

            return view('matieres.matiere-index', compact(
                'matieres',
                'niveaux'
            ));
        }

        $this->errorMessage = '';
        $niveaux = Niveau::where('annee_scolaire_id', $anneeScolaire->id)
            ->orderBy('code')
            ->get();

        $matieres = Matiere::with('niveau')
            ->whereHas('niveau', function ($query) use ($anneeScolaire) {
                $query->where('annee_scolaire_id', $anneeScolaire->id);
            })
            ->when($this->niveau_id !== '', function ($query) {
                $query->where('niveau_id', $this->niveau_id);
            })
            ->when($this->search !== '', function ($query) {
                $query->where(function ($query) {
                    $query->where('nom', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%')
                        ->orWhereHas('niveau', function ($query) {
                            $query->where('code', 'like', '%' . $this->search . '%')
                                ->orWhere('libelle', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->orderBy('nom')
            ->get();

        return view('matieres.matiere-index', compact(
            'matieres',
            'niveaux'
        ));
    }
}