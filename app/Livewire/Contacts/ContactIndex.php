<?php

namespace App\Livewire\Contacts;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Contact;

class ContactIndex extends Component
{
    use WithPagination;

    public string $search = '';

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function deleteContact($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        session()->flash('success', 'Contact supprimé avec succès.');
    }

    public function render()
    {
        $contacts = Contact::query()
            ->where(function ($q) {
                $q->where('nom', 'like', "%{$this->search}%")
                  ->orWhere('matricule', 'like', "%{$this->search}%")
                  ->orWhere('sujet', 'like', "%{$this->search}%");
            })
            ->latest()
            ->paginate(10);

        return view('contacts.contact-index', [
            'contacts' => $contacts
        ]);
    }
}