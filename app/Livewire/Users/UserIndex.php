<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class UserIndex extends Component
{
    use WithPagination;

    public $successMessage = '';
    public $errorMessage = '';
    public string $search = '';

    protected $paginationTheme = 'bootstrap';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function deleteUser($userId)
    {
        $this->successMessage = '';
        $this->errorMessage = '';

        try {

            $user = User::find($userId);

            if (!$user) {
                $this->errorMessage = "L'utilisateur n'existe pas.";
                return;
            }

            // ❌ Empêcher auto suppression
            if (Auth::id() == $user->id) {
                $this->errorMessage = "❌ Tu ne peux pas supprimer ton propre compte.";
                return;
            }

            // ❌ Empêcher suppression super-admin
            if ($user->hasRole('super-admin')) {
                $this->errorMessage = "⛔ Impossible de supprimer le Super Admin.";
                return;
            }

            $userName = $user->name;

            $user->delete();

            $this->successMessage =
                "L'utilisateur « {$userName} » a été supprimé avec succès.";

        } catch (\Exception $e) {

            $this->errorMessage =
                "L'utilisateur n'a pas pu être supprimé.";
        }
    }

public function render()
{
    $currentUser = auth()->user();

    $users = User::with('roles')

        ->where('id', '!=', $currentUser->id)

        ->whereDoesntHave('roles', function ($q) {
            $q->where('name', 'super-admin');
        })

        ->select('users.*')
        ->selectRaw("
            CASE
                WHEN EXISTS (SELECT 1 FROM model_has_roles mh
                    JOIN roles r ON r.id = mh.role_id
                    WHERE mh.model_id = users.id AND r.name = 'proviseur') THEN 1

                WHEN EXISTS (SELECT 1 FROM model_has_roles mh
                    JOIN roles r ON r.id = mh.role_id
                    WHERE mh.model_id = users.id AND r.name = 'censeur') THEN 2

                WHEN EXISTS (SELECT 1 FROM model_has_roles mh
                    JOIN roles r ON r.id = mh.role_id
                    WHERE mh.model_id = users.id AND r.name = 'comptable') THEN 3

                WHEN EXISTS (SELECT 1 FROM model_has_roles mh
                    JOIN roles r ON r.id = mh.role_id
                    WHERE mh.model_id = users.id AND r.name = 'enseignant') THEN 4

                ELSE 5
            END as role_priority
        ")

        ->when($this->search !== '', function ($query) {
            $query->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        })

        ->orderBy('role_priority') // ⭐ ordre par rôle
        ->latest()
        ->paginate(10);

    return view('users.user-index', compact('users'));
}
}