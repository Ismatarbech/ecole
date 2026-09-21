<?php

namespace App\Livewire\Enseignants;

use App\Models\AnneeScolaire;
use App\Models\Matiere;
use App\Models\Classe;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Component;

class AttributionClasses extends Component
{
    public string $user_id = '';
    public string $classe_id = '';
    public string $matiere_id = '';

    #[Computed]
    public function anneeActive(): ?AnneeScolaire
    {
        return AnneeScolaire::where('status', 'active')->first();
    }

    #[Computed]
    public function enseignants()
    {
        return User::role('enseignant')->orderBy('name')->get();
    }

    #[Computed]
    public function classes()
    {
        if (!$this->anneeActive) {
            return collect();
        }

        return Classe::with('niveau')
            ->whereHas('niveau', fn ($q) => $q->where('annee_scolaire_id', $this->anneeActive->id))
            ->get()
            ->keyBy('id');
    }

    /** Matières du niveau de la classe choisie */
    #[Computed]
    public function matieres()
    {
        $classe = $this->classes->get((int) $this->classe_id);

        if (!$classe) {
            return collect();
        }

        return Matiere::where('niveau_id', $classe->niveau_id)
            ->orderBy('nom')
            ->get();
    }

    /**
     * Matières déjà prises dans la classe choisie.
     * Retourne [matiere_id => nom de l'enseignant]
     */
    #[Computed]
    public function matieresOccupees()
    {
        if ($this->classe_id === '') {
            return collect();
        }

        return DB::table('classe_user')
            ->join('users', 'users.id', '=', 'classe_user.user_id')
            ->where('classe_user.classe_id', (int) $this->classe_id)
            ->pluck('users.name', 'classe_user.matiere_id');
    }

    /** Quand la classe change, on vide la matière */
    public function updatedClasseId(): void
    {
        $this->matiere_id = '';
        $this->resetValidation('matiere_id');
    }

    public function attribuer()
    {
        $this->validate([
            'user_id'    => 'required|exists:users,id',
            'classe_id'  => 'required',
            'matiere_id' => 'required',
        ], [
            'user_id.required'    => 'Veuillez choisir un enseignant.',
            'classe_id.required'  => 'Veuillez choisir une classe.',
            'matiere_id.required' => 'Veuillez choisir une matière.',
        ]);

        if (!$this->anneeActive) {
            session()->flash('error', 'Aucune année scolaire active.');
            return;
        }

        $enseignant = User::role('enseignant')->find($this->user_id);
        $classe     = $this->classes->get((int) $this->classe_id);
        $matiere    = Matiere::find($this->matiere_id);

        if (!$enseignant || !$classe || !$matiere) {
            $this->addError('classe_id', 'Données invalides.');
            return;
        }

        // La matière doit appartenir au niveau de la classe
        if ((int) $matiere->niveau_id !== (int) $classe->niveau_id) {
            $this->addError('matiere_id', 'Cette matière n\'appartient pas au niveau de la classe.');
            return;
        }

        // 🔒 Cette matière est-elle déjà attribuée dans cette classe ?
        $occupe = DB::table('classe_user')
            ->join('users', 'users.id', '=', 'classe_user.user_id')
            ->where('classe_user.classe_id', $classe->id)
            ->where('classe_user.matiere_id', $matiere->id)
            ->select('classe_user.user_id', 'users.name')
            ->first();

        if ($occupe) {
            $message = ((int) $occupe->user_id === (int) $enseignant->id)
                ? 'Cette attribution existe déjà pour cet enseignant.'
                : "Cette matière est déjà attribuée à {$occupe->name} dans cette classe.";

            $this->addError('matiere_id', $message);
            return;
        }

        try {
            DB::table('classe_user')->insert([
                'user_id'    => $enseignant->id,
                'classe_id'  => $classe->id,
                'matiere_id' => $matiere->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (QueryException $e) {
            // 23000 = violation de contrainte unique (2 enregistrements simultanés)
            if ($e->getCode() === '23000') {
                $this->addError('matiere_id', 'Cette matière vient d\'être attribuée à un autre enseignant dans cette classe.');
                return;
            }
            throw $e;
        }

        return redirect()
            ->route('enseignants.index')
            ->with('success', 'Attribution enregistrée avec succès.');
    }

    public function render()
    {
        return view('enseignants.attribution-classes');
    }
}