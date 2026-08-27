<?php

namespace App\Livewire\Inscriptions;

use App\Models\Eleve;
use Livewire\Component;

class InscriptionDetail extends Component
{
    public Eleve $eleve;

    public function mount($id)
    {
        $this->eleve = Eleve::with([
            'classe.niveau',
            'anneeScolaire',
        ])->findOrFail($id);
    }

    public function render()
    {
        return view('inscriptions.inscription-detail');
    }
}