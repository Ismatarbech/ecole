<?php

namespace App\Http\Controllers;

use App\Models\AnneeScolaire;
use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Paiement;
use Illuminate\Support\Collection;

class DonneeController extends Controller
{
    public function index()
    {
        $anneeActive = AnneeScolaire::where('status', 'active')->first();
        $eleves = $anneeActive
            ? Eleve::with('classe.niveau')->where('annee_scolaire_id', $anneeActive->id)->get()
            : collect();
        $paiements = $anneeActive
            ? Paiement::with('classe')->where('annee_scolaire_id', $anneeActive->id)->get()
            : collect();

        $classes = Classe::with('niveau')->get();
        $nomsMois = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'];
        $elevesParClasse = $classes->map(fn ($classe) => [
            'label' => $classe->name,
            'value' => $eleves->where('classe_id', $classe->id)->count(),
        ])->filter(fn ($item) => $item['value'] > 0)->values();
        $classesAvecEleves = $classes->filter(fn ($classe) => $eleves->where('classe_id', $classe->id)->isNotEmpty());
        $classesLabels = $classesAvecEleves->pluck('name')->values();
        $fillesParClasse = $classesAvecEleves->map(fn ($classe) => $eleves
            ->where('classe_id', $classe->id)
            ->filter(fn ($eleve) => in_array(strtolower($eleve->sexe), ['f', 'fille', 'féminin', 'feminin'], true))
            ->count())->values();
        $garconsParClasse = $classesAvecEleves->map(fn ($classe) => $eleves
            ->where('classe_id', $classe->id)
            ->filter(fn ($eleve) => ! in_array(strtolower($eleve->sexe), ['f', 'fille', 'féminin', 'feminin'], true))
            ->count())->values();

        $elevesParNiveau = $eleves->groupBy(fn ($eleve) => $eleve->classe?->niveau?->code ?? 'Sans niveau')
            ->map(fn (Collection $groupe, $label) => ['label' => $label, 'value' => $groupe->count()])->values();
        $elevesParSexe = $eleves->groupBy(fn ($eleve) => ucfirst(strtolower($eleve->sexe ?: 'Non renseigné')))
            ->map(fn (Collection $groupe, $label) => ['label' => $label, 'value' => $groupe->count()])->values();

        $inscriptionsParMois = collect(range(1, 12))->map(fn ($mois) => $eleves->filter(fn ($eleve) => ($eleve->date_inscription ?? $eleve->created_at)?->month === $mois)->count())->values();
        $revenusParMois = collect(range(1, 12))->map(fn ($mois) => (float) $paiements->filter(fn ($paiement) => $paiement->date_paiement?->month === $mois)->sum('montant'))->values();
        $paiementsParClasse = $paiements->groupBy(fn ($paiement) => $paiement->classe?->name ?? 'Classe inconnue')
            ->map(fn (Collection $groupe, $label) => ['label' => $label, 'value' => (float) $groupe->sum('montant')])->values();
        $paiementsParMode = $paiements->groupBy(fn ($paiement) => $paiement->mode_paiement ?: 'Non renseigné')
            ->map(fn (Collection $groupe, $label) => ['label' => $label, 'value' => (float) $groupe->sum('montant')])->values();

        $cumul = 0;
        $revenusCumules = $revenusParMois->map(function ($montant) use (&$cumul) {
            $cumul += $montant;
            return $cumul;
        })->values();

        return view('components.donnees.donnee-index', compact(
            'anneeActive', 'nomsMois', 'elevesParClasse', 'elevesParNiveau', 'elevesParSexe',
            'inscriptionsParMois', 'revenusParMois', 'paiementsParClasse', 'paiementsParMode', 'revenusCumules',
            'classesLabels', 'fillesParClasse', 'garconsParClasse'
        ));
    }
}
