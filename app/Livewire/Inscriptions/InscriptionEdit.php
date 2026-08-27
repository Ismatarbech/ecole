<?php

namespace App\Livewire\Inscriptions;

use App\Models\AnneeScolaire;
use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Niveau;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class InscriptionEdit extends Component
{
    use WithFileUploads;

    public Eleve $eleve;
    public $step = 1;

    // =========================================================
    // INFORMATIONS ELEVE
    // =========================================================

    public $matricule;
    public $nom;
    public $prenom;
    public $naissance;
    public $sexe;
    public $lieu;
    public $contact_eleve;
    public $contact_parent;
    public $photo;
    public $anciennePhoto;

    // =========================================================
    // SCOLARITE
    // =========================================================

    public $annee_scolaire_id;
    public $niveau_id;
    public $classe_id;

    // =========================================================
    // MOUNT
    // =========================================================

public function mount(Eleve $eleve)
{
    $this->eleve = $eleve;

    $this->matricule = $eleve->matricule;
    $this->nom = $eleve->nom;
    $this->prenom = $eleve->prenom;

    $this->naissance = $eleve->naissance
        ? \Carbon\Carbon::parse($eleve->naissance)->format('Y-m-d')
        : null;

    $this->sexe = $eleve->sexe;
    $this->lieu = $eleve->lieu;
    $this->contact_eleve = $eleve->contact_eleve;
    $this->contact_parent = $eleve->contact_parent;

    $this->classe_id = $eleve->classe_id;
    $this->annee_scolaire_id = $eleve->annee_scolaire_id;

    $this->anciennePhoto = $eleve->photo;
    $this->photo = null;

    // Niveau de l'élève
    $classe = Classe::find($eleve->classe_id);

    if ($classe) {
        $this->niveau_id = $classe->niveau_id;
    }

}

    // =========================================================
    // QUAND LE NIVEAU CHANGE
    // =========================================================

    public function updatedNiveauId($value)
    {
        $this->classe_id = null;

        if (!$value) {
            return;
        }

        $niveau = Niveau::find($value);

        if (!$niveau) {
            return;
        }

    }

    // =========================================================
    // SUIVANT
    // =========================================================

    public function suivant()
    {
        $this->validate([

            'matricule' => [
                'required',
                'string',
                'max:20',
                Rule::unique('eleves', 'matricule')
                    ->ignore($this->eleve->id),
            ],

            'nom' => [
                'required',
                'string',
                'max:100',
            ],

            'prenom' => [
                'required',
                'string',
                'max:100',
            ],

            'naissance' => [
                'required',
                'date',
            ],

            'sexe' => [
                'required',
                'in:M,F',
            ],

            'lieu' => [
                'nullable',
                'string',
                'max:150',
            ],

            'contact_eleve' => [
                'nullable',
                'string',
                'max:30',
            ],

            'contact_parent' => [
                'required',
                'string',
                'max:30',
            ],

            'photo' => [
                'nullable',
                'image',
                'max:2048',
            ],

            'annee_scolaire_id' => [
                'required',
                'exists:annee_scolaires,id',
            ],

            'niveau_id' => [
                'required',
                'exists:niveaux,id',
            ],

            'classe_id' => [
                'required',
                'exists:classes,id',
            ],
        ]);

        // Vérifier que la classe appartient au niveau

        $classe = Classe::where('id', $this->classe_id)
            ->where('niveau_id', $this->niveau_id)
            ->first();

        if (!$classe) {

            $this->addError(
                'classe_id',
                'Cette classe ne correspond pas au niveau sélectionné.'
            );

            return;
        }

        $this->modifierEleve();
    }

    public function modifierEleve()
    {
        $classe = Classe::where('id', $this->classe_id)
            ->where('niveau_id', $this->niveau_id)
            ->firstOrFail();

        $photoPath = $this->eleve->photo;

        if ($this->photo) {
            $photoPath = $this->photo->store('eleves', 'public');
        }

        $this->eleve->update([

                'matricule' => $this->matricule,

                'nom' => $this->nom,

                'prenom' => $this->prenom,

                'naissance' => $this->naissance,

                'sexe' => $this->sexe,

                'lieu' => $this->lieu,

                'contact_eleve' => $this->contact_eleve,

                'contact_parent' => $this->contact_parent,

                'classe_id' => $classe->id,

                'annee_scolaire_id' => $this->annee_scolaire_id,

            'photo' => $photoPath,
        ]);

        session()->flash(
            'success',
            'Informations de l’élève modifiées avec succès.'
        );

        return redirect()->route('inscription.index');
    }

    // =========================================================
    // RENDER
    // =========================================================

    public function render()
    {
        $niveaux = Niveau::orderBy('code')->get();

        // IMPORTANT :
        // récupérer toutes les classes du niveau sélectionné

        $classes = collect();

        if ($this->niveau_id) {

            $classes = Classe::where(
                'niveau_id',
                $this->niveau_id
            )
            ->orderBy('name')
            ->get();
        }

        $annees = AnneeScolaire::orderByDesc('id')->get();

        return view(
            'inscriptions.inscription-edit',
            [
                'niveaux' => $niveaux,
                'classes' => $classes,
                'annees' => $annees,
            ]
        );
    }
}