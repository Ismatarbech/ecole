<?php

namespace App\Livewire\Permissions;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

class PermissionIndex extends Component
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

    // 🔥 ACTIVER / DÉSACTIVER
    public function toggleStatus($id)
    {
        try {
            $permission = Permission::findOrFail($id);

            $permission->update([
                'active' => !$permission->active
            ]);

            $this->errorMessage = '';

            $this->successMessage = $permission->active
                ? "Permission activée"
                : "Permission désactivée";

        } catch (\Exception $e) {
            $this->successMessage = '';
            $this->errorMessage = "Permission introuvable.";
        }
    }

    // 🗑 DELETE
    public function deletePermission($id)
    {
        try {
            $permission = Permission::findOrFail($id);

            $permission->delete();

            $this->errorMessage = '';
            $this->successMessage = "Permission supprimée avec succès";

        } catch (\Exception $e) {
            $this->successMessage = '';
            $this->errorMessage = "Permission introuvable.";
        }
    }

    public function render()
    {
        $permissions = Permission::query()
            ->when($this->search, function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id', 'asc')
            ->paginate(10);

        return view('permissions.permission-index', [
            'permissions' => $permissions
        ]);
    }
}