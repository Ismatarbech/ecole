<?php

namespace App\Livewire\Corbeilles;

use Livewire\Component;

use App\Models\Etablissement;
use App\Models\AnneeScolaire;
use App\Models\Niveau;
use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Matiere;
use App\Models\Note;
use App\Models\Periode;
use App\Models\User;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CorbeilleIndex extends Component
{
    public string $tab = 'etablissements';

    // ======================
    // DATA TRASH
    // ======================

    public function getEtablissementsProperty()
    {
        return Etablissement::onlyTrashed()->get();
    }

    public function getUsersProperty()
    {
        return User::onlyTrashed()->get();
    }

    public function getAnneesProperty()
    {
        return AnneeScolaire::onlyTrashed()->get();
    }

    public function getNiveauxProperty()
    {
        return Niveau::onlyTrashed()->get();
    }

    public function getClassesProperty()
    {
        return Classe::onlyTrashed()->get();
    }

    public function getElevesProperty()
    {
        return Eleve::onlyTrashed()->get();
    }

    public function getMatieresProperty()
    {
        return Matiere::onlyTrashed()->get();
    }

    public function getNotesProperty()
    {
        return Note::onlyTrashed()->get();
    }

    public function getPeriodesProperty()
    {
        return Periode::onlyTrashed()->get();
    }

    public function getRolesProperty()
    {
        return Role::where('active', false)->get();
    }

    public function getPermissionsProperty()
    {
        return Permission::where('active', false)->get();
    }

    // ======================
    // RESTORE
    // ======================

     public function restoreUser($id)
    {
        User::onlyTrashed()->findOrFail($id)->restore();
    }

    public function restoreEleve($id)
    {
        Eleve::onlyTrashed()->findOrFail($id)->restore();
    }

    public function restoreNote($id)
    {
        Note::onlyTrashed()->findOrFail($id)->restore();
    }

    public function restoreMatiere($id)
    {
        Matiere::onlyTrashed()->findOrFail($id)->restore();
    }

    public function restoreClasse($id)
    {
        Classe::onlyTrashed()->findOrFail($id)->restore();
    }

    public function restoreEtablissement($id)
    {
        Etablissement::onlyTrashed()->findOrFail($id)->restore();
    }

    public function restoreAnnee($id)
    {
        AnneeScolaire::onlyTrashed()->findOrFail($id)->restore();
    }

    public function restoreNiveau($id)
    {
        Niveau::onlyTrashed()->findOrFail($id)->restore();
    }

    public function restorePeriode($id)
    {
        Periode::onlyTrashed()->findOrFail($id)->restore();
    }

    public function restoreRole($id)
    {
        Role::where('id', $id)->update(['active' => true]);
    }

    public function restorePermission($id)
    {
        Permission::where('id', $id)->update(['active' => true]);
    }

    // ======================
    // FORCE DELETE
    // ======================

    public function deleteUser($id)
    {
        User::onlyTrashed()->findOrFail($id)->forceDelete();
    }

    public function deleteEleve($id)
    {
        Eleve::onlyTrashed()->findOrFail($id)->forceDelete();
    }

    public function deleteNote($id)
    {
        Note::onlyTrashed()->findOrFail($id)->forceDelete();
    }

    public function deleteMatiere($id)
    {
        Matiere::onlyTrashed()->findOrFail($id)->forceDelete();
    }

    public function deleteClasse($id)
    {
        Classe::onlyTrashed()->findOrFail($id)->forceDelete();
    }

    public function deleteEtablissement($id)
    {
        Etablissement::onlyTrashed()->findOrFail($id)->forceDelete();
    }

    public function deleteAnnee($id)
    {
        AnneeScolaire::onlyTrashed()->findOrFail($id)->forceDelete();
    }

    public function deleteNiveau($id)
    {
        Niveau::onlyTrashed()->findOrFail($id)->forceDelete();
    }

    public function deletePeriode($id)
    {
        Periode::onlyTrashed()->findOrFail($id)->forceDelete();
    }

    public function render()
    {
        return view('corbeilles.corbeille-index');
    }
}