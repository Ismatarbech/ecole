<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <style>
        @page { margin: 28px; }
        body { font-family: DejaVu Sans, sans-serif; color: #20252b; font-size: 12px; }
        h1 { text-align: center; font-size: 19px; margin: 0 0 4px; }
        h2 { font-size: 14px; background: #ddd; color: #20252b; padding: 8px; margin: 20px 0 8px; border: 1px solid #000; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 15px; }
        .header p { margin: 5px; }
        .school { font-size: 18px; font-weight: bold; }
        .sub { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        td { border: 1px solid #b9c7d8; padding: 8px; vertical-align: top; }
        .label { width: 25%; font-weight: bold; background: #f5f8fc; }
        .photo { width: 90px; height: 110px; object-fit: cover; border: 1px solid #b9c7d8; }
    </style>
</head>
<body>
    <div class="header">
        <h1>REPUBLIQUE DU TCHAD</h1>
        <p><strong>Unite - Travail - Progres</strong></p>
        <p>Ministere de l'Education Nationale</p>
        <div class="school">Lycee / College Exemple</div>
        <p>FICHE D'INSCRIPTION</p>
        <p>Annee scolaire : <strong>{{ $eleve->anneeScolaire?->scolaire_annee ?? '-' }}</strong></p>
    </div>
    <h1>FICHE D'INFORMATION DE L'ELEVE</h1>
    <h2>Informations de l'eleve</h2>
    @if ($eleve->photo && file_exists(storage_path('app/public/' . $eleve->photo)))
        <p><img class="photo" src="{{ storage_path('app/public/' . $eleve->photo) }}" alt="Photo de l'eleve"></p>
    @endif
    <table>
        <tr><td class="label">Matricule</td><td>{{ $eleve->matricule }}</td><td class="label">Nom</td><td>{{ $eleve->nom }}</td></tr>
        <tr><td class="label">Prenom</td><td>{{ $eleve->prenom }}</td><td class="label">Sexe</td><td>{{ $eleve->sexe }}</td></tr>
        <tr><td class="label">Naissance</td><td>{{ $eleve->naissance }}</td><td class="label">Lieu</td><td>{{ $eleve->lieu }}</td></tr>
        <tr><td class="label">Classe</td><td>{{ $eleve->classe?->name ?? '-' }}</td><td class="label">Niveau</td><td>{{ $eleve->classe?->niveau?->libelle ?? '-' }}</td></tr>
        <tr><td class="label">Date inscription</td><td>{{ $eleve->date_inscription ?? '-' }}</td><td class="label">Contact eleve</td><td>{{ $eleve->contact_eleve }}</td></tr>
        <tr><td class="label">Contact parent</td><td colspan="3">{{ $eleve->contact_parent }}</td></tr>
    </table>
    <h2>Informations financieres</h2>
    @php
        $frais = (float) ($eleve->classe?->niveau?->montant ?? 0);
        $paye = (float) $eleve->paiements->sum('montant');
    @endphp
    <table>
        <tr><td class="label">Frais de scolarite</td><td>{{ number_format($frais, 0, ',', ' ') }} FCFA</td><td class="label">Montant paye</td><td>{{ number_format($paye, 0, ',', ' ') }} FCFA</td></tr>
        <tr><td class="label">Reste a payer</td><td colspan="3">{{ number_format(max(0, $frais - $paye), 0, ',', ' ') }} FCFA</td></tr>
    </table>
    @if ($eleve->paiements->isNotEmpty())
        <p><strong>Historique des paiements</strong></p>
        <table>
            <tr><td class="label">Date</td><td class="label">Montant</td><td class="label">Mode</td></tr>
            @foreach ($eleve->paiements as $paiement)
                <tr><td>{{ $paiement->date_paiement?->format('d/m/Y') ?? '-' }}</td><td>{{ number_format((float) $paiement->montant, 0, ',', ' ') }} FCFA</td><td>{{ $paiement->mode_paiement ?? '-' }}</td></tr>
            @endforeach
        </table>
    @endif
    <h2>Declaration</h2>
    <p style="border: 1px solid #000; padding: 15px;">Je soussigne(e), parent ou tuteur de l'eleve <strong>{{ $eleve->nom }} {{ $eleve->prenom }}</strong>, certifie que les informations fournies dans cette fiche sont exactes et m'engage a respecter le reglement interieur de l'etablissement.</p>
    <table style="margin-top: 45px; text-align: center;">
        <tr><td>Parent / Tuteur<br><br><br>Signature</td><td>Service de scolarite<br><br><br>Signature</td><td>Directeur / Proviseur<br><br><br>Signature et cachet</td></tr>
    </table>
</body>
</html>
