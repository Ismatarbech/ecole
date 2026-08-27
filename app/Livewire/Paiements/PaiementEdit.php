<?php 

namespace App\Livewire\Paiements;

use Livewire\Component;
use App\Models\Paiement;


class PaiementEdit extends Component
{

    public function render()
    {
        return view('paiements.paiement-edit');
    }
}