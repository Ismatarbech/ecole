<?php
namespace App\Livewire\Notes;

use Livewire\Component;
use App\Models\Note;
use App\Models\Eleve;
use App\Models\AnneeScolaire;

class NoteIndex extends Component
{
    public string $errorMessage = '';
    public string $successMessage = '';
    public string $search = '';

    public function updatedSearch(): void
    {
        $this->search = trim($this->search);
    }

    public function deleteNote($noteId)
    {
        $this->successMessage = '';
        $this->errorMessage = '';

        try {
            $note = Note::find($noteId);

            if (!$note) {
                $this->errorMessage = "La note n'existe pas.";
                return;
            }

            $note->delete();
            $this->successMessage = 'Note supprimée avec succès.';
        } catch (\Throwable $exception) {
            $this->errorMessage = "La note n'a pas pu être supprimée.";
        }
    }

public function render()
{
    $anneeScolaire = AnneeScolaire::where('status', 'active')->first();

    if (!$anneeScolaire) {
        $this->errorMessage = "Aucune année scolaire active n'a été trouvée.";
        $note = collect();

        return view('notes.note-index', compact('note'));
    }

    $this->errorMessage = '';
    $note = Note::with([
        'eleve.classe',
        'enseignant',
        'matiere'
    ])->whereHas('eleve', function ($query) use ($anneeScolaire) {
        $query->where('annee_scolaire_id', $anneeScolaire->id);
    })->when($this->search !== '', function ($query) {
        $query->where(function ($query) {
            $query->whereHas('eleve', function ($query) {
                $query->where('nom', 'like', '%' . $this->search . '%')
                    ->orWhere('prenom', 'like', '%' . $this->search . '%')
                    ->orWhere('matricule', 'like', '%' . $this->search . '%');
            })->orWhereHas('matiere', function ($query) {
                $query->where('nom', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })->orWhereHas('eleve.classe', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            });
        });
    })->get();

    return view('notes.note-index', [
        'note' => $note
    ]);
}
}