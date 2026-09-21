<?php

namespace App\Livewire\Classes;

use App\Models\Classe;
use App\Models\AnneeScolaire;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ClasseIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public string $successMessage = '';
    public string $errorMessage = '';
    public string $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * 🔥 MEME LOGIQUE QUE NIVEAUX
     */
    private function getOrder($code): int
    {
        return match (strtoupper(trim($code))) {

            'TERMINALE', 'TC', 'TD', 'TA' => 1,
            'PREMIERE', '1ERE' => 2,
            'SECONDE', '2ND' => 3,

            '3EME' => 4,
            '4EME' => 5,
            '5EME' => 6,
            '6EME' => 7,

            'CM2' => 8,
            'CM1' => 9,
            'CE2' => 10,
            'CE1' => 11,

            'CP2' => 12,
            'CP1' => 13,

            default => 999,
        };
    }

    public function deleteClasse($classeId)
    {
        $this->successMessage = '';
        $this->errorMessage = '';

        try {
            $classe = Classe::findOrFail($classeId);

            if (
                Auth::user()->hasRole('enseignant') &&
                $classe->enseignant_id != Auth::id()
            ) {
                $this->errorMessage = "Vous n'avez pas l'autorisation.";
                return;
            }

            $classe->delete();

            $this->successMessage = "Classe supprimée avec succès.";

        } catch (\Exception $e) {
            $this->errorMessage = "Erreur lors de la suppression.";
        }
    }
public function render()
{
    $anneeScolaire = AnneeScolaire::where('status', 'active')->first();

    if (!$anneeScolaire) {
        $this->errorMessage = "Aucune année scolaire active.";

        return view('classes.classe-index', [
            'classe' => Classe::whereRaw('1=0')->paginate(10)
        ]);
    }

    $classe = Classe::with('niveau')
        ->whereRelation('niveau', 'annee_scolaire_id', $anneeScolaire->id)

        ->when(auth()->user()->hasRole('enseignant'), function ($query) {
            $query->whereHas('enseignants', function ($q) {
                $q->where('users.id', auth()->id());
            });
        })

        ->when($this->search, function ($query) {
            $search = '%' . $this->search . '%';

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', $search)
                    ->orWhereHas('niveau', function ($q2) use ($search) {
                        $q2->where('libelle', 'like', $search)
                            ->orWhere('code', 'like', $search);
                    });
            });
        })

        ->get()
        ->sortBy(fn ($c) => $this->getOrder($c->niveau->code ?? ''))
        ->values();

    // 🔥 pagination manuelle propre
    $page = request()->get('page', 1);
    $perPage = 10;

    $paginated = new \Illuminate\Pagination\LengthAwarePaginator(
        $classe->forPage($page, $perPage),
        $classe->count(),
        $perPage,
        $page,
        ['path' => request()->url()]
    );

    return view('classes.classe-index', [
        'classe' => $paginated
    ]);
}
}