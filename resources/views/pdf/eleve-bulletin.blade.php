<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <style>
        @page { margin: 24px; }
        body { font-family: DejaVu Sans, sans-serif; color: #20252b; font-size: 10px; }
        h1 { text-align: center; font-size: 18px; margin: 0 0 4px; }
        h2 { font-size: 13px; color: #20252b; background: #ddd; padding: 7px; margin: 18px 0 6px; }
        .center { text-align: center; }
        .student { width: 100%; border-collapse: collapse; margin: 16px 0; }
        .student td { border: 1px solid #b9c7d8; padding: 6px; }
        .label { font-weight: bold; background: #f0f5fb; }
        .marks { width: 100%; border-collapse: collapse; }
        .marks th, .marks td { border: 1px solid #9aaec4; padding: 6px; text-align: center; }
        .marks th { background: #dceaff; color: #124d8d; }
        .marks td:first-child { text-align: left; }
        .total { margin-top: 12px; font-weight: bold; }
        .financial { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .financial td { border: 1px solid #b9c7d8; padding: 6px; }
    </style>
</head>
<body>
    <div class="center">
        <h1>REPUBLIQUE DU TCHAD</h1>
        <strong>Unite - Travail - Progres</strong><br>
        Ministere de l'Education Nationale<br>
        <strong>Lycee / College Exemple</strong><br><br>
        <h1>BULLETIN SCOLAIRE</h1>
        Annee scolaire : <strong>{{ $eleve->anneeScolaire?->scolaire_annee ?? '-' }}</strong>
    </div>

    <table class="student">
        <tr><td class="label">Nom</td><td>{{ $eleve->nom }}</td><td class="label">Prenom</td><td>{{ $eleve->prenom }}</td></tr>
        <tr><td class="label">Matricule</td><td>{{ $eleve->matricule }}</td><td class="label">Classe</td><td>{{ $eleve->classe?->name ?? '-' }}</td></tr>
        <tr><td class="label">Niveau</td><td>{{ $eleve->classe?->niveau?->libelle ?? '-' }}</td><td class="label">Date naissance</td><td>{{ $eleve->naissance ?? '-' }}</td></tr>
    </table>

    <h2>Resultats scolaires</h2>
    @php $totalPoints = 0; $totalCoefficients = 0; @endphp
    <table class="marks">
        <thead><tr><th>Matiere</th><th>Coefficient</th><th>Devoir</th><th>Composition</th><th>Moyenne</th><th>Observation</th></tr></thead>
        <tbody>
        @forelse($eleve->notes as $note)
            @php
                $devoir = (float) ($note->devoir ?? 0);
                $composition = (float) ($note->composition ?? 0);
                $coefficient = (float) ($note->matiere?->coefficient ?? 0);
                $moyenne = ($devoir + $composition) / 2;
                $totalPoints += $moyenne * $coefficient;
                $totalCoefficients += $coefficient;
            @endphp
            <tr>
                <td>{{ $note->matiere?->description ?? '-' }}</td>
                <td>{{ $coefficient }}</td><td>{{ $note->devoir ?? '-' }}</td><td>{{ $note->composition ?? '-' }}</td>
                <td>{{ number_format($moyenne, 2, ',', ' ') }}</td>
                <td>{{ $moyenne >= 10 ? 'Admis' : 'Insuffisant' }}</td>
            </tr>
        @empty
            <tr><td colspan="6">Aucune note enregistree.</td></tr>
        @endforelse
        </tbody>
    </table>
    <p class="total">Moyenne generale : {{ $totalCoefficients ? number_format($totalPoints / $totalCoefficients, 2, ',', ' ') : '0,00' }} / 20</p>
    @php
        $frais = (float) ($eleve->classe?->niveau?->montant ?? 0);
        $paye = (float) $eleve->paiements->sum('montant');
    @endphp
    <table class="financial">
        <tr><td class="label">Frais de scolarite</td><td>{{ number_format($frais, 0, ',', ' ') }} FCFA</td><td class="label">Paye</td><td>{{ number_format($paye, 0, ',', ' ') }} FCFA</td><td class="label">Reste</td><td>{{ number_format(max(0, $frais - $paye), 0, ',', ' ') }} FCFA</td></tr>
    </table>
    <h2>Appreciation generale</h2>
    <p style="border: 1px solid #000; padding: 12px;">Eleve serieux et travailleur.<br>Les resultats sont satisfaisants.<br>Il doit continuer ses efforts.</p>
    <table style="margin-top: 35px; text-align: center;">
        <tr><td>Professeur Principal<br><br><br>Signature</td><td>Directeur / Proviseur<br><br><br>Signature</td><td>Parent<br><br><br>Signature</td></tr>
    </table>
</body>
</html>
