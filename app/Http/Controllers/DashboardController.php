<?php

namespace App\Http\Controllers;

use App\Models\AnneeScolaire;
use App\Models\Eleve;
use App\Models\Paiement;
use App\Models\Note;
use App\Models\Niveau;

class DashboardController extends Controller
{
    public function index()
    {
        $anneeActive = AnneeScolaire::where('status', 'active')->first();

        $elevesActifs = $anneeActive
            ? Eleve::where('annee_scolaire_id', $anneeActive->id)->with('classe.niveau')->get()
            : collect();

        $nombreElevesActifs = $elevesActifs->count();
        $nombreElevesTotal = Eleve::count();
        $pourcentageElevesActifs = $nombreElevesTotal > 0
            ? round(($nombreElevesActifs / $nombreElevesTotal) * 100)
            : 0;

        $revenuActif = $anneeActive
            ? (float) Paiement::where('annee_scolaire_id', $anneeActive->id)->sum('montant')
            : 0;

        $revenusParMois = collect(range(1, 12))->mapWithKeys(
            fn ($mois) => [$mois => 0]
        );
        $inscriptionsParMois = collect(range(1, 12))->mapWithKeys(
            fn ($mois) => [$mois => 0]
        );
        $paiementsParMois = collect(range(1, 12))->mapWithKeys(
            fn ($mois) => [$mois => 0]
        );

        if ($anneeActive) {
            Eleve::where('annee_scolaire_id', $anneeActive->id)
                ->get()
                ->each(function ($eleve) use (&$inscriptionsParMois) {
                    $mois = ($eleve->date_inscription ?? $eleve->created_at)->month;
                    $inscriptionsParMois->put(
                        $mois,
                        $inscriptionsParMois->get($mois, 0) + 1
                    );
                });

            Paiement::where('annee_scolaire_id', $anneeActive->id)
                ->get()
                ->each(function ($paiement) use (&$revenusParMois) {
                    $mois = $paiement->date_paiement->month;
                    $revenusParMois->put(
                        $mois,
                        $revenusParMois->get($mois, 0) + (float) $paiement->montant
                    );
                });

            Paiement::where('annee_scolaire_id', $anneeActive->id)
                ->get()
                ->each(function ($paiement) use (&$paiementsParMois) {
                    $mois = $paiement->date_paiement->month;
                    $paiementsParMois->put(
                        $mois,
                        $paiementsParMois->get($mois, 0) + 1
                    );
                });

            $totalInscriptions = 0;
            $totalPaiements = 0;

            foreach (range(1, 12) as $mois) {
                $totalInscriptions += $inscriptionsParMois->get($mois, 0);
                $inscriptionsParMois->put($mois, $totalInscriptions);

                $totalPaiements += $paiementsParMois->get($mois, 0);
                $paiementsParMois->put($mois, $totalPaiements);
            }
        }

        $fraisAttendus = $elevesActifs->sum(
            fn ($eleve) => (float) ($eleve->classe?->niveau?->montant ?? 0)
        );
        $pourcentageRevenu = $fraisAttendus > 0
            ? min(100, round(($revenuActif / $fraisAttendus) * 100))
            : 0;

        $meilleursEleves = Eleve::with(['classe.niveau', 'notes.matiere'])
            ->get()
            ->map(function ($eleve) {
                $totalPoints = $eleve->notes->sum(function ($note) {
                    $coefficient = (float) ($note->matiere?->coefficient ?? 0);
                    return (($note->devoir + $note->composition) / 2) * $coefficient;
                });
                $totalCoefficients = $eleve->notes->sum(
                    fn ($note) => (float) ($note->matiere?->coefficient ?? 0)
                );

                $eleve->moyenne_generale = $totalCoefficients > 0
                    ? $totalPoints / $totalCoefficients
                    : 0;

                return $eleve;
            })
            ->filter(fn ($eleve) => $eleve->notes->isNotEmpty())
            ->sortByDesc('moyenne_generale')
            ->take(5)
            ->values();

        $revenusParAnnee = AnneeScolaire::withCount('eleves')
            ->withSum('paiements', 'montant')
            ->orderByDesc('id')
            ->get();

        $elevesParClasse = $elevesActifs
            ->groupBy(fn ($eleve) => $eleve->classe?->name ?? 'Classe non affectée')
            ->map(fn ($eleves, $classe) => [
                'name' => $classe,
                'value' => $eleves->count(),
            ])
            ->values();

        $niveauxActifs = $anneeActive
            ? Niveau::where('annee_scolaire_id', $anneeActive->id)->get()
            : collect();
        $ordreNiveaux = [
            'CP1', 'CP2', 'CE1', 'CE2', 'CM1', 'CM2',
            '6EME', '5EME', '4EME', '3EME', '2NDE', '1ERE', 'TERMINALE',
        ];
        $elevesParNiveau = $niveauxActifs
            ->sortBy(function ($niveau) use ($ordreNiveaux) {
                $code = strtoupper(preg_replace('/[^A-Z0-9]/', '', $niveau->code));
                $position = array_search($code, $ordreNiveaux, true);

                return $position === false ? count($ordreNiveaux) : $position;
            })
            ->map(fn ($niveau) => [
                'name' => $niveau->code ?: $niveau->libelle,
                'value' => $elevesActifs->filter(
                    fn ($eleve) => $eleve->classe?->niveau_id === $niveau->id
                )->count(),
            ])
            ->values();

        $activites = collect();

        if ($anneeActive) {
            $activites = Eleve::where('annee_scolaire_id', $anneeActive->id)
                ->latest()
                ->take(5)
                ->get()
                ->map(fn ($eleve) => [
                    'date' => $eleve->created_at,
                    'couleur' => 'success',
                    'texte' => "Nouvel élève inscrit : {$eleve->nom} {$eleve->prenom}",
                ])
                ->merge(
                    Paiement::where('annee_scolaire_id', $anneeActive->id)
                        ->latest()
                        ->take(5)
                        ->get()
                        ->map(fn ($paiement) => [
                            'date' => $paiement->created_at,
                            'couleur' => 'primary',
                            'texte' => 'Paiement reçu : ' . number_format((float) $paiement->montant, 0, ',', ' ') . ' FCFA',
                        ])
                )
                ->sortByDesc('date')
                ->take(6)
                ->values();
        }

        return view('dashboard', compact(
            'anneeActive',
            'nombreElevesActifs',
            'nombreElevesTotal',
            'pourcentageElevesActifs',
            'revenuActif',
            'revenusParMois',
            'inscriptionsParMois',
            'paiementsParMois',
            'pourcentageRevenu',
            'meilleursEleves',
            'revenusParAnnee',
            'elevesParClasse',
            'elevesParNiveau',
            'activites'
        ));
    }
}
