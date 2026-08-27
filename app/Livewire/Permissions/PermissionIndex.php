<?php
 
namespace App\Livewire\Permissions;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Livewire\WithPagination;



class PermissionIndex extends Component
{
    use WithPagination;

    public string $successMessage = '';
    public string $errorMessage = '';
    public string $search = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

     public function deletePermission($permissionId)
    {
        $this->successMessage = '';
        $this->errorMessage = '';

        try {
            $permission = Permission::find($permissionId);

            if (!$permission) {
                $this->errorMessage = "La permission n'existe pas.";
                return;
            }

            $permission->delete();
            $this->successMessage = 'Permission supprimée avec succès.';
        } catch (\Throwable $exception) {
            $this->errorMessage = "La permission n'a pas pu être supprimée.";
        }
    }

    public function render()
    {
        $permissions = Permission::when($this->search !== '', function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%');
        })->get();
        return view('permissions.permission-index', [
            'permissions' => $permissions
        ]);
    }
}