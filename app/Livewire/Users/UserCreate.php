<?php

namespace App\Livewire\Users;

use Livewire\Component;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserCreate extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';

    public array $allRoles = [];
    public array $selectedRoles = [];

    public function mount()
    {
        // 🔥 on exclut les rôles sensibles
        $this->allRoles = Role::whereNotIn('name', [
            'super-admin',
            'admin'
        ])->pluck('name')->toArray();
    }

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8',
        'selectedRoles' => 'nullable|array',
    ];

    protected $messages = [
        'name.required' => 'Le nom est obligatoire.',
        'email.required' => 'L’email est obligatoire.',
        'email.email' => 'Email invalide.',
        'email.unique' => 'Cet email existe déjà.',
        'password.required' => 'Le mot de passe est obligatoire.',
        'password.min' => '8 caractères minimum.',
    ];

  public function CreateUser()
{
    $this->validate();

    $authUser = auth()->user();

    if (!$authUser || !$authUser->hasRole(['super-admin','proviseur'])) {
        session()->flash('error', 'Accès refusé.');
        return;
    }

    // 🔥 rôles de l'utilisateur connecté
    $creatorRoles = $authUser->getRoleNames()->toArray();

    // ❌ empêche d’attribuer son propre rôle
    if (collect($this->selectedRoles)->intersect($creatorRoles)->count()) {
        session()->flash('error', 'Vous ne pouvez pas attribuer votre propre rôle.');
        return;
    }

    // 🔥 anti admin injection
    if (collect($this->selectedRoles)->intersect(['admin', 'super-admin'])->count()) {
        session()->flash('error', 'Rôle non autorisé.');
        return;
    }

    try {

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
        ]);

        if (!empty($this->selectedRoles)) {
            $user->assignRole($this->selectedRoles);
        }

        session()->flash('success', 'Utilisateur créé avec succès.');
        return redirect()->route('users.index');

    } catch (\Exception $e) {
        session()->flash('error', 'Erreur lors de la création.');
        return;
    }
}

    public function render()
    {
        return view('users.user-create');
    }
}