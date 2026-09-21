<?php

namespace App\Livewire\Enseignants;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class AttributionIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public string $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $users = User::role('enseignant')

            // ✅ CORRECTION ICI : passage par niveau
            ->whereHas('classes.niveau.anneeScolaire', function ($q) {
                $q->where('status', 'active');
            })

            ->when($this->search, function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            })

            ->orderBy('name')
            ->paginate(10);

        $data = $users->through(function ($user) {

            $relations = DB::table('classe_user')
                ->join('classes', 'classes.id', '=', 'classe_user.classe_id')

                // 🔥 AJOUT niveau
                ->join('niveaux', 'niveaux.id', '=', 'classes.niveau_id')

                // 🔥 année via niveau (CORRECTION IMPORTANTE)
                ->join('annee_scolaires', 'annee_scolaires.id', '=', 'niveaux.annee_scolaire_id')

                ->join('matieres', 'matieres.id', '=', 'classe_user.matiere_id')

                ->where('annee_scolaires.status', 'active')
                ->where('classe_user.user_id', $user->id)

                ->select(
                    'classes.id as classe_id',
                    'classes.name as classe_name',
                    'matieres.id as matiere_id',
                    'matieres.nom as matiere_name'
                )
                ->get()
                ->groupBy('classe_id');

            return [
                'enseignant' => $user,
                'classes' => $relations,
            ];
        });

        return view('enseignants.attribution-listes', [
            'data' => $data,
        ]);
    }
}