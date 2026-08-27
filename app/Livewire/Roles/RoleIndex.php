<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class RoleIndex extends Component
{
    public string $search = '';

    public function updatedSearch(): void
    {
        $this->search = trim($this->search);
    }

    public function deleteRole($roleId)
    {
        $role = Role::findById($roleId);

        if ($role) {

            $role->delete();

            session()->flash(
                'message',
                'Le rôle a été supprimé avec succès !'
            );

        } else {

            session()->flash(
                'error',
                "Le rôle n'a pas été supprimé."
            );
        }
    }

    public function render()
    {
        return view('roles.role-index', [
            'roles' => Role::when($this->search !== '', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })->get()
        ]);
    }
}