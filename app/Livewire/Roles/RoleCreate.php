<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleCreate extends Component
{
    public string $name ;

    public array $allPermissions = [];

    public array $selectedPermissions = [];

    public function mount()
    {
        $this->allPermissions = Permission::pluck('name')->toArray();
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:roles,name',

            'selectedPermissions' => 'array',

            'selectedPermissions.*' => [
                'string',
                'exists:permissions,name',
            ],
        ];
    }

    public function createRole()
    {
        // Validation
        $this->validate();

        // Créer le rôle
        $role = Role::create([
            'name' => $this->name,
        ]);

        // Attribuer les permissions sélectionnées
        if (!empty($this->selectedPermissions)) {
            $role->syncPermissions($this->selectedPermissions);
        }

        // Message de succès
        session()->flash(
            'message',
            "Le rôle « {$this->name} » a été créé avec succès !"
        );

        // Réinitialiser le formulaire
        $this->reset([
            'name',
            'selectedPermissions',
        ]);

        // Redirection vers la liste des rôles
        return redirect()->route('roles.index');
    }

    public function render()
    {
        return view('roles.role-create');
    }
}