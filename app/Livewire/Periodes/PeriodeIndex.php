<?php

namespace App\Livewire\Periodes;

use App\Models\Periode;
use Livewire\Component;
use Livewire\WithPagination;

class PeriodeIndex extends Component
{
    use WithPagination;

    public string $search = '';

    protected $paginationTheme = 'bootstrap';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    // 🔥 ACTIVER / DÉSACTIVER
    public function toggleStatus($id)
    {
        $periode = Periode::with('anneeScolaire')->findOrFail($id);

        // ❌ blocage si année inactive
        if ($periode->anneeScolaire?->status !== 'active') {
            session()->flash('error', 'Activez d’abord l’année scolaire.');
            return;
        }

        $periode->update([
            'statut' => $periode->statut === 'active' ? 'inactive' : 'active'
        ]);

        session()->flash(
            'message',
            $periode->statut === 'active'
                ? 'Période désactivée'
                : 'Période activée'
        );
    }

    // 🔥 SUPPRESSION (soft delete)
    public function delete($id)
    {
        $periode = Periode::find($id);

        if (!$periode) {
            session()->flash('error', 'Période introuvable.');
            return;
        }

        $periode->delete();

        session()->flash('message', 'Période supprimée.');
        $this->resetPage();
    }

   public function render()
{
    $periodes = Periode::with('anneeScolaire')

        // ✅ FILTRER UNIQUEMENT LES ANNÉES ACTIVES
        ->whereHas('anneeScolaire', function ($q) {
            $q->where('status', 'active');
        })

        ->when($this->search, function ($query) {
            $search = '%' . $this->search . '%';

            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', $search)
                    ->orWhere('type', 'like', $search)
                    ->orWhere('ordre', 'like', $search)
                    ->orWhereHas('anneeScolaire', function ($q2) use ($search) {
                        $q2->where('scolaire_annee', 'like', $search);
                    });
            });
        })

        ->orderBy('annee_scolaire_id')
        ->orderBy('ordre')
        ->paginate(10);

    return view('periodes.periode-index', [
        'periodes' => $periodes
    ]);
}
}