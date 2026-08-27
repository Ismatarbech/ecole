<?php

namespace App\Livewire\Users;

use Illuminate\Validation\Rule;
use Livewire\Component;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserEdit extends Component
{
    public User $user;

    public string $name = '';
    public string $email = '';
    public string|null $password = null;
    public array $allRoles = [];
    public array $selectedRoles = [];


    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required','string','email','max:255',Rule::unique('users', 'email')->ignore($this->user->id)],
            'password' => ['nullable', 'string', 'min:8'],
        ];
    }

    public function mount(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->allRoles = Role::pluck('name')->toArray();
        $this->selectedRoles = $user->roles()->pluck('name')->toArray();
    }

    public function updateUser()
    {
        $this->validate();

        try {
            $this->user->update([
                'name' => $this->name,
                'email' => $this->email,
                'password' => empty($this->password) ? $this->user->password : bcrypt($this->password),
            ]);

            $this->user->syncRoles($this->selectedRoles);

            return redirect()
                ->route('users.index')
                ->with('success', 'Utilisateur modifié avec succès.');
        } catch (\Throwable $exception) {
            session()->flash('error', "L'utilisateur n'a pas pu être modifié.");
        }
    }

    public function render()
    {
        return view('users.user-edit');
    }
}