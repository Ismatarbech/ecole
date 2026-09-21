<?php

namespace App\Livewire\Matieres;

use App\Models\Matiere;
use App\Models\Niveau;
use App\Models\AnneeScolaire;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class MatiereIndex extends Component
{
    use WithPagination;

    public string $errorMessage = '';
    public string $successMessage = '';
    public string $search = '';
    public string $niveau_id = '';

    public function updatedSearch(): void
    {
        $this->search = trim($this->search);
        $this->resetPage();
    }

    public function updatedNiveauId(): void
    {
        $this->resetPage();
    }

    public function deleteMatiere($matiereId): void
    {
        $this->successMessage = '';
        $this->errorMessage = '';

        try {

            $matiere = Matiere::with('niveau')->find($matiereId);

            if (!$matiere) {
                $this->errorMessage = "La matière n'existe pas.";
                return;
            }

            /*
            |--------------------------------------------------------------------------
            | SÉCURITÉ ENSEIGNANT
            |--------------------------------------------------------------------------
            */

            if (Auth::user()->hasRole('enseignant')) {

                $classeIds = Auth::user()
                    ->classes()
                    ->pluck('classes.id');

                $niveauIds = Niveau::whereIn(
                    'id',
                    function ($query) use ($classeIds) {

                        $query->select('niveau_id')
                            ->from('classes')
                            ->whereIn('id', $classeIds);

                    }
                )->pluck('id');

                if (!$niveauIds->contains($matiere->niveau_id)) {

                    $this->errorMessage =
                        "Vous n'avez pas l'autorisation de supprimer cette matière.";

                    return;
                }
            }

            $matiere->delete();

            $this->successMessage =
                'Matière supprimée avec succès.';

        } catch (\Throwable $exception) {

            $this->errorMessage =
                "La matière n'a pas pu être supprimée.";
        }
    }

    public function render()
    {
        $anneeScolaire = AnneeScolaire::where(
            'status',
            'active'
        )->first();

        /*
        |--------------------------------------------------------------------------
        | AUCUNE ANNÉE ACTIVE
        |--------------------------------------------------------------------------
        */

        if (!$anneeScolaire) {

            $this->errorMessage =
                "Aucune année scolaire active n'a été trouvée.";

            $niveaux = collect();

            $matieres = Matiere::whereIn('id', [])
                ->paginate(10);

            return view(
                'matieres.matiere-index',
                compact(
                    'matieres',
                    'niveaux'
                )
            );
        }

        $this->errorMessage = '';

        /*
        |--------------------------------------------------------------------------
        | NIVEAUX DE L'ANNÉE ACTIVE
        |--------------------------------------------------------------------------
        */

        $niveauxQuery = Niveau::where(
            'annee_scolaire_id',
            $anneeScolaire->id
        );

        /*
        |--------------------------------------------------------------------------
        | FILTRAGE POUR L'ENSEIGNANT
        |--------------------------------------------------------------------------
        */

        if (Auth::user()->hasRole('enseignant')) {

            /*
             * Récupérer uniquement les classes
             * attribuées à cet enseignant.
             */

            $classeIds = Auth::user()
                ->classes()
                ->pluck('classes.id');

            /*
             * Récupérer les niveaux correspondants
             * aux classes de l'enseignant.
             */

            $niveauIds = \App\Models\Classe::whereIn(
                'id',
                $classeIds
            )
            ->pluck('niveau_id');

            /*
             * L'enseignant ne voit que ses niveaux.
             */

            $niveauxQuery->whereIn(
                'id',
                $niveauIds
            );
        }

        $niveaux = $niveauxQuery
            ->orderBy('code')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | MATIÈRES
        |--------------------------------------------------------------------------
        */

        $matieresQuery = Matiere::with('niveau')
            ->whereHas(
                'niveau',
                function ($query) use ($anneeScolaire) {

                    $query->where(
                        'annee_scolaire_id',
                        $anneeScolaire->id
                    );

                }
            );

        /*
        |--------------------------------------------------------------------------
        | ENSEIGNANT : SEULEMENT SES NIVEAUX
        |--------------------------------------------------------------------------
        */

        if (Auth::user()->hasRole('enseignant')) {

            $classeIds = Auth::user()
                ->classes()
                ->pluck('classes.id');

            $niveauIds = \App\Models\Classe::whereIn(
                'id',
                $classeIds
            )
            ->pluck('niveau_id');

            $matieresQuery->whereIn(
                'niveau_id',
                $niveauIds
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FILTRE PAR NIVEAU
        |--------------------------------------------------------------------------
        */

        if ($this->niveau_id !== '') {

            $matieresQuery->where(
                'niveau_id',
                $this->niveau_id
            );
        }

        /*
        |--------------------------------------------------------------------------
        | RECHERCHE
        |--------------------------------------------------------------------------
        */

        if ($this->search !== '') {

            $matieresQuery->where(
                function ($query) {

                    $query->where(
                        'nom',
                        'like',
                        '%' . $this->search . '%'
                    )
                    ->orWhere(
                        'description',
                        'like',
                        '%' . $this->search . '%'
                    )
                    ->orWhereHas(
                        'niveau',
                        function ($query) {

                            $query->where(
                                'code',
                                'like',
                                '%' . $this->search . '%'
                            )
                            ->orWhere(
                                'libelle',
                                'like',
                                '%' . $this->search . '%'
                            );

                        }
                    );

                }
            );
        }

        $matieres = $matieresQuery
            ->orderBy('nom')
            ->paginate(10);

        return view(
            'matieres.matiere-index',
            compact(
                'matieres',
                'niveaux'
            )
        );
    }
}