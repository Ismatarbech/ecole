<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <style>
        @page { margin: 18px; }
        body { font-family: DejaVu Sans, sans-serif; color: #20252b; }
        .card { border: 2px solid #1456a0; border-radius: 8px; padding: 18px; height: 230px; margin-bottom: 20px; }
        h1 { color: #1456a0; font-size: 17px; text-align: center; margin: 0 0 16px; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 7px 4px; vertical-align: top; }
        .label { width: 28%; font-weight: bold; color: #1456a0; }
        .footer { margin-top: 18px; text-align: center; font-size: 10px; color: #555; }
        .photo { width: 65px; height: 75px; object-fit: cover; float: right; border: 1px solid #b9c7d8; }
    </style>
</head>
<body>
    <div class="card">
        <h1>CARTE SCOLAIRE</h1>
        @if ($eleve->photo && file_exists(storage_path('app/public/' . $eleve->photo)))
            <img class="photo" src="{{ storage_path('app/public/' . $eleve->photo) }}" alt="Photo de l'eleve">
        @endif
        <table>
            <tr><td class="label">Nom</td><td>{{ $eleve->nom }}</td></tr>
            <tr><td class="label">Prenom</td><td>{{ $eleve->prenom }}</td></tr>
            <tr><td class="label">Matricule</td><td>{{ $eleve->matricule }}</td></tr>
            <tr><td class="label">Classe</td><td>{{ $eleve->classe?->name ?? '-' }}</td></tr>
            <tr><td class="label">Annee scolaire</td><td>{{ $eleve->anneeScolaire?->scolaire_annee ?? '-' }}</td></tr>
        </table>
        <div class="footer">Document officiel de l'etablissement</div>
    </div>
    <div class="card">
        <h1>INFORMATIONS IMPORTANTES</h1>
        <p><strong>College et lycee : .........</strong></p>
        <p>Cette carte est personnelle et ne peut etre utilisee par une autre personne.</p>
        <p style="margin-top: 70px; text-align: right;">Signature et cachet de l'etablissement</p>
    </div>
</body>
</html>
