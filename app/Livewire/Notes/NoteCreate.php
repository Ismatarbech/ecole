<?php 

namespace App\Livewire\Notes;

use Livewire\Component;
use App\Models\Note;
use App\Models\Eleve;
use App\Models\User;
use App\Models\Matiere;
use App\Models\Classe;
use App\Models\AnneeScolaire;

class NoteCreate extends Component
{
    public $classe_id;
    public $eleve_id;
    public $matiere_id;
    public $devoir;
    public $composition;

    public function updatedClasseId(): void
    {
        $this->reset(['eleve_id', 'matiere_id']);
        $this->resetValidation();
    }

    public function save()
    {
        $this->validate([
            'classe_id' => 'required|exists:classes,id',
            'eleve_id' => 'required|exists:eleves,id',
            'matiere_id' => 'required|exists:matieres,id',
            'devoir' => 'required|numeric|min:0|max:20',
            'composition' => 'required|numeric|min:0|max:20',
        
        ]);

        $eleve = Eleve::whereKey($this->eleve_id)
            ->where('classe_id', $this->classe_id)
            ->first();
        $matiere = Matiere::whereKey($this->matiere_id)
            ->whereHas('niveau', function ($query) {
                $query->whereHas('classes', fn ($query) => $query->whereKey($this->classe_id));
            })
            ->first();

        if (!$eleve || !$matiere) {
            $this->addError('matiere_id', 'La matière ne correspond pas à la classe sélectionnée.');
            return;
        }

        try {
            Note::create([
                'eleve_id' => $this->eleve_id,
                'matiere_id' => $this->matiere_id,
                'enseignant_id' => auth()->id(),
                'devoir' => $this->devoir,
                'composition' => $this->composition,
            ]);
        } catch (\Throwable $exception) {
            session()->flash('error', "La note n'a pas pu être créée.");
            return;
        }

        return redirect('notes')->with('success', 'Note créée avec succès.');

        // reset form
        $this->reset(['eleve_id', 'matiere_id', 'devoir', 'composition']);
    }

    public function render()
    {
        $annee = AnneeScolaire::where('status', 'active')->first();
        $classes = $annee
            ? Classe::whereHas('niveau', fn ($query) => $query->where('annee_scolaire_id', $annee->id))
                ->orderBy('name')
                ->get()
            : collect();

        $classe = $this->classe_id ? $classes->firstWhere('id', (int) $this->classe_id) : null;

        return view('notes.note-create', [
            'eleves' => $classe
                ? Eleve::where('classe_id', $classe->id)
                    ->where('annee_scolaire_id', $annee?->id)
                    ->orderBy('matricule')
                    ->get()
                : collect(),
            'matieres' => $classe
                ? Matiere::where('niveau_id', $classe->niveau_id)->orderBy('nom')->get()
                : collect(),
            'classes' => $classes,
            'enseignant' => auth()->user(),
           
        ]);
    }
}