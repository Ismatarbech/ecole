<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">

<style>
@page { margin: 20px 25px; }

body {
    font-family: DejaVu Sans, Arial, sans-serif;
    font-size: 10px;
    color: #000;
}

.header { text-align: center; margin-bottom: 10px; }
.header .periode-title { font-size: 11px; font-weight: bold; text-transform: uppercase; }
.header h2 { margin: 0; font-size: 14px; font-weight: bold; text-transform: uppercase; }
.header small { font-size: 9px; display: block; margin-top: 2px; }

.header-divider { border-top: 1.5px solid #000; margin: 10px 0 15px 0; }

.section-title { font-weight: bold; font-size: 11px; margin: 12px 0 6px 0; }

.box { border: 1px solid #000; padding: 8px; margin-bottom: 12px; }

.info-grid { width: 100%; }
.info-grid td { width: 50%; padding: 3px 0; }

table.data-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 10px;
}

table.data-table th,
table.data-table td {
    border: 1px solid #000;
    padding: 6px;
    font-size: 9px;
    text-align: center;
}

table.data-table th {
    background-color: #e0e0e0;
}

.badge {
    display: inline-block;
    padding: 3px 8px;
    background-color: #ffcc00;
    font-weight: bold;
    font-size: 8px;
}

.signature-container { margin-top: 30px; width: 100%; }
.signature-container td { text-align: center; width: 33.33%; }
.signature-space { height: 40px; }

.cachet { text-align: center; margin-top: 20px; font-weight: bold; }

.bottom-line { border-top: 1px solid #ccc; margin-top: 20px; }
</style>

</head>

<body>

@php
    $moyennes = [];
@endphp

{{-- ================= PERIODES ================= --}}
@foreach ($eleve->anneeScolaire->periodes->where('statut','active')->sortBy('ordre') as $periode)

<div class="header">
    <div class="periode-title">
        {{ strtoupper($periode->type) }} {{ $periode->ordre }} - {{ $periode->nom }}
    </div>
    <h2>RÉPUBLIQUE DU TCHAD</h2>
    <small>Unité - Travail - Progrès</small>
    <small>Ministère de l'Éducation Nationale</small>
    <small>Année scolaire : <strong>{{ $eleve->anneeScolaire?->scolaire_annee }}</strong></small>
</div>

<hr class="header-divider">

<div class="section-title">Informations de l'élève</div>

<div class="box">
<table class="info-grid">
<tr>
    <td><strong>Nom :</strong> {{ $eleve->nom }}</td>
    <td><strong>Prénom :</strong> {{ $eleve->prenom }}</td>
</tr>
<tr>
    <td><strong>Classe :</strong> {{ $eleve->classe?->name }}</td>
    <td><strong>Matricule :</strong> {{ $eleve->matricule }}</td>
</tr>
<tr>
    <td><strong>Date de naissance :</strong> {{ $eleve->naissance }}</td>
    <td><strong>Effectif :</strong> {{ $effectif }}</td>
</tr>
</table>
</div>

<div class="section-title">Résultats scolaires</div>

@php
    $notes = $eleve->notes->where('periode_id', $periode->id);
    $total = 0;
    $coefTotal = 0;
@endphp

<table class="data-table">
<thead>
<tr>
    <th>Matière</th>
    <th>Devoir</th>
    <th>Composition</th>
    <th>Coef</th>
    <th>Moyenne</th>
    <th>Observation</th>
</tr>
</thead>

<tbody>
@forelse($notes as $note)
    @php
        $coef = $note->matiere?->coefficient ?? 0;
        $moy = ($note->devoir + $note->composition) / 2;

        $total += $moy * $coef;
        $coefTotal += $coef;
    @endphp

    <tr>
        <td>{{ $note->matiere?->nom }}</td>
        <td>{{ number_format($note->devoir,2) }}</td>
        <td>{{ number_format($note->composition,2) }}</td>
        <td>{{ $coef }}</td>
        <td>{{ number_format($moy,2) }}</td>
        <td>
            <span class="badge">
                @if ($moy >= 16) Très bien
                @elseif ($moy >= 14) Bien
                @elseif ($moy >= 12) Assez bien
                @elseif ($moy >= 10) Passable
                @else Insuffisant
                @endif
            </span>
        </td>
    </tr>
@empty
<tr>
    <td colspan="6">Aucune note</td>
</tr>
@endforelse
</tbody>
</table>

@php
    $moyenneG = $coefTotal ? ($total / $coefTotal) : 0;
    $moyennes[$periode->ordre] = $moyenneG;
@endphp

<table class="data-table">
<tr>
    <th>Total</th>
    <th>Moyenne</th>
    <th>Rang</th>
    <th>Absences</th>
</tr>
<tr>
    <td>{{ number_format($total,2) }}</td>
    <td><strong>{{ number_format($moyenneG,2) }}</strong></td>
    <td>{{ $rang }} / {{ $effectif }}</td>
    <td>0</td>
</tr>
</table>

{{-- ================= SYNTHESE CONDITIONNELLE ================= --}}
@php
    $showSynthese = false;

    // 👉 TRIMESTRE → seulement T3
    if ($periode->type === 'trimestre' && $periode->ordre == 3 && count($moyennes) >= 3) {
        $showSynthese = true;
    }

    // 👉 SEMESTRE → seulement S2
    if ($periode->type === 'semestre' && $periode->ordre == 2 && count($moyennes) >= 2) {
        $showSynthese = true;
    }
@endphp

@if ($showSynthese)

@php
    $t1 = $moyennes[1] ?? 0;
    $t2 = $moyennes[2] ?? 0;
    $t3 = $moyennes[3] ?? 0;

    if ($periode->type === 'trimestre') {
        $moyenneAnnuelle = ($t1 + $t2 + $t3) / 3;
    } else {
        $moyenneAnnuelle = ($t1 + $t2) / 2;
    }
@endphp

<div class="section-title">Synthèse annuelle</div>

<table class="data-table">
<thead>
@if ($periode->type === 'trimestre')
<tr>
    <th>Trimestre 1</th>
    <th>Trimestre 2</th>
    <th>Trimestre 3</th>
    <th>Moyenne annuelle</th>
</tr>
@else
<tr>
    <th>Semestre 1</th>
    <th>Semestre 2</th>
    <th>Moyenne annuelle</th>
</tr>
@endif
</thead>

<tbody>
@if ($periode->type === 'trimestre')
<tr>
    <td>{{ number_format($t1,2) }}</td>
    <td>{{ number_format($t2,2) }}</td>
    <td>{{ number_format($t3,2) }}</td>
    <td><strong>{{ number_format($moyenneAnnuelle,2) }}</strong></td>
</tr>
@else
<tr>
    <td>{{ number_format($t1,2) }}</td>
    <td>{{ number_format($t2,2) }}</td>
    <td><strong>{{ number_format($moyenneAnnuelle,2) }}</strong></td>
</tr>
@endif
</tbody>
</table>

{{-- SIGNATURES --}}
<table class="signature-container">
<tr>
    <td>Professeur Principal</td>
    <td>Directeur</td>
    <td>Parent</td>
</tr>

<tr class="signature-space">
    <td></td><td></td><td></td>
</tr>

<tr>
    <td>Signature</td>
    <td>Signature</td>
    <td>Signature</td>
</tr>
</table>

<div class="cachet">Cachet de l'établissement</div>

@endif

<hr class="bottom-line">

@endforeach

</body>
</html>