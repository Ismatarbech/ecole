<?php

namespace App\Livewire\Niveaux;

use App\Models\Niveau;
use Livewire\Component;
use Livewire\WithPagination;

class NiveauxIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public string $search = '';

    public $successMessage = '';
    public $errorMessage = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * NORMALISATION
     */
    private function normalize($text): string
    {
        $text = strtolower($text);

        $text = str_replace(
            ['é','è','ê','ë','à','ù','û','î','ï','ô','œ','ç'],
            ['e','e','e','e','a','u','u','i','i','o','oe','c'],
            $text
        );

        $text = str_replace(
            ['eme','ème','ieme','iere','ère','er'],
            '',
            $text
        );

        return trim($text);
    }

    /**
     * ORDRE NIVEAUX (du plus élevé au plus bas)
     */
    private function getOrder($code): int
    {
        return match (strtoupper(trim($code))) {

            // 🔥 PLUS HAUT NIVEAU = 1
            'TERMINALE', 'TC', 'TD', 'TA' => 1,

            'PREMIERE', '1ERE' => 2,
            'SECONDE', '2ND' => 3,

            '3EME' => 4,
            '4EME' => 5,
            '5EME' => 6,
            '6EME' => 7,

            'CM2' => 8,
            'CM1' => 9,
            'CE2' => 10,
            'CE1' => 11,

            'CP2' => 12,
            'CP1' => 13, // 🔥 PLUS BAS NIVEAU

            default => 999,
        };
    }

    public function deleteNiveau($niveauId)
    {
        try {
            $niveau = Niveau::find($niveauId);

            if (!$niveau) {
                $this->errorMessage = "Niveau introuvable.";
                return;
            }

            $niveau->delete();

            $this->successMessage = "Niveau supprimé avec succès.";

        } catch (\Exception $e) {
            $this->errorMessage = "Erreur lors de la suppression.";
        }
    }

 public function render()
{
    $search = $this->normalize($this->search);

    $niveaux = Niveau::query()

        // ✅ FILTRE : uniquement années actives
        ->whereHas('anneeScolaire', function ($q) {
            $q->where('status', 'active');
        })

        ->get()
        ->filter(function ($niveau) use ($search) {

            if (!$search) return true;

            return str_contains($this->normalize($niveau->libelle), $search)
                || str_contains($this->normalize($niveau->code), $search);
        })

        /**
         * TRI DES NIVEAUX
         */
        ->sortBy(fn ($n) => $this->getOrder($n->code))
        ->values();

    return view('niveaux.niveau-index', [
        'niveaux' => $niveaux
    ]);
}
}