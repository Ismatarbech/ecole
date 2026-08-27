<?php
 
namespace App\Livewire\Permissions;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class PermissionCreate extends Component
{
    public string $name;
    public array $selectedRoles = [];
    public array $allRoles = [];

    public function mount()
    {
        $this->allRoles = Role::pluck('name')->toArray();
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|unique:permissions,name',
            'selectedRoles' => 'array',
            'selectedRoles.*' => 'string|exists:roles,name',
        ];
    }
       protected $messages = [
        'name.unique' => 'Cet nom existe déjà.',
        'name.required' => "Le nom est obligatoire.",
     
    ];

    public function createPermission()
    {
       $this->validate();

       try {
           $permission = Permission::create(['name' => $this->name]);
           $permission->syncRoles($this->selectedRoles);
           session()->flash('success', 'Permission créée avec succès.');
       } catch (\Throwable $exception) {
           session()->flash('error', "La permission n'a pas pu être créée.");
           return;
       }

       $this->name ='';
       $this->selectedRoles = [];

       return redirect()->route('permissions.index');

    }
   
    public function render()
    {

        return view('permissions.permission-create');
    }
}