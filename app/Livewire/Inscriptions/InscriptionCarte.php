<?php

namespace App\Livewire\Inscriptions;

use App\Models\Eleve;
use Livewire\Component;

class InscriptionCarte extends Component
{
    public Eleve $eleve;

    public function mount($id)
    {
        $this->eleve = Eleve::with([
            'classe.niveau',
            'anneeScolaire',
        ])
        ->withSum('paiements', 'montant')
        ->get()
        ->findOrFail($id);
    }

    public function render()
    {
        return view('inscriptions.inscription-carte');
    }
}