<?php

namespace App\Livewire\Notes;

use Livewire\Component;
use App\Models\Note;
use App\Models\Eleve;
use App\Models\Matiere;
use App\Models\Classe;
use App\Models\Periode;
use App\Models\AnneeScolaire;
use Illuminate\Support\Facades\DB;

class NoteCreate extends Component
{
    public $periode_id = '';
    public $classe_id = '';
    public $matiere_id = '';

    public $notes = [];

    /*
    |--------------------------------------------------------------------------
    | NOTES DÉJÀ ENREGISTRÉES
    |--------------------------------------------------------------------------
    */

    public array $notesEnregistrees = [];


    /*
    |--------------------------------------------------------------------------
    | CHANGEMENT DE CLASSE
    |--------------------------------------------------------------------------
    */

    public function updatedClasseId()
    {
        $this->matiere_id = '';
        $this->notes = [];
        $this->notesEnregistrees = [];

        $this->resetValidation();

        if (!$this->classe_id) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | VÉRIFIER L'ANNÉE SCOLAIRE
        |--------------------------------------------------------------------------
        */

        $anneeActive = AnneeScolaire::where('status', 'active')->first();

        if (!$anneeActive) {

            $this->classe_id = '';

            $this->addError(
                'classe_id',
                "L'année scolaire est fermée. Impossible de saisir une note."
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | VÉRIFIER L'AUTORISATION
        |--------------------------------------------------------------------------
        */

        $classeAutorisee = DB::table('classe_user')
            ->where('user_id', auth()->id())
            ->where('classe_id', $this->classe_id)
            ->exists();

        if (!$classeAutorisee) {

            $this->classe_id = '';

            $this->addError(
                'classe_id',
                "Vous n'êtes pas autorisé à saisir les notes de cette classe."
            );

            return;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | CHANGEMENT DE MATIÈRE
    |--------------------------------------------------------------------------
    */

    public function updatedMatiereId()
    {
        $this->notes = [];
        $this->notesEnregistrees = [];

        $this->resetValidation();

        if (!$this->matiere_id || !$this->classe_id) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | VÉRIFIER L'ANNÉE
        |--------------------------------------------------------------------------
        */

        $anneeActive = AnneeScolaire::where('status', 'active')->first();

        if (!$anneeActive) {

            $this->matiere_id = '';

            $this->addError(
                'matiere_id',
                "L'année scolaire est fermée. Impossible de saisir une note."
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | VÉRIFIER L'AUTORISATION
        |--------------------------------------------------------------------------
        */

        $autorise = DB::table('classe_user')
            ->where('user_id', auth()->id())
            ->where('classe_id', $this->classe_id)
            ->where('matiere_id', $this->matiere_id)
            ->exists();

        if (!$autorise) {

            $this->matiere_id = '';

            $this->addError(
                'matiere_id',
                "Vous n'êtes pas autorisé à saisir cette matière pour cette classe."
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | CHARGER LES NOTES
        |--------------------------------------------------------------------------
        */

        $this->chargerNotes();
    }


    /*
    |--------------------------------------------------------------------------
    | CHANGEMENT DE PÉRIODE
    |--------------------------------------------------------------------------
    */

    public function updatedPeriodeId()
    {
        $this->notes = [];
        $this->notesEnregistrees = [];

        $this->resetValidation();

        if (!$this->periode_id) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | ANNÉE ACTIVE
        |--------------------------------------------------------------------------
        */

        $anneeActive = AnneeScolaire::where('status', 'active')->first();

        if (!$anneeActive) {

            $this->periode_id = '';

            $this->addError(
                'periode_id',
                "L'année scolaire est fermée. Impossible de sélectionner une période."
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | PÉRIODE DE L'ANNÉE ACTIVE
        |--------------------------------------------------------------------------
        */

        $periode = Periode::where('id', $this->periode_id)
            ->where('annee_scolaire_id', $anneeActive->id)
            ->first();

        if (!$periode) {

            $this->periode_id = '';

            $this->addError(
                'periode_id',
                "Cette période n'appartient pas à l'année scolaire active."
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | PÉRIODE OUVERTE ?
        |--------------------------------------------------------------------------
        */

        if (!$periode->isOpen()) {

            $this->notes = [];
            $this->notesEnregistrees = [];

            $this->addError(
                'periode_id',
                "Cette période est fermée. Impossible de saisir une note."
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | CHARGER
        |--------------------------------------------------------------------------
        */

        $this->chargerNotes();
    }


    /*
    |--------------------------------------------------------------------------
    | CHARGER LES NOTES
    |--------------------------------------------------------------------------
    */

    public function chargerNotes()
    {
        if (
            !$this->classe_id ||
            !$this->matiere_id ||
            !$this->periode_id
        ) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | ANNÉE ACTIVE
        |--------------------------------------------------------------------------
        */

        $anneeActive = AnneeScolaire::where('status', 'active')->first();

        if (!$anneeActive) {

            $this->notes = [];
            $this->notesEnregistrees = [];

            $this->addError(
                'general',
                "L'année scolaire est fermée. Impossible de charger les notes."
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | PÉRIODE
        |--------------------------------------------------------------------------
        */

        $periode = Periode::where('id', $this->periode_id)
            ->where('annee_scolaire_id', $anneeActive->id)
            ->first();

        if (!$periode) {

            $this->notes = [];
            $this->notesEnregistrees = [];

            $this->addError(
                'periode_id',
                "Cette période n'appartient pas à l'année scolaire active."
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | PÉRIODE FERMÉE
        |--------------------------------------------------------------------------
        */

        if (!$periode->isOpen()) {

            $this->notes = [];
            $this->notesEnregistrees = [];

            $this->addError(
                'periode_id',
                "Cette période est fermée. Impossible de saisir une note."
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | AUTORISATION ENSEIGNANT
        |--------------------------------------------------------------------------
        */

        $autorise = DB::table('classe_user')
            ->where('user_id', auth()->id())
            ->where('classe_id', $this->classe_id)
            ->where('matiere_id', $this->matiere_id)
            ->exists();

        if (!$autorise) {

            $this->notes = [];
            $this->notesEnregistrees = [];

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | ÉLÈVES
        |--------------------------------------------------------------------------
        */

        $eleves = Eleve::where(
            'classe_id',
            $this->classe_id
        )
            ->orderBy('matricule')
            ->get();


        $this->notes = [];

        $this->notesEnregistrees = [];


        /*
        |--------------------------------------------------------------------------
        | NOTES EXISTANTES
        |--------------------------------------------------------------------------
        */

        foreach ($eleves as $eleve) {

            $note = Note::where('eleve_id', $eleve->id)
                ->where('matiere_id', $this->matiere_id)
                ->where('periode_id', $this->periode_id)
                ->first();


            if ($note) {

                $this->notesEnregistrees[] = $eleve->id;

                $this->notes[$eleve->id] = [

                    'devoir' => $note->devoir,

                    'composition' => $note->composition,

                    'moyenne' => $note->moyenne,

                    'appreciation' => $note->appreciation,

                    'modification_autorisee' =>
                        (bool) $note->modification_autorisee,
                ];

            } else {

                $this->notes[$eleve->id] = [

                    'devoir' => '',

                    'composition' => '',

                    'moyenne' => '',

                    'appreciation' => '',

                    'modification_autorisee' => false,
                ];
            }
        }
    }


    /*
    |--------------------------------------------------------------------------
    | CALCUL MOYENNE
    |--------------------------------------------------------------------------
    */

    public function updatedNotes($value, $key)
    {
        $parts = explode('.', $key);

        if (count($parts) !== 3) {
            return;
        }

        $eleveId = (int) $parts[1];


        /*
        |--------------------------------------------------------------------------
        | ANNÉE ACTIVE
        |--------------------------------------------------------------------------
        */

        $anneeActive = AnneeScolaire::where('status', 'active')->first();

        if (!$anneeActive) {

            $this->notes = [];

            $this->addError(
                'general',
                "L'année scolaire est fermée. Les notes ne peuvent pas être modifiées."
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | PÉRIODE OUVERTE
        |--------------------------------------------------------------------------
        */

        if ($this->periode_id) {

            $periode = Periode::where('id', $this->periode_id)
                ->where('annee_scolaire_id', $anneeActive->id)
                ->first();

            if (!$periode || !$periode->isOpen()) {

                $this->notes = [];

                $this->addError(
                    'periode_id',
                    "Cette période est fermée. Les notes ne peuvent pas être modifiées."
                );

                return;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | NOTE EXISTANTE
        |--------------------------------------------------------------------------
        */

        if (in_array($eleveId, $this->notesEnregistrees)) {

            $note = Note::where('eleve_id', $eleveId)
                ->where('matiere_id', $this->matiere_id)
                ->where('periode_id', $this->periode_id)
                ->first();

            if (!$note) {
                return;
            }


            if (!$note->modification_autorisee) {

                $this->notes[$eleveId] = [

                    'devoir' => $note->devoir,

                    'composition' => $note->composition,

                    'moyenne' => $note->moyenne,

                    'appreciation' => $note->appreciation,

                    'modification_autorisee' => false,
                ];

                return;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | CALCUL
        |--------------------------------------------------------------------------
        */

        $devoir = $this->notes[$eleveId]['devoir'] ?? null;

        $composition = $this->notes[$eleveId]['composition'] ?? null;


        if (
            $devoir !== '' &&
            $devoir !== null &&
            $composition !== '' &&
            $composition !== null
        ) {

            $devoir = (float) $devoir;

            $composition = (float) $composition;


            $moyenne = round(
                ($devoir + $composition) / 2,
                2
            );


            $this->notes[$eleveId]['moyenne'] = $moyenne;


            if ($moyenne >= 16) {

                $appreciation = 'Très bien';

            } elseif ($moyenne >= 14) {

                $appreciation = 'Bien';

            } elseif ($moyenne >= 12) {

                $appreciation = 'Assez bien';

            } elseif ($moyenne >= 10) {

                $appreciation = 'Passable';

            } elseif ($moyenne >= 8) {

                $appreciation = 'Insuffisant';

            } else {

                $appreciation = 'Très insuffisant';
            }


            $this->notes[$eleveId]['appreciation'] =
                $appreciation;

        } else {

            $this->notes[$eleveId]['moyenne'] = '';

            $this->notes[$eleveId]['appreciation'] = '';
        }
    }


    /*
    |--------------------------------------------------------------------------
    | ENREGISTRER
    |--------------------------------------------------------------------------
    */

    public function save()
    {
        /*
        |--------------------------------------------------------------------------
        | 1. ANNÉE SCOLAIRE
        |--------------------------------------------------------------------------
        */

        $anneeActive = AnneeScolaire::where(
            'status',
            'active'
        )->first();

        if (!$anneeActive) {

            $this->addError(
                'general',
                "L'année scolaire est fermée. Impossible de créer ou modifier une note."
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | 2. VALIDATION
        |--------------------------------------------------------------------------
        */

        $this->validate([

            'periode_id' => [
                'required',
                'exists:periodes,id',
            ],

            'classe_id' => [
                'required',
                'exists:classes,id',
            ],

            'matiere_id' => [
                'required',
                'exists:matieres,id',
            ],

            'notes' => [
                'required',
                'array',
            ],

            'notes.*.devoir' => [
                'nullable',
                'numeric',
                'min:0',
                'max:20',
            ],

            'notes.*.composition' => [
                'nullable',
                'numeric',
                'min:0',
                'max:20',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | 3. PÉRIODE
        |--------------------------------------------------------------------------
        */

        $periode = Periode::with('anneeScolaire')
            ->where('id', $this->periode_id)
            ->where(
                'annee_scolaire_id',
                $anneeActive->id
            )
            ->first();


        if (!$periode) {

            $this->addError(
                'periode_id',
                "Cette période n'appartient pas à l'année scolaire active."
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | 4. PÉRIODE FERMÉE
        |--------------------------------------------------------------------------
        */

        if (!$periode->isOpen()) {

            $this->addError(
                'periode_id',
                "Cette période est fermée. Impossible de créer ou modifier une note."
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | 5. AUTORISATION ENSEIGNANT
        |--------------------------------------------------------------------------
        */

        $autorise = DB::table('classe_user')
            ->where('user_id', auth()->id())
            ->where('classe_id', $this->classe_id)
            ->where('matiere_id', $this->matiere_id)
            ->exists();


        if (!$autorise) {

            $this->addError(
                'classe_id',
                "Vous n'êtes pas autorisé à saisir cette matière dans cette classe."
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | 6. CLASSE
        |--------------------------------------------------------------------------
        */

        $classe = Classe::find(
            $this->classe_id
        );


        if (!$classe) {

            $this->addError(
                'classe_id',
                'Classe introuvable.'
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | 7. MATIÈRE
        |--------------------------------------------------------------------------
        */

        $matiere = Matiere::where(
            'id',
            $this->matiere_id
        )
            ->where(
                'niveau_id',
                $classe->niveau_id
            )
            ->first();


        if (!$matiere) {

            $this->addError(
                'matiere_id',
                'Cette matière ne correspond pas au niveau de cette classe.'
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | 8. ENREGISTREMENT
        |--------------------------------------------------------------------------
        */

        try {

            DB::transaction(function () {

                foreach ($this->notes as $eleveId => $data) {

                    /*
                    |--------------------------------------------------------------------------
                    | ÉLÈVE
                    |--------------------------------------------------------------------------
                    */

                    $eleve = Eleve::where(
                        'id',
                        $eleveId
                    )
                        ->where(
                            'classe_id',
                            $this->classe_id
                        )
                        ->first();


                    if (!$eleve) {
                        continue;
                    }


                    $devoir = $data['devoir'] ?? null;

                    $composition = $data['composition'] ?? null;


                    /*
                    |--------------------------------------------------------------------------
                    | AUCUNE NOTE
                    |--------------------------------------------------------------------------
                    */

                    if (
                        ($devoir === null || $devoir === '') &&
                        ($composition === null || $composition === '')
                    ) {
                        continue;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | NOTE EXISTANTE
                    |--------------------------------------------------------------------------
                    */

                    $noteExistante = Note::where(
                        'eleve_id',
                        $eleveId
                    )
                        ->where(
                            'matiere_id',
                            $this->matiere_id
                        )
                        ->where(
                            'periode_id',
                            $this->periode_id
                        )
                        ->first();


                    /*
                    |--------------------------------------------------------------------------
                    | MODIFICATION
                    |--------------------------------------------------------------------------
                    */

                    if ($noteExistante) {

                        /*
                        | Note verrouillée
                        */

                        if (!$noteExistante->modification_autorisee) {
                            continue;
                        }


                        $moyenne = null;

                        $appreciation = null;


                        if (
                            $devoir !== null &&
                            $devoir !== '' &&
                            $composition !== null &&
                            $composition !== ''
                        ) {

                            $moyenne = round(
                                (
                                    (float) $devoir +
                                    (float) $composition
                                ) / 2,
                                2
                            );


                            if ($moyenne >= 18) {

                                $appreciation = 'Excellence';

                            } elseif ($moyenne >= 16) {

                                $appreciation = 'Tres bien';

                            } elseif ($moyenne >= 14) {

                                $appreciation = 'Bien';

                            } elseif ($moyenne >= 12) {

                                $appreciation = 'Assez bien';

                            } elseif ($moyenne >= 11) {

                                $appreciation = 'Passable';

                             } elseif ($moyenne >= 10) {

                                $appreciation = 'Moyenne';

                            } elseif ($moyenne >= 8) {

                                $appreciation = 'Insuffisant';

                            } else {

                                $appreciation = 'Très insuffisant';
                            }
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | MODIFIER PUIS VERROUILLER
                        |--------------------------------------------------------------------------
                        */

                        $noteExistante->update([

                            'devoir' => $devoir,

                            'composition' => $composition,

                            'moyenne' => $moyenne,

                            'appreciation' => $appreciation,

                            'modification_autorisee' => false,

                        ]);


                        continue;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | NOUVELLE NOTE
                    |--------------------------------------------------------------------------
                    */

                    $moyenne = null;

                    $appreciation = null;


                    if (
                        $devoir !== null &&
                        $devoir !== '' &&
                        $composition !== null &&
                        $composition !== ''
                    ) {

                        $moyenne = round(
                            (
                                (float) $devoir +
                                (float) $composition
                            ) / 2,
                            2
                        );


                        if ($moyenne >= 18) {

                            $appreciation = 'Excellente';

                        } elseif ($moyenne >= 16) {

                            $appreciation = 'Tres bien';

                        } elseif ($moyenne >= 14) {

                            $appreciation = 'Bien';

                        } elseif ($moyenne >= 12) {

                            $appreciation = 'Assez bien';

                        } elseif ($moyenne >= 11) {

                            $appreciation = 'Passable';

                        } elseif ($moyenne >= 10) {

                            $appreciation = 'Moyenne';

                        } elseif ($moyenne >= 9) {

                            $appreciation = 'Insuffisant';

                        } else {

                            $appreciation = 'Très insuffisant';
                        }
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | CRÉER
                    |--------------------------------------------------------------------------
                    */

                    Note::create([

                        'eleve_id' => $eleveId,

                        'matiere_id' => $this->matiere_id,

                        'enseignant_id' => auth()->id(),

                        'periode_id' => $this->periode_id,

                        'devoir' => $devoir,

                        'composition' => $composition,

                        'moyenne' => $moyenne,

                        'appreciation' => $appreciation,

                        'modification_autorisee' => false,

                    ]);
                }
            });


            /*
            |--------------------------------------------------------------------------
            | SUCCÈS
            |--------------------------------------------------------------------------
            */

            session()->flash(
                'success',
                'Les notes ont été enregistrées avec succès. Elles sont maintenant verrouillées.'
            );


            $this->chargerNotes();

        } catch (\Throwable $e) {

            report($e);

            $this->addError(
                'general',
                'Les notes n’ont pas pu être enregistrées. Veuillez réessayer.'
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | SUPER ADMIN — AUTORISER MODIFICATION
    |--------------------------------------------------------------------------
    */

    public function autoriserModification($noteId)
    {
        if (!auth()->user()->hasRole('super_admin')) {
            abort(403);
        }


        $note = Note::find($noteId);


        if (!$note) {

            session()->flash(
                'error',
                'Note introuvable.'
            );

            return;
        }


        $note->update([

            'modification_autorisee' => true,

        ]);


        session()->flash(
            'success',
            'La modification de cette note est maintenant autorisée.'
        );


        $this->chargerNotes();
    }


    /*
    |--------------------------------------------------------------------------
    | SUPER ADMIN — VERROUILLER
    |--------------------------------------------------------------------------
    */

    public function verrouillerModification($noteId)
    {
        if (!auth()->user()->hasRole('super_admin')) {
            abort(403);
        }


        $note = Note::find($noteId);


        if (!$note) {

            session()->flash(
                'error',
                'Note introuvable.'
            );

            return;
        }


        $note->update([

            'modification_autorisee' => false,

        ]);


        session()->flash(
            'success',
            'La note a été verrouillée.'
        );


        $this->chargerNotes();
    }


    /*
    |--------------------------------------------------------------------------
    | RENDER
    |--------------------------------------------------------------------------
    */

    public function render()
    {
        /*
        |--------------------------------------------------------------------------
        | ANNÉE SCOLAIRE ACTIVE
        |--------------------------------------------------------------------------
        */

        $anneeActive = AnneeScolaire::where(
            'status',
            'active'
        )->first();


        /*
        |--------------------------------------------------------------------------
        | PÉRIODES
        |--------------------------------------------------------------------------
        |
        | IMPORTANT :
        | PAS DE where('status', 'active')
        | car periodes n'a pas de colonne status.
        |
        | On affiche toutes les périodes de l'année active.
        | Leur ouverture dépend de date_debut/date_fin.
        |
        */

        $periodes = collect();


        if ($anneeActive) {

            $periodes = Periode::with(
                'anneeScolaire'
            )
                ->where(
                    'annee_scolaire_id',
                    $anneeActive->id
                )
                ->orderBy('id')
                ->get();
        }


        /*
        |--------------------------------------------------------------------------
        | CLASSES DE L'ENSEIGNANT
        |--------------------------------------------------------------------------
        */

        $classes = Classe::with('niveau')
            ->whereIn(
                'id',
                DB::table('classe_user')
                    ->where(
                        'user_id',
                        auth()->id()
                    )
                    ->pluck('classe_id')
            )
            ->orderBy('name')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | ÉLÈVES
        |--------------------------------------------------------------------------
        */

        $eleves = collect();


        if ($this->classe_id) {

            $classeAutorisee = DB::table('classe_user')
                ->where(
                    'user_id',
                    auth()->id()
                )
                ->where(
                    'classe_id',
                    $this->classe_id
                )
                ->exists();


            if ($classeAutorisee) {

                $eleves = Eleve::where(
                    'classe_id',
                    $this->classe_id
                )
                    ->orderBy('matricule')
                    ->get();
            }
        }


        /*
        |--------------------------------------------------------------------------
        | MATIÈRES
        |--------------------------------------------------------------------------
        */

        $matieres = collect();


        if ($this->classe_id) {

            $matiereIds = DB::table('classe_user')

                ->where(
                    'user_id',
                    auth()->id()
                )

                ->where(
                    'classe_id',
                    $this->classe_id
                )

                ->pluck('matiere_id');


            $matieres = Matiere::with('niveau')

                ->whereIn(
                    'id',
                    $matiereIds
                )

                ->orderBy('nom')

                ->get();
        }


        /*
        |--------------------------------------------------------------------------
        | VUE
        |--------------------------------------------------------------------------
        */

        return view(
            'notes.note-create',
            [

                'anneeActive' => $anneeActive,

                'periodes' => $periodes,

                'classes' => $classes,

                'eleves' => $eleves,

                'matieres' => $matieres,

            ]
        );
    }
}