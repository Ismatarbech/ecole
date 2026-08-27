<?php

namespace App\Livewire\Paiements;

use App\Models\Eleve;
use App\Models\Classe;
use App\Models\AnneeScolaire;
use App\Models\Paiement;
use Livewire\Component;

class PaiementCreate extends Component
{
    public string $classe_id = '';
    public string $eleve_id = '';
    public string $montant = '';
    public string $mode_paiement = 'Especes';
    public string $date_paiement = '';
    public string $errorMessage = '';

    public function mount(): void
    {
        $this->date_paiement = now()->format('Y-m-d');
    }

    public function updatedClasseId(): void
    {
        $this->eleve_id = '';
    }

    public function save()
    {
        $this->validate([
            'classe_id' => ['required', 'exists:classes,id'],
            'eleve_id' => ['required', 'exists:eleves,id'],
            'montant' => ['required', 'numeric', 'min:1'],
            'mode_paiement' => ['required', 'in:Especes,Mobile Money,Virement,Cheque'],
            'date_paiement' => ['required', 'date'],
        ]);

        $annee = AnneeScolaire::where('status', 'active')->first();
        $eleve = Eleve::with('classe.niveau')->find($this->eleve_id);

        if (!$annee || !$eleve || (string) $eleve->classe_id !== (string) $this->classe_id) {
            $this->errorMessage = "L'année active, la classe ou l'élève sélectionné est invalide.";
            return;
        }

        $totalPaye = (float) $eleve->paiements()
            ->where('annee_scolaire_id', $annee->id)
            ->sum('montant');
        $frais = (float) ($eleve->classe?->niveau?->montant ?? 0);
        $reste = max(0, $frais - $totalPaye);

        if ((float) $this->montant > $reste) {
            $this->addError('montant', 'Le montant ne peut pas dépasser le reste à payer : ' . $reste . ' FCFA.');
            return;
        }

        Paiement::create([
            'eleve_id' => $eleve->id,
            'annee_scolaire_id' => $annee->id,
            'classe_id' => $eleve->classe_id,
            'montant' => $this->montant,
            'mode_paiement' => $this->mode_paiement,
            'date_paiement' => $this->date_paiement,
        ]);

        return redirect()->route('paiement.index')->with('success', 'Paiement enregistré avec succès.');
    }

    public function render()
    {
        $annee = AnneeScolaire::where('status', 'active')->first();
        $classes = $annee
            ? Classe::whereHas('niveau', fn ($query) => $query->where('annee_scolaire_id', $annee->id))->orderBy('name')->get()
            : collect();
        $eleves = $this->classe_id
            ? Eleve::where('classe_id', $this->classe_id)->where('annee_scolaire_id', $annee?->id)->orderBy('matricule')->get()
            : collect();

        return view('paiements.paiement-create', compact('classes', 'eleves', 'annee'));
    }
}