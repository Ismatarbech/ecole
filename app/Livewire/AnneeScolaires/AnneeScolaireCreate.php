<?php

namespace App\Livewire\AnneeScolaires;

use Livewire\Component;
use App\Models\AnneeScolaire;
use Carbon\Carbon;

class AnneeScolaireCreate extends Component
{
    public string $annee = '';

    /**
     * 🔥 normalisation propre
     */
    private function normalize(string $value): string
    {
        $value = trim($value);
        $value = str_replace('/', '-', $value);
        $value = preg_replace('/\s+/', '', $value);
        return $value;
    }

    /**
     * ❌ NE PAS VALIDER EN LIVE (important)
     * seulement au submit
     */

  public function save()
{
    $anneeClean = $this->normalize($this->annee);

    if (empty($anneeClean)) {
        session()->flash('error', "Veuillez saisir une année scolaire.");
        return;
    }

    $exists = AnneeScolaire::all()->contains(function ($item) use ($anneeClean) {
        return $this->normalize($item->scolaire_annee) === $anneeClean;
    });

    if ($exists) {
        session()->flash('error', "Cette année scolaire existe déjà.");
        return;
    }

    try {
        AnneeScolaire::create([
            'scolaire_annee' => $anneeClean,
            'current_annee' => Carbon::now()->format('Y'),
            'status' => 'inactive',
        ]);

        // ✅ message flash pour index
        session()->flash('success', "Année scolaire créée avec succès.");

        // 🔥 REDIRECTION VERS INDEX
        return redirect()->route('anneescolaire.index');

    } catch (\Throwable $e) {
        session()->flash('error', "Erreur lors de la création.");
    }
}

    public function render()
    {
        return view('anneescolaires.anneescolaire-create');
    }
}