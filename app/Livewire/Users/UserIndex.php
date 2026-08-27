<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

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
        $users = User::with('roles')
            ->when($this->search !== '', function ($query) {
                $query->where(function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()
            ->paginate(10);

        return view(
            'users.user-index',
            compact('users')
        );
    }
}