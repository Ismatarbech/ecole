<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleEdit extends Component
{
    public Role $role;

    public string $name;

    public array $allPermissions = [];

    public array $selectedPermissions = [];


    /**
     * Charger les données du rôle
     */
    public function mount(Role $role)
    {
        $this->role = $role;

        // Nom du rôle
        $this->name = $role->name;

        // Permissions déjà attribuées
        $this->selectedPermissions = $role
            ->permissions
            ->pluck('name')
            ->toArray();

        // Toutes les permissions disponibles
        $this->allPermissions = Permission
            ::pluck('name')
            ->toArray();
    }


    /**
     * Validation
     */
    protected function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:roles,name,' . $this->role->id,
            ],

            'selectedPermissions' => [
                'array',
            ],

            'selectedPermissions.*' => [
                'string',
                'exists:permissions,name',
            ],
        ];
    }


    /**
     * Modifier le rôle
     */
    public function updateRole()
    {
        // Validation
        $this->validate();

        // Modifier le nom
        $this->role->update([
            'name' => $this->name,
        ]);

        // Synchroniser les permissions
        $this->role->syncPermissions(
            $this->selectedPermissions
        );

        // Message de succès
        session()->flash(
            'message',
            "Le rôle « {$this->name} » a été modifié avec succès !"
        );

        // Réinitialiser
        $this->reset([
            'name',
            'selectedPermissions',
        ]);

        // Redirection
        return redirect()->route('roles.index');
    }


    public function render()
    {
        return view('roles.role-edit');
    }
}