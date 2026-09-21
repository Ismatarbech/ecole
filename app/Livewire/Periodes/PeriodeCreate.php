<?php

namespace App\Livewire\Periodes;

use App\Models\AnneeScolaire;
use App\Models\Periode;
use Livewire\Component;

class PeriodeCreate extends Component
{
    public ?int $annee_scolaire_id = null;
    public string $type = '';
    public string $nom = '';
    public ?int $ordre = null;

    public array $messagesInfo = [];

    public function rules(): array
    {
        return [
            'annee_scolaire_id' => 'required|exists:annee_scolaires,id',
            'type' => 'required|in:semestre,trimestre',
            'nom' => 'required|string',
            'ordre' => 'required|integer|min:1|max:3',
        ];
    }

    public function updatedAnneeScolaireId()
    {
        $this->reset(['type', 'nom', 'ordre', 'messagesInfo']);
    }

    public function updatedType()
    {
        $this->reset(['nom', 'ordre', 'messagesInfo']);
        $this->checkExistingType();
    }

    /**
     * 🔥 Vérifie si année utilise déjà un type
     */
    public function checkExistingType()
    {
        if (!$this->annee_scolaire_id || !$this->type) return;

        $typeExistant = Periode::where('annee_scolaire_id', $this->annee_scolaire_id)
            ->value('type');

        if ($typeExistant && $typeExistant !== $this->type) {
            $this->messagesInfo[] =
                "❌ Cette année utilise déjà le type : " . strtoupper($typeExistant);
        }
    }

    public function updatedNom()
    {
        foreach ($this->periodesDisponibles() as $p) {
            if ($p['nom'] === $this->nom) {
                $this->ordre = $p['ordre'];
                break;
            }
        }
    }

    /**
     * 🔥 LISTE + MESSAGES INTELLIGENTS
     */
    public function periodesDisponibles(): array
    {
        if (!$this->annee_scolaire_id || !$this->type) {
            return [];
        }

        $this->messagesInfo = [];

        // type global déjà utilisé
        $typeExistant = Periode::where('annee_scolaire_id', $this->annee_scolaire_id)
            ->value('type');

        if ($typeExistant && $typeExistant !== $this->type) {
            $this->messagesInfo[] =
                "❌ Cette année est déjà configurée en " . strtoupper($typeExistant);
            return [];
        }

        $used = Periode::where('annee_scolaire_id', $this->annee_scolaire_id)
            ->pluck('ordre')
            ->toArray();

        $list = [];

        if ($this->type === 'semestre') {

            if (in_array(1, $used)) {
                $this->messagesInfo[] = "✔ Semestre 1 déjà créé";
            } else {
                $list[] = ['nom' => 'Semestre 1', 'ordre' => 1];
            }

            if (in_array(2, $used)) {
                $this->messagesInfo[] = "✔ Semestre 2 déjà créé";
            } else {
                $list[] = ['nom' => 'Semestre 2', 'ordre' => 2];
            }
        }

        if ($this->type === 'trimestre') {

            for ($i = 1; $i <= 3; $i++) {

                if (in_array($i, $used)) {
                    $this->messagesInfo[] = "✔ Trimestre $i déjà créé";
                } else {
                    $list[] = [
                        'nom' => "Trimestre $i",
                        'ordre' => $i
                    ];
                }
            }
        }

        return $list;
    }

    public function save()
    {
        $data = $this->validate();

        $valid = collect($this->periodesDisponibles())
            ->first(fn ($p) =>
                $p['nom'] === $this->nom &&
                (int)$p['ordre'] === (int)$this->ordre
            );

        if (!$valid) {
            session()->flash('error', 'Cette période n’est pas disponible.');
            return;
        }

        Periode::create([
            'annee_scolaire_id' => $data['annee_scolaire_id'],
            'type' => $data['type'],
            'nom' => $data['nom'],
            'ordre' => $data['ordre'],
            'statut' => 'inactive',
        ]);

        session()->flash('message', 'Période créée avec succès.');

        return redirect('/periodes');
    }

    public function render()
    {
        return view('periodes.periode-create', [
            'annees' => AnneeScolaire::orderByDesc('id')->get(),
        ]);
    }
}