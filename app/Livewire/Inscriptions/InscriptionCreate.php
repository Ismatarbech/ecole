<?php

namespace App\Livewire\Inscriptions;

use App\Models\AnneeScolaire;
use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Niveau;
use App\Models\Paiement;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class InscriptionCreate extends Component
{
    use WithFileUploads;

    /*
    |--------------------------------------------------------------------------
    | ETAPE
    |--------------------------------------------------------------------------
    */

    public $step = 1;


    /*
    |--------------------------------------------------------------------------
    | INFORMATIONS ELEVE
    |--------------------------------------------------------------------------
    */

    public $matricule;

    public $nom;

    public $prenom;

    public $naissance;

    public $sexe;

    public $lieu;

    public $contact_eleve;

    public $contact_parent;

    public $photo;


    /*
    |--------------------------------------------------------------------------
    | SCOLARITE
    |--------------------------------------------------------------------------
    */

    public $annee_scolaire_id;

    public $niveau_id;

    public $classe_id;


    /*
    |--------------------------------------------------------------------------
    | PAIEMENT
    |--------------------------------------------------------------------------
    */

    public $frais_scolarite = 0;

    public $montant = 0;

    public $mode_paiement = 'Especes';

    public $date_paiement;


    /*
    |--------------------------------------------------------------------------
    | MOUNT
    |--------------------------------------------------------------------------
    */

    public function mount()
{
    $annee = AnneeScolaire::where('status', 'active')->first();

    if (!$annee) {
        abort(404, 'Aucune année scolaire active.');
        echo'annee ';
    }

    $this->annee_scolaire_id = $annee->id;

    $this->date_paiement = now()->format('Y-m-d');

    $this->genererMatricule();
}


    /*
    |--------------------------------------------------------------------------
    | GENERER MATRICULE
    |--------------------------------------------------------------------------
    */

            public function genererMatricule()
            {
                if (!$this->niveau_id) {
                    $this->matricule = null;
                    return;
                }

                $annee = AnneeScolaire::find($this->annee_scolaire_id);
                $niveau = Niveau::find($this->niveau_id);

                if (!$annee || !$niveau) {
                    $this->matricule = null;
                    return;
                }

                // Remplacez annee_debut par le vrai nom de votre colonne si nécessaire
                $anneeCode = $annee->annee_debut ?? now()->format('Y');

                $codeNiveau = strtoupper($niveau->code);

                $dernier = Eleve::latest('id')->first();
                $numero = $dernier ? $dernier->id + 1 : 1;

                $this->matricule =
                    $anneeCode .
                    $codeNiveau .
                    str_pad($numero, 5, '0', STR_PAD_LEFT);
}



// ...existing code...


    /*
    |--------------------------------------------------------------------------
    | QUAND LE NIVEAU CHANGE
    |--------------------------------------------------------------------------
    */
   public function updatedNiveauId($value)
{
    $this->classe_id = null;

    $this->genererMatricule();

        // Aucun niveau sélectionné
        if (!$value) {
            $this->frais_scolarite = 0;
            $this->montant = 0;

            return;
        }

        // Récupérer le niveau
        $niveau = Niveau::find($value);

        if (!$niveau) {
            $this->frais_scolarite = 0;
            $this->montant = 0;

            return;
        }

        // Le montant dans la table niveaux
        // représente le frais total de scolarité
        $this->frais_scolarite = (float) $niveau->montant;

        // Par défaut, l'élève paie la totalité
        $this->montant = $this->frais_scolarite;
    }

    /*
    |--------------------------------------------------------------------------
    | RESTE A PAYER
    |--------------------------------------------------------------------------
    */

    public function getResteProperty()
    {
        return max(0,(float) $this->frais_scolarite - (float) $this->montant);
    }


    /*
    |--------------------------------------------------------------------------
    | SUIVANT
    |--------------------------------------------------------------------------
    */

    public function suivant()
    {
        /*
        | Validation étape 1
        */

        $this->validate([
                'matricule' => [
                'required',
                'string',
                'max:2048',
                'unique:eleves,matricule',
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


        /*
        | Vérifier que la classe appartient
        | au niveau sélectionné
        */

    
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


        /*
        | Récupérer les frais du niveau
        */

        $niveau = Niveau::findOrFail($this->niveau_id);

        // Frais total provenant de la table niveaux
        $this->frais_scolarite = (float) $niveau->montant;

        // Montant payé par défaut = totalité des frais
        $this->montant = $this->frais_scolarite;


        /*
        | Aller à l'étape 2
        */

        $this->step = 2;
    }


    /*
    |--------------------------------------------------------------------------
    | PRECEDENT
    |--------------------------------------------------------------------------
    */

    public function precedent()
    {
        $this->step = 1;
    }


    /*
    |--------------------------------------------------------------------------
    | ENREGISTRER
    |--------------------------------------------------------------------------
    */

    public function enregistrer()
    {
        /*
        | Validation paiement
        */

        $this->validate([
        'montant' => [
            'required',
            'numeric',
            'min:0',
            'max:' . $this->frais_scolarite,
        ],

        'mode_paiement' => [
            'required',
            'in:Especes,Mobile Money,Virement,Cheque',
        ],

        'date_paiement' => [
            'required',
            'date',
        ],
    ]);


        /*
        | Vérifier la classe
        */

        $classe = Classe::where('id', $this->classe_id)
            ->where('niveau_id', $this->niveau_id)
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | TRANSACTION
        |--------------------------------------------------------------------------
        |
        | Élève + paiement sont enregistrés ensemble.
        |
        */

        $eleve = DB::transaction(function () use ($classe) {

            /*
            | PHOTO
            */

            $photoPath = null;

            if ($this->photo) {

                $photoPath = $this->photo->store(
                    'eleves',
                    'public'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | CREER ELEVE
            |--------------------------------------------------------------------------
            */

            $eleve = Eleve::create([

                'matricule' =>
                    $this->matricule,

                'nom' =>
                    $this->nom,

                'prenom' =>
                    $this->prenom,

                'naissance' =>
                    $this->naissance,

                'sexe' =>
                    $this->sexe,

                'lieu' =>
                    $this->lieu,

                'contact_eleve' =>
                    $this->contact_eleve,

                'contact_parent' =>
                    $this->contact_parent,

                'classe_id' =>
                    $classe->id,

                'annee_scolaire_id' =>
                    $this->annee_scolaire_id,

                'photo' =>
                    $photoPath,

                'date_inscription' =>
                    now()->format('Y-m-d'),
            ]);


            /*
            |--------------------------------------------------------------------------
            | CREER PAIEMENT
            |--------------------------------------------------------------------------
            */

            Paiement::create([

                'eleve_id' =>
                    $eleve->id,

                'annee_scolaire_id' =>
                    $this->annee_scolaire_id,

                'classe_id' =>
                    $classe->id,

                'montant' =>
                     $this->montant,

                'mode_paiement' =>
                    $this->mode_paiement,

                'date_paiement' => 
                    $this->date_paiement,
            ]);


            return $eleve;
        });


        /*
        |--------------------------------------------------------------------------
        | MESSAGE
        |--------------------------------------------------------------------------
        */

        session()->flash(
            'success',
            'Élève inscrit et paiement enregistré avec succès.'
        );


        /*
        |--------------------------------------------------------------------------
        | REDIRECTION
        |--------------------------------------------------------------------------
        */

        return redirect()->route('inscription.index')->with('success', 'Année scolaire créée avec succès.');

    }


    /*
    |--------------------------------------------------------------------------
    | RENDER
    |--------------------------------------------------------------------------
    */

    public function render()
{
    $niveaux = Niveau::orderBy('code')->get();

    $classes = collect();

    if (!empty($this->niveau_id)) {

        $classes = Classe::where(
            'niveau_id',
            $this->niveau_id
        )
        ->orderBy('name')
        ->get();
    }

    $annees = AnneeScolaire::orderByDesc('id')->get();

    return view(
        'inscriptions.inscription-create',
        [
            'niveaux' => $niveaux,
            'classes' => $classes,
            'annees' => $annees,
        ]
    );
}
}