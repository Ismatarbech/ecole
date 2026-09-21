<?php

namespace App\Exports;

use App\Models\AnneeScolaire;
use App\Models\Eleve;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ElevesExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(private readonly int|string $classeId)
    {
    }

    public function collection(): Collection
    {
        $anneeActive = AnneeScolaire::where('status', 'active')->first();

        return Eleve::with(['classe', 'anneeScolaire'])
            ->where('classe_id', $this->classeId)
            ->when($anneeActive, fn ($query) => $query->where('annee_scolaire_id', $anneeActive->id))
            ->orderBy('nom')
            ->orderBy('prenom')
            ->get();
    }

    public function headings(): array
    {
        return ['Matricule', 'Nom', 'Prénom', 'Sexe', 'Date de naissance', 'Classe', 'Année scolaire'];
    }

    public function map($eleve): array
    {
        return [
            $eleve->matricule,
            $eleve->nom,
            $eleve->prenom,
            $eleve->sexe,
            $eleve->naissance?->format('d/m/Y'),
            $eleve->classe?->name,
            $eleve->anneeScolaire?->scolaire_annee,
        ];
    }
}
