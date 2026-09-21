<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class RoleIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public string $successMessage = '';
    public string $errorMessage = '';

    protected $paginationTheme = 'bootstrap';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function toggleStatus($id)
    {
        
        try {
            $role = Role::findOrFail($id);
            if ($role->name === 'super-admin') {
        $this->errorMessage = "Le rôle super-admin est protégé.";
        return;
    }

            $role->update([
                'active' => !$role->active
            ]);

            $this->successMessage = $role->active
                ? "Rôle activé"
                : "Rôle désactivé";

        } catch (\Exception $e) {
            $this->errorMessage = "Rôle introuvable.";
        }
    }

    public function deleteRole($id)
    {
        try {
            $role = Role::findOrFail($id);
             if ($role->name === 'super-admin') {
        $this->errorMessage = "Impossible de supprimer le super-admin.";
        return;
    }


            $role->delete();

            $this->successMessage = "Rôle supprimé avec succès";

        } catch (\Exception $e) {
            $this->errorMessage = "Rôle introuvable.";
        }
    }

    public function render()
    {
        $roles = Role::query()

            ->when($this->search, function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            })

            // 🔐 LOGIQUE DE VISIBILITÉ
            ->when(!auth()->user()->hasRole('super-admin'), function ($q) {
                $q->where('name', '!=', 'super-admin');
            })

            ->orderBy('id', 'asc')
            ->paginate(10);

        return view('roles.role-index', [
            'roles' => $roles
        ]);
    }
}