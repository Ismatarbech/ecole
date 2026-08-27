<?php

namespace App\Livewire\Contacts;

use App\Models\Contact;
use Livewire\Component;

class ContactEdit extends Component
{
    public function render()
    {
        return view('contacts.contact-edit');
    }
}