<?php

namespace App\Livewire\Niveaux;

use App\Models\AnneeScolaire;
use App\Models\Niveau;
use Livewire\Component;

class NiveauxCreate extends Component
{
    
    public function deleteNiveau($niveauId)
    {
        $this->successMessage = '';
        $this->errorMessage = '';

        try {

            $niveau = Niveaux::find($niveauId);

            if (!$niveau) {
                $this->errorMessage = "L'niveau n'existe pas.";
                return;
            }

            $niveau = $niveau->name;

            $niveau->delete();

            $this->successMessage =
                "Le niveau « {$niveau} » a été supprimé avec succès.";

        } catch (\Exception $e) {

            $this->errorMessage =
                "Le niveau n'a pas pu être supprimé.";
        }
    }
    public $code = '';
    public $libelle = '';
    public $montant = '';
    public $annee_scolaire_id;


    /**
     * Charger l'année scolaire active
     */
    public function mount()
    {
        $anneeScolaire = AnneeScolaire::where('status', 'active')->first();

        if ($anneeScolaire) {
            $this->annee_scolaire_id = $anneeScolaire->id;
        }
    }


    /**
     * Enregistrer le niveau
     */
    public function save()
    {
        $this->validate([
            'code' => [
                'required',
                'string',
                'max:255',
                'unique:niveaux,code',
            ],

            'libelle' => [
                'required',
                'string',
                'max:255',
                'unique:niveaux,libelle',
            ],

            'montant' => [
                'required',
                'numeric',
                'min:0',
            ],

            'annee_scolaire_id' => [
                'required',
                'exists:annee_scolaires,id',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Vérifier l'année scolaire active
        |--------------------------------------------------------------------------
        */

        $anneeScolaire = AnneeScolaire::where(
            'id',
            $this->annee_scolaire_id
        )
        ->where('status', 'active')
        ->first();


        if (!$anneeScolaire) {

            session()->flash(
                'error',
                "Aucune année scolaire active n'a été trouvée."
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Créer le niveau
        |--------------------------------------------------------------------------
        */

        Niveau::create([
            'code' => $this->code,
            'libelle' => $this->libelle,
            'montant' => $this->montant,
            'annee_scolaire_id' => $anneeScolaire->id,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Message
        |--------------------------------------------------------------------------
        */

        session()->flash(
            'message',
            "Le niveau « {$this->libelle} » a été créé avec succès !"
        );


        /*
        |--------------------------------------------------------------------------
        | Redirection
        |--------------------------------------------------------------------------
        */

        return redirect()->route('niveaux.index');
    }


    public function render()
    {
        return view('niveaux.niveau-create');
    }
}