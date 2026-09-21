<?php

namespace App\Livewire\Permissions;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionCreate extends Component
{
    public string $name = '';
    public array $selectedRoles = [];
    public array $allRoles = [];

    public function mount()
    {
        // 🔥 super-admin uniquement visible pour super-admin
        $this->allRoles = Role::query()

            ->when(!auth()->user()->hasRole('super-admin'), function ($q) {
                $q->where('name', '!=', 'super-admin');
            })

            ->pluck('name')
            ->toArray();

        // 🔐 si super-admin → auto sélection
        if (auth()->user()->hasRole('super-admin')) {
            $this->selectedRoles = ['super-admin'];
        } else {
            $this->selectedRoles = [];
        }
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|unique:permissions,name',
            'selectedRoles' => 'required|array',
            'selectedRoles.*' => 'string|exists:roles,name',
        ];
    }

    protected $messages = [
        'name.required' => "Le nom est obligatoire.",
        'name.unique' => "Cette permission existe déjà.",
        'selectedRoles.required' => "Veuillez sélectionner au moins un rôle.",
    ];

    public function createPermission()
    {
        $this->validate();

        // 🔐 sécurité backend
        if (!auth()->user() || !auth()->user()->hasRole('super-admin')) {
            session()->flash('error', 'Accès refusé.');
            return;
        }

        try {
            $permission = Permission::create([
                'name' => $this->name
            ]);

            $permission->syncRoles($this->selectedRoles);

            session()->flash('success', 'Permission créée avec succès.');

            $this->reset(['name', 'selectedRoles']);

            return redirect()->route('permissions.index');

        } catch (\Throwable $e) {
            session()->flash('error', 'Erreur lors de la création.');
            return;
        }
    }

    public function render()
    {
        return view('permissions.permission-create');
    }
}