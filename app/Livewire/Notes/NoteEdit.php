<?php
namespace App\Livewire\Notes;

use Livewire\Component;
use App\Models\Note;

class NoteEdit extends Component
{
    public function render()
    {
        return view('notes.note-edit');
    }
}