<?php

namespace App\Livewire\Periodes;

use App\Models\AnneeScolaire;
use App\Models\Periode;
use Livewire\Component;

class PeriodeEdit extends Component
{
    public $periodeId;

    public $annee_scolaire_id = '';
    public $type = '';
    public $nom = '';
    public $ordre = '';
    public $date_debut = '';
    public $date_fin = '';

    public function mount(Periode $periode)
    {
        $this->periodeId = $periode->id;

        $this->annee_scolaire_id = (string) $periode->annee_scolaire_id;
        $this->type = $periode->type;
        $this->nom = $periode->nom;
        $this->ordre = (string) $periode->ordre;

        $this->date_debut = $periode->date_debut
            ? $periode->date_debut->format('Y-m-d')
            : '';

        $this->date_fin = $periode->date_fin
            ? $periode->date_fin->format('Y-m-d')
            : '';
    }

    protected function rules()
    {
        return [
            'annee_scolaire_id' => [
                'required',
                'exists:annee_scolaires,id',
            ],

            'type' => [
                'required',
                'in:semestre,trimestre',
            ],

            'nom' => [
                'required',
                'string',
                'max:255',
            ],

            'ordre' => [
                'required',
                'integer',
                'min:1',
                'max:3',
            ],

            'date_debut' => [
                'required',
                'date',
            ],

            'date_fin' => [
                'required',
                'date',
                'after_or_equal:date_debut',
            ],
        ];
    }

    protected $messages = [

        'annee_scolaire_id.required' =>
            'Veuillez sélectionner une année scolaire.',

        'annee_scolaire_id.exists' =>
            'Cette année scolaire est invalide.',

        'type.required' =>
            'Veuillez sélectionner le type de période.',

        'type.in' =>
            'Le type sélectionné est invalide.',

        'nom.required' =>
            'Veuillez sélectionner une période.',

        'ordre.required' =>
            'L’ordre de la période est obligatoire.',

        'date_debut.required' =>
            'La date de début est obligatoire.',

        'date_fin.required' =>
            'La date de fin est obligatoire.',

        'date_fin.after_or_equal' =>
            'La date de fin doit être après la date de début.',
    ];


    /*
    |--------------------------------------------------------------------------
    | ANNÉE SCOLAIRE MODIFIÉE
    |--------------------------------------------------------------------------
    */

    public function updatedAnneeScolaireId()
    {
        $this->type = '';
        $this->nom = '';
        $this->ordre = '';

        $this->resetValidation();
    }


    /*
    |--------------------------------------------------------------------------
    | TYPE MODIFIÉ
    |--------------------------------------------------------------------------
    */

    public function updatedType()
    {
        $this->nom = '';
        $this->ordre = '';

        $this->resetValidation();
    }


    /*
    |--------------------------------------------------------------------------
    | PÉRIODES DISPONIBLES
    |--------------------------------------------------------------------------
    */

    public function getPeriodesDisponiblesProperty()
    {
        if (empty($this->annee_scolaire_id) || empty($this->type)) {
            return [];
        }

        /*
        |--------------------------------------------------------------
        | Vérifier si un autre type existe
        |--------------------------------------------------------------
        */

        $autreTypeExiste = Periode::where(
            'annee_scolaire_id',
            $this->annee_scolaire_id
        )
            ->where('id', '!=', $this->periodeId)
            ->where('type', '!=', $this->type)
            ->exists();

        if ($autreTypeExiste) {
            return [];
        }


        /*
        |--------------------------------------------------------------
        | Ordres déjà utilisés sauf cette période
        |--------------------------------------------------------------
        */

        $ordresUtilises = Periode::where(
            'annee_scolaire_id',
            $this->annee_scolaire_id
        )
            ->where('id', '!=', $this->periodeId)
            ->pluck('ordre')
            ->map(function ($ordre) {
                return (int) $ordre;
            })
            ->toArray();


        $periodes = [];


        /*
        |--------------------------------------------------------------
        | SEMESTRES
        |--------------------------------------------------------------
        */

        if ($this->type === 'semestre') {

            if (!in_array(1, $ordresUtilises)) {

                $periodes[] = [
                    'nom' => 'Semestre 1',
                    'ordre' => 1,
                ];

            }

            if (!in_array(2, $ordresUtilises)) {

                $periodes[] = [
                    'nom' => 'Semestre 2',
                    'ordre' => 2,
                ];

            }

        }


        /*
        |--------------------------------------------------------------
        | TRIMESTRES
        |--------------------------------------------------------------
        */

        if ($this->type === 'trimestre') {

            if (!in_array(1, $ordresUtilises)) {

                $periodes[] = [
                    'nom' => 'Trimestre 1',
                    'ordre' => 1,
                ];

            }

            if (!in_array(2, $ordresUtilises)) {

                $periodes[] = [
                    'nom' => 'Trimestre 2',
                    'ordre' => 2,
                ];

            }

            if (!in_array(3, $ordresUtilises)) {

                $periodes[] = [
                    'nom' => 'Trimestre 3',
                    'ordre' => 3,
                ];

            }

        }


        return $periodes;
    }


    /*
    |--------------------------------------------------------------------------
    | NOM MODIFIÉ
    |--------------------------------------------------------------------------
    */

    public function updatedNom()
    {
        $this->ordre = '';

        foreach ($this->periodesDisponibles as $periode) {

            if ($periode['nom'] === $this->nom) {

                $this->ordre = (string) $periode['ordre'];

                break;
            }

        }
    }


    /*
    |--------------------------------------------------------------------------
    | METTRE À JOUR
    |--------------------------------------------------------------------------
    */

    public function update()
    {
        $validated = $this->validate();


        /*
        |--------------------------------------------------------------
        | Vérifier que la période sélectionnée est disponible
        |--------------------------------------------------------------
        */

        $periodeValide = collect(
            $this->periodesDisponibles
        )->first(function ($periode) {

            return $periode['nom'] === $this->nom
                && (string) $periode['ordre'] === (string) $this->ordre;

        });


        if (!$periodeValide) {

            $this->addError(
                'nom',
                'Cette période existe déjà ou n’est pas disponible.'
            );

            return;
        }


        /*
        |--------------------------------------------------------------
        | Vérifier si un autre type existe
        |--------------------------------------------------------------
        */

        $autreTypeExiste = Periode::where(
            'annee_scolaire_id',
            $this->annee_scolaire_id
        )
            ->where('id', '!=', $this->periodeId)
            ->where('type', '!=', $this->type)
            ->exists();


        if ($autreTypeExiste) {

            session()->flash(
                'error',
                'Cette année scolaire utilise déjà un autre type de période.'
            );

            return;

        }


        /*
        |--------------------------------------------------------------
        | MODIFICATION
        |--------------------------------------------------------------
        */

        $periode = Periode::findOrFail(
            $this->periodeId
        );


        $periode->update([

            'annee_scolaire_id' =>
                $validated['annee_scolaire_id'],

            'type' =>
                $validated['type'],

            'nom' =>
                $validated['nom'],

            'ordre' =>
                $validated['ordre'],

            'date_debut' =>
                $validated['date_debut'],

            'date_fin' =>
                $validated['date_fin'],

        ]);


        session()->flash(
            'message',
            'La période scolaire a été modifiée avec succès.'
        );


        return redirect()->route(
            'periodes.index'
        );
    }


    public function render()
    {
        return view(
            'components.periodes.periode-edit',
            [
                'annees' => AnneeScolaire::orderByDesc('id')->get(),
            ]
        );
    }
}