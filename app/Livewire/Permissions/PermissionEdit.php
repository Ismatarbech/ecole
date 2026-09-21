<?php

namespace App\Livewire\Permissions;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionEdit extends Component
{
    public Permission $permission;

    public string $name = '';
    public array $selectedRoles = [];
    public array $allRoles = [];

    public function mount(Permission $permission)
    {
        $this->permission = $permission;
        $this->name = $permission->name;

        // 🔐 filtre des rôles selon utilisateur connecté
        $this->allRoles = Role::query()
            ->when(!auth()->user()->hasRole('super-admin'), function ($q) {
                $q->where('name', '!=', 'super-admin');
            })
            ->pluck('name')
            ->toArray();

        // 🔐 selected roles aussi filtrés
        $this->selectedRoles = $permission->roles()
            ->pluck('name')
            ->filter(function ($role) {
                return auth()->user()->hasRole('super-admin') || $role !== 'super-admin';
            })
            ->toArray();
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|unique:permissions,name,' . $this->permission->id,
            'selectedRoles' => 'array',
            'selectedRoles.*' => 'string|exists:roles,name',
        ];
    }

    public function updatePermission()
    {
        $this->validate();

        // 🔐 sécurité backend
        if (!auth()->user() || !auth()->user()->hasRole('super-admin')) {
            session()->flash('error', 'Accès refusé.');
            return;
        }

        try {
            $this->permission->update([
                'name' => $this->name
            ]);

            $this->permission->syncRoles($this->selectedRoles);

            session()->flash('success', 'Permission modifiée avec succès.');

            return redirect()->route('permissions.index');

        } catch (\Throwable $exception) {
            session()->flash('error', "Erreur lors de la modification.");
            return;
        }
    }

    public function render()
    {
        return view('permissions.permission-edit');
    }
}