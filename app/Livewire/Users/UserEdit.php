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
    public ?string $password = null;

    public array $allRoles = [];
    public array $selectedRoles = [];

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->user->id),
            ],
            'password' => ['nullable', 'string', 'min:8'],
        ];
    }

    public function mount(User $user)
    {
        $this->user = $user;

        $this->name = $user->name;
        $this->email = $user->email;

        // 🔥 on exclut les rôles sensibles
        $this->allRoles = Role::whereNotIn('name', [
            'super-admin',
            'admin'
        ])->pluck('name')->toArray();

        // 🔥 sécurité: on filtre aussi les rôles existants
        $this->selectedRoles = $user->roles()
            ->pluck('name')
            ->filter(fn($role) => !in_array($role, ['super-admin', 'admin']))
            ->toArray();
    }

    public function updateUser()
    {
        $this->validate();

        // 🔐 sécurité backend
        if (!auth()->user() || !auth()->user()->hasRole('super-admin')) {
            session()->flash('error', 'Accès refusé.');
            return;
        }

        // 🔥 blocage injection rôle admin
        if (collect($this->selectedRoles)->intersect(['admin', 'super-admin'])->count()) {
            session()->flash('error', 'Rôle non autorisé.');
            return;
        }

        try {
            $this->user->update([
                'name' => $this->name,
                'email' => $this->email,
                'password' => $this->password
                    ? bcrypt($this->password)
                    : $this->user->password,
            ]);

            $this->user->syncRoles($this->selectedRoles);

            return redirect()
                ->route('users.index')
                ->with('success', 'Utilisateur modifié avec succès.');

        } catch (\Throwable $exception) {

            session()->flash('error', "Erreur lors de la modification.");
            return;
        }
    }

    public function render()
    {
        return view('users.user-edit');
    }
}