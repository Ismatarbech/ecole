<?php

namespace App\Livewire\Inscriptions;

use App\Models\Eleve;
use App\Models\Classe;
use App\Models\Niveau;
use App\Models\AnneeScolaire;
use App\Models\Paiement;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;


class InscriptionEdit extends Component
{
    use WithFileUploads;

    /*
    |--------------------------------------------------------------------------
    | INFORMATIONS ÉLÈVE
    |--------------------------------------------------------------------------
    */

    public $eleveId;

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
    public $photo_existante;
    public $photo_webcam;
    public $webcamActive = false;

    /*
    |--------------------------------------------------------------------------
    | SCOLARITÉ
    |--------------------------------------------------------------------------
    */

    public $annee_scolaire_id;
    public $niveau_id;
    public $classe_id;

    public $niveaux = [];
    public $annees = [];
    public $classes = [];

    /*
    |--------------------------------------------------------------------------
    | PAIEMENT
    |--------------------------------------------------------------------------
    |
    | montant        = montant de la tranche payée maintenant
    | mode_paiement  = type de paiement
    | date_paiement  = date du paiement
    |
    */

    public $montant = 0;
    public $mode_paiement = 'Especes';
    public $date_paiement;

    /*
    |--------------------------------------------------------------------------
    | SITUATION FINANCIÈRE
    |--------------------------------------------------------------------------
    |
    | montantAnnuel = niveaux.montant
    | totalPaye     = somme des paiements de l'élève pour l'année
    | reste         = montant annuel - total payé
    | estSolde      = true lorsque tout est payé
    |
    */

    public $montantAnnuel = 0;
    public $totalPaye = 0;
    public $reste = 0;
    public $estSolde = false;

    /*
    |--------------------------------------------------------------------------
    | ÉDITION
    |--------------------------------------------------------------------------
    */

    public $editing = null;


    public function deletePaiement($id)
    {
        $paiement = Paiement::findOrFail($id);

        $paiement->delete();

        session()->flash(
            'success',
            'Le paiement a été supprimé avec succès.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | MOUNT
    |--------------------------------------------------------------------------
    */

    public function mount($eleve)
    {
        $e = Eleve::with([
            'classe.niveau',
            'anneeScolaire'
        ])->findOrFail($eleve);

        /*
        |--------------------------------------------------------------------------
        | ID ÉLÈVE
        |--------------------------------------------------------------------------
        */

        $this->eleveId = $e->id;

        /*
        |--------------------------------------------------------------------------
        | INFORMATIONS ÉLÈVE
        |--------------------------------------------------------------------------
        */

        $this->matricule = $e->matricule;
        $this->nom = $e->nom;
        $this->prenom = $e->prenom;
        $this->sexe = $e->sexe;
        $this->tuteur = $e->tuteur;
        $this->contact_tuteur = $e->contact_tuteur;

        $this->naissance = $e->naissance
            ? \Carbon\Carbon::parse($e->naissance)->format('Y-m-d')
            : null;

        $this->lieu = $e->lieu;
        $this->contact_parent = $e->contact_parent;

        $this->date_inscription = $e->date_inscription
        ? \Carbon\Carbon::parse($e->date_inscription)->format('Y-m-d')
        : null;

        /*
        |--------------------------------------------------------------------------
        | PHOTO
        |--------------------------------------------------------------------------
        */

        $this->photo_existante = $e->photo;

        /*
        |--------------------------------------------------------------------------
        | SCOLARITÉ
        |--------------------------------------------------------------------------
        */

        $this->annee_scolaire_id = $e->annee_scolaire_id;
        $this->classe_id = $e->classe_id;

        /*
        |--------------------------------------------------------------------------
        | NIVEAU
        |--------------------------------------------------------------------------
        |
        | Le niveau est récupéré depuis la classe de l'élève.
        |
        */

        $this->niveau_id = optional($e->classe)->niveau_id;

        /*
        |--------------------------------------------------------------------------
        | LISTES
        |--------------------------------------------------------------------------
        */

        $this->niveaux = Niveau::orderBy('libelle')->get();

        $this->annees = AnneeScolaire::where('status', 'active')
        ->orderByDesc('id')
        ->get();

        $this->classes = Classe::where(
            'niveau_id',
            $this->niveau_id
        )
            ->orderBy('name')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | DATE PAIEMENT
        |--------------------------------------------------------------------------
        */

        $this->date_paiement = now()->format('Y-m-d');

        /*
        |--------------------------------------------------------------------------
        | FINANCES
        |--------------------------------------------------------------------------
        */

        $this->recalculerFinances();
    }


    /*
    |--------------------------------------------------------------------------
    | RECALCUL FINANCES
    |--------------------------------------------------------------------------
    */

    public function recalculerFinances()
    {
        /*
        |--------------------------------------------------------------------------
        | 1. RÉCUPÉRER LE NIVEAU
        |--------------------------------------------------------------------------
        |
        | IMPORTANT :
        | Le montant annuel vient directement de niveaux.montant.
        |
        */

        $niveau = Niveau::find($this->niveau_id);

        $this->montantAnnuel = (float) (
            $niveau->montant ?? 0
        );

        /*
        |--------------------------------------------------------------------------
        | 2. TOTAL DES PAIEMENTS
        |--------------------------------------------------------------------------
        |
        | On prend uniquement :
        |
        | - cet élève
        | - cette année scolaire
        |
        */

        $this->totalPaye = (float) Paiement::where(
            'eleve_id',
            $this->eleveId
        )
            ->where(
                'annee_scolaire_id',
                $this->annee_scolaire_id
            )
            ->sum('montant');

        /*
        |--------------------------------------------------------------------------
        | 3. RESTE
        |--------------------------------------------------------------------------
        */

        $this->reste = max(
            0,
            $this->montantAnnuel - $this->totalPaye
        );

        /*
        |--------------------------------------------------------------------------
        | 4. SOLDE
        |--------------------------------------------------------------------------
        */

        $this->estSolde = $this->totalPaye >= $this->montantAnnuel;
    }


    /*
    |--------------------------------------------------------------------------
    | OUVRIR UNE ZONE EN MODIFICATION
    |--------------------------------------------------------------------------
    */

    public function editBlock($block)
    {
        $this->resetErrorBag();

        $this->editing = $block;
    }


    /*
    |--------------------------------------------------------------------------
    | ANNULER
    |--------------------------------------------------------------------------
    */

    public function cancel()
    {
        $this->resetErrorBag();

        $this->editing = null;

        $this->photo = null;
        $this->photo_webcam = null;
        $this->webcamActive = false;

        /*
        | Recharger les données originales.
        */

        $this->mount($this->eleveId);
    }


    /*
    |--------------------------------------------------------------------------
    | CHANGEMENT DE NIVEAU
    |--------------------------------------------------------------------------
    */

    public function updatedNiveauId()
    {
        $this->classes = Classe::where(
            'niveau_id',
            $this->niveau_id
        )
            ->orderBy('name')
            ->get();

        /*
        | Lorsque le niveau change,
        | l'ancienne classe ne correspond plus forcément.
        */

        $this->classe_id = null;

        /*
        | Le montant annuel vient du nouveau niveau.
        */

        $this->recalculerFinances();
    }


    /*
    |--------------------------------------------------------------------------
    | CHANGEMENT ANNÉE SCOLAIRE
    |--------------------------------------------------------------------------
    */

    public function updatedAnneeScolaireId()
    {
        $this->recalculerFinances();
    }


    /*
    |--------------------------------------------------------------------------
    | WEBCAM
    |--------------------------------------------------------------------------
    */

    public function startWebcam()
    {
        $this->resetErrorBag();

        $this->webcamActive = true;
    }


    /*
    |--------------------------------------------------------------------------
    | ARRÊTER WEBCAM
    |--------------------------------------------------------------------------
    */

    public function stopWebcam()
    {
        $this->webcamActive = false;
    }


    /*
    |--------------------------------------------------------------------------
    | CAPTURE WEBCAM
    |--------------------------------------------------------------------------
    */

    public function captureWebcam($image)
    {
        $this->resetErrorBag();

        /*
        | L'image arrive sous forme :
        |
        | data:image/jpeg;base64,...
        |
        */

        if (!$image) {
            $this->addError(
                'photo_webcam',
                'Impossible de récupérer la photo.'
            );

            return;
        }

        $this->photo_webcam = $image;

        $this->webcamActive = false;
    }


    /*
    |--------------------------------------------------------------------------
    | ENREGISTRER PHOTO
    |--------------------------------------------------------------------------
    */

    public function savePhoto()
    {
        $this->validate([
            'photo' => 'nullable|image|max:4096',
        ]);

        $eleve = Eleve::findOrFail($this->eleveId);

        $path = $this->photo_existante;

        /*
        |--------------------------------------------------------------------------
        | PHOTO PAR FICHIER
        |--------------------------------------------------------------------------
        */

        if ($this->photo) {

            /*
            | Supprimer ancienne photo
            */

            if (
                $path &&
                Storage::disk('public')->exists($path)
            ) {
                Storage::disk('public')->delete($path);
            }

            $path = $this->photo->store(
                'eleves/photos',
                'public'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | PHOTO PAR WEBCAM
        |--------------------------------------------------------------------------
        */

        elseif ($this->photo_webcam) {

            /*
            | Supprimer ancienne photo
            */

            if (
                $path &&
                Storage::disk('public')->exists($path)
            ) {
                Storage::disk('public')->delete($path);
            }

            /*
            | Extraire le contenu base64
            */

            $image = $this->photo_webcam;

            if (str_contains($image, ',')) {
                $image = explode(',', $image, 2)[1];
            }

            $image = base64_decode($image);

            /*
            | Nom du fichier
            */

            $filename = 'eleve_' .
                $this->eleveId .
                '_' .
                time() .
                '.jpg';

            $path = 'eleves/photos/' . $filename;

            Storage::disk('public')->put(
                $path,
                $image
            );
        }

        /*
        |--------------------------------------------------------------------------
        | SAUVEGARDE
        |--------------------------------------------------------------------------
        */

        $eleve->update([
            'photo' => $path
        ]);

        /*
        |--------------------------------------------------------------------------
        | RAFRAÎCHIR
        |--------------------------------------------------------------------------
        */

        $this->photo_existante = $path;

        $this->photo = null;
        $this->photo_webcam = null;
        $this->webcamActive = false;
        $this->editing = null;

        session()->flash(
            'success',
            'Photo mise à jour avec succès.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | MODIFIER INFORMATIONS ÉLÈVE
    |--------------------------------------------------------------------------
    */

    public function saveEleve()
    {
        $this->validate([
            'nom' => 'required|string|max:100',

            'prenom' => 'required|string|max:100',

            'sexe' => 'required|in:M,F',

            'naissance' => 'required|date',

            'lieu' => 'nullable|string|max:100',

            'contact_parent' => 'nullable|string|max:30',

            'tuteur' => 'required|string|max:100',

            'contact_tuteur' => 'nullable|string|max:30',
        ]);

        Eleve::findOrFail(
            $this->eleveId
        )->update([

            'nom' => $this->nom,

            'prenom' => $this->prenom,

            'sexe' => $this->sexe,

            'naissance' => $this->naissance,

            'lieu' => $this->lieu,

            'tuteur' => $this->tuteur,

            'contact_tuteur' => $this->contact_tuteur,


            'contact_parent' => $this->contact_parent,
        ]);

        $this->editing = null;

        session()->flash(
            'success',
            'Informations élève mises à jour.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | MODIFIER SCOLARITÉ
    |--------------------------------------------------------------------------
    */

    public function saveScolarite()
    {
        $this->validate([
            'annee_scolaire_id' =>
                'required|exists:annee_scolaires,id',

            'niveau_id' =>
                'required|exists:niveaux,id',

            'classe_id' =>
                'required|exists:classes,id',
        ]);

        /*
        | Vérifier que la classe appartient bien au niveau.
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
        | Mise à jour de l'élève
        */

        Eleve::findOrFail(
            $this->eleveId
        )->update([

            'annee_scolaire_id' =>
                $this->annee_scolaire_id,

            'classe_id' =>
                $this->classe_id,
        ]);

        /*
        | Recalcul financier
        */

        $this->recalculerFinances();

        $this->editing = null;

        session()->flash(
            'success',
            'Scolarité mise à jour avec succès.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ENREGISTRER UN PAIEMENT
    |--------------------------------------------------------------------------
    */

    public function savePaiement()
    {
        $this->validate([
            'montant' =>
                'required|numeric|min:1',

            'mode_paiement' =>
                'required|string|max:100',

            'date_paiement' =>
                'required|date',
        ]);

        /*
        |--------------------------------------------------------------------------
        | RECALCULER AVANT DE SAUVEGARDER
        |--------------------------------------------------------------------------
        |
        | Cela évite de travailler avec une ancienne valeur.
        |
        */

        $this->recalculerFinances();

        /*
        |--------------------------------------------------------------------------
        | VÉRIFIER SI DÉJÀ SOLDÉ
        |--------------------------------------------------------------------------
        */

        if ($this->reste <= 0) {

            $this->addError(
                'montant',
                'Cette scolarité est déjà totalement soldée.'
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | NE PAS DÉPASSER LE RESTE
        |--------------------------------------------------------------------------
        */

        if ((float) $this->montant > $this->reste) {

            $this->addError(
                'montant',
                'Le montant dépasse le reste à payer : ' .
                number_format(
                    $this->reste,
                    0,
                    ',',
                    ' '
                ) .
                ' FCFA.'
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | VÉRIFIER LA CLASSE
        |--------------------------------------------------------------------------
        */

        if (!$this->classe_id) {

            $this->addError(
                'montant',
                'La classe de l’élève est obligatoire.'
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | ENREGISTRER LE PAIEMENT
        |--------------------------------------------------------------------------
        */

        Paiement::create([

            'eleve_id' =>
                $this->eleveId,

            'annee_scolaire_id' =>
                $this->annee_scolaire_id,

            'classe_id' =>
                $this->classe_id,

            'montant' =>
                (int) $this->montant,

            'mode_paiement' =>
                $this->mode_paiement,

            'date_paiement' =>
                $this->date_paiement,
        ]);

        /*
        |--------------------------------------------------------------------------
        | RÉINITIALISER LE FORMULAIRE
        |--------------------------------------------------------------------------
        */

        $this->montant = 0;

        $this->date_paiement =
            now()->format('Y-m-d');

        /*
        | Recalculer après paiement
        */

        $this->recalculerFinances();

        $this->editing = null;

        session()->flash(
            'success',
            'Tranche de paiement enregistrée avec succès.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | RENDER
    |--------------------------------------------------------------------------
    */

    public function render()
    {
        $eleve = Eleve::with([
            'classe.niveau',
            'anneeScolaire'
        ])->find($this->eleveId);

        /*
        | Historique uniquement pour l'année actuelle.
        */

        $paiements = Paiement::where(
            'eleve_id',
            $this->eleveId
        )
            ->where(
                'annee_scolaire_id',
                $this->annee_scolaire_id
            )
            ->orderByDesc('date_paiement')
            ->orderByDesc('created_at')
            ->get();

        return view(
            'inscriptions.inscription-edit',
            [
                'eleve' => $eleve,

                'paiements' => $paiements,
            ]
        )->layout('layouts.app');
    }
}