<?php

namespace App\Livewire\Inscriptions;

use App\Models\Eleve;
use App\Models\Classe;
use App\Models\Niveau;
use App\Models\AnneeScolaire;
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
    public $contact_parent;
    public $date_inscription;
    public $tuteur;
    public $contact_tuteur;

    /*
    |--------------------------------------------------------------------------
    | PHOTO
    |--------------------------------------------------------------------------
    */

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
    | MESSAGES
    |--------------------------------------------------------------------------
    */

    protected $messages = [
        'nom.required' => 'Le nom est obligatoire.',
        'prenom.required' => 'Le prénom est obligatoire.',
        'naissance.required' => 'La date de naissance est obligatoire.',
        'sexe.required' => 'Veuillez sélectionner le sexe.',
        'lieu.required' => 'Le lieu de naissance est obligatoire.',

        'date_inscription.required' =>
            'La date d\'inscription est obligatoire.',

        'annee_scolaire_id.required' =>
            'Veuillez sélectionner une année scolaire.',

        'niveau_id.required' =>
            'Veuillez sélectionner un niveau.',

        'classe_id.required' =>
            'Veuillez sélectionner une classe.',

        'montant.required' =>
            'Le montant est obligatoire.',

        'montant.numeric' =>
            'Le montant doit être un nombre.',

        'montant.max' =>
            'Le montant ne peut pas dépasser les frais de scolarité.',

        'date_paiement.required' =>
            'La date de paiement est obligatoire.',

        'photo.image' =>
            'Le fichier sélectionné doit être une image.',

        'photo.required' =>
            'La photo de l\'élève est obligatoire.',

        'photo.max' =>
            'La photo ne doit pas dépasser 4 Mo.',
    ];

    /*
    |--------------------------------------------------------------------------
    | MOUNT
    |--------------------------------------------------------------------------
    */

    public function mount()
    {
        $annee = AnneeScolaire::where('status', 'active')->first();

        if (!$annee) {
            session()->flash(
                'error',
                'Aucune année scolaire active n\'a été trouvée.'
            );

            return;
        }

        $this->annee_scolaire_id = $annee->id;

        $this->date_inscription = now()->format('Y-m-d');

        $this->date_paiement = now()->format('Y-m-d');

        $this->montant = 0;

        $this->frais_scolarite = 0;
    }

    /*
    |--------------------------------------------------------------------------
    | CHANGEMENT NIVEAU
    |--------------------------------------------------------------------------
    */

    public function updatedNiveauId($value)
    {
        $this->classe_id = null;

        $this->matricule = null;

        $this->montant = 0;

        $niveau = Niveau::find($value);

        if ($niveau) {
            $this->frais_scolarite = (float) $niveau->montant;
        } else {
            $this->frais_scolarite = 0;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | CHANGEMENT CLASSE
    |--------------------------------------------------------------------------
    */

    public function updatedClasseId($value)
    {
        if ($value) {
            $this->genererMatricule();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | GENERATION MATRICULE
    |--------------------------------------------------------------------------
    */

    public function genererMatricule()
    {
        if (!$this->classe_id) {
            return;
        }

        $classe = Classe::find($this->classe_id);

        if (!$classe) {
            return;
        }

        $annee = AnneeScolaire::find($this->annee_scolaire_id);

        $anneeCode = now()->format('Y');

        if ($annee) {
            if (!empty($annee->annee_debut)) {
                $anneeCode = $annee->annee_debut;
            } elseif (!empty($annee->current_annee)) {
                $anneeCode = $annee->current_annee;
            }
        }

        /*
        | On prend le code de la classe si disponible.
        */

        $codeClasse = $classe->code ?? null;

        /*
        | Sinon on utilise le nom.
        */

        if (!$codeClasse) {
            $codeClasse = $classe->name ?? 'CL';
        }

        /*
        | Nettoyage du code.
        */

        $codeClasse = strtoupper(
            preg_replace(
                '/[^AZa-z0-9]/',
                '',
                $codeClasse
            )
        );

        /*
        | Dernier élève.
        */

        $dernierEleve = Eleve::latest('id')->first();

        $numero = $dernierEleve
            ? $dernierEleve->id + 1
            : 1;

        $this->matricule =
            $anneeCode .
            '-' .
            $codeClasse .
            '-' .
            str_pad(
                $numero,
                4,
                '0',
                STR_PAD_LEFT
            );
    }

    /*
    |--------------------------------------------------------------------------
    | RESTE A PAYER
    |--------------------------------------------------------------------------
    */

    public function getResteProperty()
    {
        return max(
            0,
            (float) $this->frais_scolarite
            -
            (float) $this->montant
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ETAPE 1 -> ETAPE 2
    |--------------------------------------------------------------------------
    */

    public function suivant()
    {
        $this->validate([
            'nom' => 
                'required|string|max:255',
            
            'prenom' => 
                'required|string|max:255',
            
            'naissance' => 
                'required|date',
            
            'sexe' => 
                'required|in:M,F',
            
            'lieu' => 
                'required|string|max:255',

            'contact_parent' =>
                'nullable|string|max:30',

            'date_inscription' =>
                'required|date',

            'annee_scolaire_id' =>
                'required|exists:annee_scolaires,id',

            'niveau_id' =>
                'required|exists:niveaux,id',

            'classe_id' =>
                'required|exists:classes,id',

            'tuteur' => 
                'nullable|string|max:255',

            'contact_tuteur' =>
                'nullable|string|max:30',
        ]);

        /*
        | Vérification niveau / classe
        */

        $classe = Classe::find($this->classe_id);

        if (!$classe) {
            $this->addError(
                'classe_id',
                'La classe sélectionnée est invalide.'
            );

            return;
        }

        if ($classe->niveau_id != $this->niveau_id) {
            $this->addError(
                'classe_id',
                'Cette classe ne correspond pas au niveau sélectionné.'
            );

            return;
        }

        /*
        | Récupération des frais
        */

        $niveau = Niveau::find($this->niveau_id);

        if ($niveau) {
            $this->frais_scolarite =
                (float) $niveau->montant;
        }

        /*
        | Matricule
        */

        if (!$this->matricule) {
            $this->genererMatricule();
        }

        $this->montant = 0;

        $this->step = 2;
    }

    /*
    |--------------------------------------------------------------------------
    | ETAPE 2 -> ETAPE 3
    |--------------------------------------------------------------------------
    */

    public function allerRecapitulatif()
    {
        $this->validate([
            'montant' => [
                'required',
                'numeric',
                'min:0',
                'max:' . $this->frais_scolarite,
            ],

            'mode_paiement' =>
                'required|in:Especes,Mobile Money,Virement,Cheque',

            'date_paiement' =>
                'required|date',
        ]);

        $this->step = 3;
    }

    /*
    |--------------------------------------------------------------------------
    | RETOUR
    |--------------------------------------------------------------------------
    */

    public function retour()
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | ENREGISTRER
    |--------------------------------------------------------------------------
    */

    public function enregistrer()
    {
        $this->validate([
            'photo' => 'required|image|max:4096',
        ]);

        DB::transaction(function () {

            /*
            |--------------------------------------------------------------------------
            | PHOTO
            |--------------------------------------------------------------------------
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
            | ELEVE
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

                'contact_parent' =>
                    $this->contact_parent,

                'tuteur' =>
                    $this->tuteur,
                
                'contact_tuteur' =>
                    $this->contact_tuteur ,

                'date_inscription' =>
                    $this->date_inscription,

                'photo' =>
                    $photoPath,

                'annee_scolaire_id' =>
                    $this->annee_scolaire_id,

                'niveau_id' =>
                    $this->niveau_id,

                'classe_id' =>
                    $this->classe_id,
            ]);

            /*
            |--------------------------------------------------------------------------
            | PAIEMENT
            |--------------------------------------------------------------------------
            */

            Paiement::create([
                'eleve_id' =>
                    $eleve->id,

                'annee_scolaire_id' =>
                    $this->annee_scolaire_id,

                'classe_id' =>
                    $this->classe_id,

                'montant' =>
                    $this->montant,

                'mode_paiement' =>
                    $this->mode_paiement,

                'date_paiement' =>
                    $this->date_paiement,
            ]);
        });

        session()->flash(
            'success',
            'L\'élève a été inscrit avec succès.'
        );

        return redirect()->route(
            'inscription.index'
        );
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

        if ($this->niveau_id) {

            $classes = Classe::where(
                'niveau_id',
                $this->niveau_id
            )
            ->orderBy('name')
            ->get();
        }
     
        $annees = AnneeScolaire::where('status', 'active')
        ->orderByDesc('id')
        ->get();

        return view(
            'inscriptions.inscription-create',
            compact(
                'niveaux',
                'classes',
                'annees'
            )
        );
    }
}