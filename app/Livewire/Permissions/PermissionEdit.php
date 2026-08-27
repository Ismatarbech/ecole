<?php
 
namespace App\Livewire\Permissions;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionEdit extends Component
{
    public Permission $permission;
    public string $name;
    public array $selectedRoles = [];
    public array $allRoles = [];

    public function mount(Permission $permission)
    {
        $this->permission = $permission;
        $this->name = $permission->name;
        $this->selectedRoles = $permission->roles()->pluck('name')->toArray();
        $this->allRoles = Role::pluck('name')->toArray();
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|unique:permissions,name,'.$this->permission->id,
            'selectedRoles' => 'array',
            'selectedRoles.*' => 'string|exists:roles,name',
        ];
    }

    public function updatePermission()
    {
        $this->validate();

        try {
            $this->permission->update(['name' => $this->name]);
            $this->permission->syncRoles($this->selectedRoles);
        } catch (\Throwable $exception) {
            session()->flash('error', "La permission n'a pas pu être modifiée.");
            return;
        }

        session()->flash('success', 'Permission modifiée avec succès.');

        return redirect()->route('permissions.index');
    } 

    public function render()
    {
         return view('permissions.permission-edit');
    }
}