<?php

namespace App\Http\Controllers;

use App\Models\Eleve;
use App\Models\Etablissement;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Collection;

class EleveDocumentController extends Controller
{
    /**
     * =========================
     * BULLETIN (avec période)
     * =========================
     */
    public function bulletin(Eleve $eleve, $periode = null)
    {
        $data = $this->documentData($eleve, $periode);

        return Pdf::loadView('pdf.eleve-bulletin', $data)
            ->setPaper('a4', 'portrait')
            ->download('bulletin-' . $eleve->matricule . '.pdf');
    }

    /**
     * =========================
     * FICHE D'INSCRIPTION
     * =========================
     */
    public function fiche(Eleve $eleve)
    {
        $eleve->load(['classe.niveau', 'anneeScolaire']);

        $etablissement = Etablissement::first();

        return Pdf::loadView('pdf.eleve-fiche', [
            'eleve' => $eleve,
            'etablissement' => $etablissement,
        ])
        ->setPaper('a4', 'portrait')
        ->download('fiche-' . $eleve->matricule . '.pdf');
    }

    /**
     * =========================
     * CARTE SCOLAIRE
     * =========================
     */
    public function carte(Eleve $eleve)
    {
        $eleve->load(['classe.niveau', 'anneeScolaire']);

        $etablissement = Etablissement::first();

        return Pdf::loadView('pdf.eleve-carte', [
            'eleve' => $eleve,
            'etablissement' => $etablissement,
        ])
        ->setPaper('a4', 'portrait')
        ->download('carte-' . $eleve->matricule . '.pdf');
    }

    /**
     * =========================
     * DONNÉES BULLETIN
     * =========================
     */
    private function documentData(Eleve $eleve, $periodeId = null): array
    {
        $eleve->load(['classe.niveau', 'anneeScolaire', 'notes.matiere']);

        $etablissement = Etablissement::first();

        $elevesClasse = Eleve::with('notes.matiere')
            ->where('classe_id', $eleve->classe_id)
            ->where('annee_scolaire_id', $eleve->annee_scolaire_id)
            ->get();

        $moyennes = $elevesClasse->mapWithKeys(function ($e) use ($periodeId) {
            return [$e->id => $this->moyenne($e->notes, $periodeId)];
        })->sortDesc();

        $rang = $moyennes->keys()->search($eleve->id);

        return [
            'eleve' => $eleve,
            'etablissement' => $etablissement,
            'effectif' => $elevesClasse->count(),
            'rang' => $rang === false ? null : $rang + 1,
            'periodeId' => $periodeId,
        ];
    }

    /**
     * =========================
     * MOYENNE
     * =========================
     */
    private function moyenne(Collection $notes, $periodeId = null): float
    {
        $total = 0;
        $coef = 0;

        foreach ($notes as $note) {

            if ($periodeId && $note->periode_id != $periodeId) {
                continue;
            }

            $c = (float) ($note->matiere?->coefficient ?? 0);
            $m = ((float)$note->devoir + (float)$note->composition) / 2;

            $total += $m * $c;
            $coef += $c;
        }

        return $coef ? $total / $coef : 0;
    }
}