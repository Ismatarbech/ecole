<?php

namespace App\Livewire\Niveaux;

use Livewire\Component;
use App\Models\Niveau;
use App\Models\AnneeScolaire;
use Illuminate\Validation\Rule;

class NiveauxEdit extends Component
{
    public Niveau $niveau;

    public string $code = '';
    public string $libelle = '';
    public $montant = 0;
    public $annee_scolaire_id;


    /**
     * Charger le niveau
     */
    public function mount(Niveau $niveau)
    {
        $this->niveau = $niveau;

        $this->code = $niveau->code;
        $this->libelle = $niveau->libelle;
        $this->montant = $niveau->montant;
        $this->annee_scolaire_id = $niveau->annee_scolaire_id;
    }


    /**
     * Règles de validation
     */
    protected function rules(): array
    {
        return [

            'code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('niveaux', 'code')
                    ->ignore($this->niveau->id),
            ],

            'libelle' => [
                'required',
                'string',
                'max:255',
                Rule::unique('niveaux', 'libelle')
                    ->ignore($this->niveau->id),
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
        ];
    }


    /**
     * Modifier le niveau
     */
    public function updateNiveau()
    {
        $this->validate();


        /*
        |--------------------------------------------------------------------------
        | Vérifier l'année scolaire
        |--------------------------------------------------------------------------
        */

        $anneeScolaire = AnneeScolaire::find(
            $this->annee_scolaire_id
        );

        if (!$anneeScolaire) {

            session()->flash(
                'error',
                "L'année scolaire sélectionnée n'existe pas."
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Mise à jour
        |--------------------------------------------------------------------------
        */

        $this->niveau->update([

            'code' => $this->code,

            'libelle' => $this->libelle,

            'montant' => $this->montant,

            'annee_scolaire_id' => $this->annee_scolaire_id,

        ]);


        /*
        |--------------------------------------------------------------------------
        | Message
        |--------------------------------------------------------------------------
        */

        session()->flash(
            'message',
            "Le niveau « {$this->libelle} » a été modifié avec succès !"
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
        return view('niveaux.niveau-edit');
    }
}