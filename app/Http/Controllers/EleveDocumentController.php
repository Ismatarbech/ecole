<?php

namespace App\Http\Controllers;

use App\Models\Eleve;
use Barryvdh\DomPDF\Facade\Pdf;

class EleveDocumentController extends Controller
{
    public function fiche(Eleve $eleve)
    {
        $eleve->load(['classe.niveau', 'anneeScolaire', 'paiements']);

        return Pdf::loadView('pdf.eleve-fiche', compact('eleve'))
            ->setPaper('a4', 'portrait')
            ->download('fiche-eleve-' . $eleve->matricule . '.pdf');
    }

    public function bulletin(Eleve $eleve)
    {
        $eleve->load(['classe.niveau', 'anneeScolaire', 'notes.matiere', 'paiements']);

        return Pdf::loadView('pdf.eleve-bulletin', compact('eleve'))
            ->setPaper('a4', 'portrait')
            ->download('bulletin-' . $eleve->matricule . '.pdf');
    }

    public function carte(Eleve $eleve)
    {
        $eleve->load(['classe.niveau', 'anneeScolaire']);

        return Pdf::loadView('pdf.eleve-carte', compact('eleve'))
            ->setPaper('a5', 'landscape')
            ->download('carte-eleve-' . $eleve->matricule . '.pdf');
    }
}
