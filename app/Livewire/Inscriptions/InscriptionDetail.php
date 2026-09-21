<?php

namespace App\Livewire\Inscriptions;

use App\Models\Eleve;
use App\Models\Etablissement;
use Livewire\Component;

class InscriptionDetail extends Component
{
    public Eleve $eleve;
    public $etablissement;

    public int $effectif = 0;
    public ?int $rang = null;

    public $periodes;

    public function mount($id)
    {
        // =========================
        // ELEVE + RELATIONS
        // =========================
        $this->eleve = Eleve::with([
            'classe.niveau',
            'anneeScolaire.periodes',
            'notes.matiere',
        ])->findOrFail($id);

        $this->etablissement = Etablissement::first();

        // =========================
        // PERIODES (SAFE)
        // =========================
        $this->periodes = optional($this->eleve->anneeScolaire)
            ->periodes ?? collect();

        $this->periodes = $this->periodes
            ->where('statut', 'active')
            ->sortBy('ordre');

        // =========================
        // ELEVES CLASSE
        // =========================
        $eleves = Eleve::with('notes.matiere')
            ->where('classe_id', $this->eleve->classe_id)
            ->where('annee_scolaire_id', $this->eleve->annee_scolaire_id)
            ->get();

        $this->effectif = $eleves->count();

        // =========================
        // RANG GLOBAL
        // =========================
        $moyennes = $eleves->mapWithKeys(function ($e) {

            $total = 0;
            $coef = 0;

            foreach ($e->notes ?? [] as $note) {

                $c = (float) ($note->matiere?->coefficient ?? 0);
                $m = ((float) $note->devoir + (float) $note->composition) / 2;

                $total += $m * $c;
                $coef += $c;
            }

            return [$e->id => $coef ? $total / $coef : 0];
        })->sortDesc();

        $pos = $moyennes->keys()->search($this->eleve->id);

        $this->rang = $pos !== false ? $pos + 1 : null;
    }

    public function render()
    {
        return view('inscriptions.inscription-detail');
    }
}