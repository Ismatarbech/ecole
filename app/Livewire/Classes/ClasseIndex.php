<?php

namespace App\Livewire\Classes;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Classe;
use App\Models\AnneeScolaire;

class ClasseIndex extends Component
{
    use WithPagination;

    public string $successMessage = '';
    public string $errorMessage = '';
    public string $search = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function deleteClasse($classeId)
    {
        // Vider les anciens messages
        $this->successMessage = '';
        $this->errorMessage = '';

        try {

            $classe = Classe::findOrFail($classeId);

            $classe->delete();

            // Message de succès
            $this->successMessage = 'Classe supprimée avec succès.';

        } catch (\Exception $e) {

            // Message d'erreur
            $this->errorMessage = "La classe n'a pas pu être supprimée.";
        }
    }

    public function render()
    {
        $anneScolaire = AnneeScolaire::where(
            'status',
            'active'
        )->first();

        if (!$anneScolaire) {
            $this->errorMessage = "Aucune année scolaire active n'a été trouvée.";

            $classe = Classe::whereIn('id', [])->paginate(10);

            return view(
                'classes.classe-index',
                compact('classe')
            );
        }

        $classe = Classe::with('niveau')
            ->whereRelation(
                'niveau',
                'annee_scolaire_id',
                $anneScolaire->id
            )
            ->when($this->search !== '', function ($query) {
                $query->where(function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhereHas('niveau', function ($query) {
                            $query->where('libelle', 'like', '%' . $this->search . '%')
                                ->orWhere('code', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->paginate(10);

        return view(
            'classes.classe-index',
            compact('classe')
        );
    }
}