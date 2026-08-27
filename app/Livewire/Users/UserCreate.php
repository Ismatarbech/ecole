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
        $this->allRoles = Role::pluck('name')->toArray();
    }

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email',
        'password' => 'required|string|min:8',
        'selectedRoles' => 'nullable|array',
    ];

    protected $messages = [
        'name.required' => 'Le nom est obligatoire.',
        'name.string' => 'Le nom doit être une chaîne de caractères.',
        'name.max' => 'Le nom ne doit pas dépasser 255 caractères.',

        'email.required' => "L’adresse email est obligatoire.",
        'email.email' => 'Veuillez saisir une adresse email valide.',
        'email.unique' => 'Cet email existe déjà.',

        'password.required' => 'Le mot de passe est obligatoire.',
        'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',

        'selectedRoles.array' => 'La sélection des rôles est invalide.',
    ];

    public function CreateUser()
    {
        $this->validate();

        try {

            $newuser = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => bcrypt($this->password),
            ]);

            if (!empty($this->selectedRoles)) {
                $newuser->assignRole($this->selectedRoles);
            }

            // Message de succès
            session()->flash(
                'success',
                'L’utilisateur a été créé avec succès.'
            );

            // Redirection vers la liste des utilisateurs
            return redirect()->route('users.index');

        } catch (\Exception $e) {

            // Message d'erreur
            session()->flash(
                'error',
                'Une erreur est survenue lors de la création de l’utilisateur.'
            );

            return;
        }
    }

    public function render()
    {
        return view('users.user-create');
    }
}