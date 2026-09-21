<?php

namespace App\Livewire\Notes;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Note;
use App\Models\Classe;
use App\Models\Matiere;

class NoteIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public string $errorMessage = '';
    public string $successMessage = '';

    public string $search = '';

    public $id_classe = '';
    public $matiere_id = '';

    public $nombreEleves = null;

    // ==========================================================
    // VÉRIFIER ENSEIGNANT
    // ==========================================================
    private function estEnseignant(): bool
    {
        return auth()->check()
            && auth()->user()->hasRole('enseignant');
    }

    // ==========================================================
    // VÉRIFIER SUPER ADMIN
    // ==========================================================
    private function estSuperAdmin(): bool
    {
        return auth()->check()
            && auth()->user()->hasRole('super-admin');
    }

    // ==========================================================
    // CLASSES AUTORISÉES (FILTRÉES ANNÉE ACTIVE)
    // ==========================================================
    private function classesAutorisees()
    {
        $user = auth()->user();

        if ($this->estEnseignant()) {

            return Classe::whereHas('niveau.anneeScolaire', function ($q) {
                    $q->where('status', 'active');
                })
                ->whereHas('enseignants', function ($query) use ($user) {
                    $query->where('users.id', $user->id);
                })
                ->orderBy('name')
                ->get();
        }

        return Classe::whereHas('niveau.anneeScolaire', function ($q) {
                $q->where('status', 'active');
            })
            ->orderBy('name')
            ->get();
    }

    // ==========================================================
    // CLASSE AUTORISÉE
    // ==========================================================
    private function classeAutorisee($classeId): bool
    {
        if (!$classeId) {
            return false;
        }

        return Classe::whereKey($classeId)
            ->whereHas('niveau.anneeScolaire', function ($q) {
                $q->where('status', 'active');
            })
            ->when($this->estEnseignant(), function ($query) {
                $query->whereHas('enseignants', function ($q) {
                    $q->where('users.id', auth()->id());
                });
            })
            ->exists();
    }

    // ==========================================================
    // MATIÈRES AUTORISÉES (FILTRÉES ANNÉE ACTIVE)
    // ==========================================================
    private function matieresAutorisees($classeId)
    {
        if (!$classeId) {
            return Matiere::whereHas('notes.eleve.classe.niveau.anneeScolaire', function ($q) {
                    $q->where('status', 'active');
                })
                ->orderBy('nom')
                ->get();
        }

        return Matiere::whereHas('notes.eleve.classe', function ($q) use ($classeId) {
                $q->where('id', $classeId)
                  ->whereHas('niveau.anneeScolaire', function ($q2) {
                      $q2->where('status', 'active');
                  });
            })
            ->orderBy('nom')
            ->get();
    }

    // ==========================================================
    // UPDATE SEARCH
    // ==========================================================
    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    // ==========================================================
    // UPDATE CLASSE
    // ==========================================================
    public function updatedIdClasse(): void
    {
        $this->resetPage();

        if (!$this->classeAutorisee($this->id_classe)) {
            $this->id_classe = '';
            $this->matiere_id = '';
            $this->nombreEleves = null;
            $this->errorMessage = "Vous n'avez pas accès à cette classe.";
            return;
        }

        $this->chargerNombreEleves();
    }

    // ==========================================================
    // UPDATE MATIÈRE
    // ==========================================================
    public function updatedMatiereId(): void
    {
        $this->resetPage();
    }

    // ==========================================================
    // NOMBRE ÉLÈVES
    // ==========================================================
    private function chargerNombreEleves(): void
    {
        $this->nombreEleves = null;

        if (!$this->id_classe) return;

        $classe = Classe::withCount('eleves')
            ->whereHas('niveau.anneeScolaire', function ($q) {
                $q->where('status', 'active');
            })
            ->find($this->id_classe);

        $this->nombreEleves = $classe?->eleves_count ?? 0;
    }

    // ==========================================================
    // RESET
    // ==========================================================
    public function resetFilters(): void
    {
        $this->search = '';
        $this->id_classe = '';
        $this->matiere_id = '';
        $this->nombreEleves = null;
        $this->resetPage();
    }

    // ==========================================================
    // AUTORISATION MODIF NOTE
    // ==========================================================
    public function autoriserModification($noteId): void
    {
        if (!$this->estSuperAdmin()) {
            $this->errorMessage = "Accès refusé.";
            return;
        }

        $note = Note::find($noteId);

        if (!$note) {
            $this->errorMessage = "Note introuvable.";
            return;
        }

        $note->update([
            'modification_autorisee' => !$note->modification_autorisee
        ]);

        $this->successMessage = "Statut modifié.";
    }

    // ==========================================================
    // DELETE NOTE
    // ==========================================================
    public function deleteNote($noteId): void
    {
        $note = Note::whereKey($noteId)->first();

        if (!$note) {
            $this->errorMessage = "Note introuvable.";
            return;
        }

        $note->delete();

        $this->successMessage = "Note supprimée.";
    }

    // ==========================================================
    // RENDER
    // ==========================================================
    public function render()
    {
        $this->chargerNombreEleves();

        $classes = $this->classesAutorisees();
        $matieres = $this->matieresAutorisees($this->id_classe);

        $note = Note::with([
            'eleve.classe.niveau.anneeScolaire',
            'matiere',
            'enseignant'
        ])

        // 🔥 FILTRE GLOBAL ANNÉE ACTIVE
        ->whereHas('eleve.classe.niveau.anneeScolaire', function ($q) {
            $q->where('status', 'active');
        })

        // SEARCH
        ->when($this->search, function ($query) {
            $search = '%' . $this->search . '%';

            $query->where(function ($q) use ($search) {

                $q->whereHas('eleve', function ($e) use ($search) {
                    $e->where('nom', 'like', $search)
                      ->orWhere('prenom', 'like', $search)
                      ->orWhere('matricule', 'like', $search);
                })

                ->orWhereHas('matiere', function ($m) use ($search) {
                    $m->where('nom', 'like', $search);
                })

                ->orWhereHas('eleve.classe', function ($c) use ($search) {
                    $c->where('name', 'like', $search);
                });
            });
        })

        // CLASSE
        ->when($this->id_classe, function ($q) {
            $q->whereHas('eleve', function ($e) {
                $e->where('classe_id', $this->id_classe);
            });
        })

        // MATIERE
        ->when($this->matiere_id, function ($q) {
            $q->where('matiere_id', $this->matiere_id);
        })

        // ENSEIGNANT SECURITY
        ->when($this->estEnseignant(), function ($q) {
            $userId = auth()->id();

            $q->whereExists(function ($query) use ($userId) {
                $query->selectRaw(1)
                    ->from('classe_user as cu')
                    ->where('cu.user_id', $userId)
                    ->whereColumn('cu.matiere_id', 'notes.matiere_id')
                    ->whereExists(function ($e) {
                        $e->selectRaw(1)
                          ->from('eleves')
                          ->whereColumn('eleves.id', 'notes.eleve_id')
                          ->whereColumn('eleves.classe_id', 'cu.classe_id');
                    });
            });
        })

        ->latest()
        ->paginate(15);

        return view('notes.note-index', [
            'note' => $note,
            'classes' => $classes,
            'matieres' => $matieres,
            'nombreEleves' => $this->nombreEleves,
        ]);
    }
}