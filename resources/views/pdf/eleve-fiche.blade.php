<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">

<style>
    @page {
        margin: 20px 25px;
    }

    body {
        font-family: DejaVu Sans, Arial, sans-serif;
        color: #000000;
        font-size: 10px;
        line-height: 1.3;
        background: #ffffff;
        position: relative;
    }

    /* =====================================================
       LOGO EN BACKGROUND (PLEINE PAGE)
    ====================================================== */
    .bg-watermark {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: contain;
        object-position: center;
        opacity: 0.06;
        z-index: -1000;
        pointer-events: none;
    }

    /* =====================================================
       HEADER
    ====================================================== */

    .header-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 4px;
    }

    .header-table td {
        border: none;
        padding: 0;
        vertical-align: middle;
        background: transparent;
    }

    /* =====================================================
       DRAPEAU DU TCHAD - GAUCHE
    ====================================================== */

    .flag-container {
        width: 20%;
        text-align: left;
        vertical-align: middle;
    }

    .chad-flag {
        width: 75px;
        height: auto;
        object-fit: contain;
        display: block;
    }

    /* =====================================================
       TEXTE - CENTRE (INCLUANT LE TITRE DE LA FICHE)
    ====================================================== */

    .header-center {
        width: 50%;
        text-align: center;
        vertical-align: middle;
    }

    .header-center h1 {
        font-size: 13px;
        color: #000000;
        text-transform: uppercase;
        margin: 0 0 2px 0;
        font-weight: bold;
    }

    .header-center p {
        margin: 2px 0;
        color: #000000;
        font-size: 9px;
    }

    .school {
        font-size: 11px;
        font-weight: bold;
        color: #000000;
        margin: 4px 0;
        text-transform: uppercase;
    }

    /* =====================================================
       TITRE DE LA FICHE (DANS LE BLOC CENTRAL)
    ====================================================== */

    .fiche-title {
        margin-top: 6px;
        text-align: center;
    }

    .fiche-title .main-title {
        font-size: 11px;
        font-weight: bold;
        text-decoration: underline;
        margin-bottom: 2px;
    }

    .fiche-title p {
        margin: 0;
        font-size: 9px;
    }

    /* =====================================================
       LOGO ÉTABLISSEMENT - DROITE (AGRANDI)
    ====================================================== */

    .logo-container {
        width: 30%;
        text-align: right;
        vertical-align: middle;
        border: none !important;
        background: transparent !important;
    }

    .school-logo {
        width: 160px;
        height: auto;
        max-height: 160px;
        object-fit: contain;
        display: block;
        margin-left: auto;
        margin-right: 0;
        padding: 0;
        border: none;
        background: transparent !important;
    }

    /* =====================================================
       TITRES DES SECTIONS
    ====================================================== */

    h2 {
        font-size: 10px;
        background: #d9d9d9;
        color: #000000;
        padding: 4px 6px;
        margin: 10px 0 6px;
        border: 1px solid #000000;
        font-weight: bold;
    }

    /* =====================================================
       PHOTO ÉLÈVE
    ====================================================== */

    .photo-container {
        margin-bottom: 10px;
        text-align: left;
    }

    .photo {
        width: 70px;
        height: 70px;
        object-fit: contain;
        border: 1px solid #000000;
        background: #ffffff;
    }

    /* =====================================================
       TABLEAUX
    ====================================================== */

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 8px;
    }

    td {
        border: 1px solid #000000;
        padding: 5px 6px;
        vertical-align: middle;
        font-size: 9.5px;
    }

    .label {
        font-weight: bold;
        color: #000000;
    }

    .table-header td {
        font-weight: bold;
        text-align: center;
    }

    .text-center {
        text-align: center;
    }

    /* =====================================================
       DÉCLARATION
    ====================================================== */

    .declaration-box {
        border: 1px solid #000000;
        padding: 8px;
        font-size: 9px;
        color: #000000;
        line-height: 1.4;
        margin-bottom: 30px;
    }

    /* =====================================================
       SIGNATURES
    ====================================================== */

    .signatures-container {
        width: 100%;
        margin-top: 20px;
    }

    .signatures-container td {
        border: none;
        text-align: center;
        vertical-align: top;
        padding: 0;
        font-size: 9.5px;
    }

    .signature-title {
        font-weight: bold;
        margin-bottom: 40px;
    }

    .signature-sub {
        color: #333333;
    }

</style>
</head>

<body>

<!-- =====================================================
     LOGO EN BACKGROUND (PLEINE PAGE)
====================================================== -->
@if (
    $etablissement?->logo &&
    file_exists(storage_path('app/public/' . $etablissement->logo))
)
    <img 
        class="bg-watermark" 
        src="{{ storage_path('app/public/' . $etablissement->logo) }}" 
        alt="Filigrane fond de page"
    >
@endif

<!-- =====================================================
     EN-TÊTE ET TITRE DE LA FICHE
====================================================== -->

<table class="header-table">
    <tr>
        <!-- ==============================
             DRAPEAU À GAUCHE
        =============================== -->
        <td class="flag-container">
            @if(file_exists(public_path('assets/img/tchad.png')))
                <img
                    class="chad-flag"
                    src="{{ public_path('assets/img/tchad.png') }}"
                    alt="Drapeau du Tchad"
                >
            @endif
        </td>

        <!-- ==============================
             TEXTE AU CENTRE + TITRE FICHE
        =============================== -->
        <td class="header-center">
            <h1>RÉPUBLIQUE DU TCHAD</h1>
            <p>
                <strong>
                    Unité - Travail - Progrès
                </strong>
            </p>
            <p>
                Ministère de l'Éducation Nationale
            </p>
            <div class="school">
                {{ $etablissement?->nom ?? 'Établissement scolaire' }}
            </div>

            <div class="fiche-title">
                <div class="main-title">
                    FICHE D'INSCRIPTION
                </div>
                <p>
                    Année scolaire :
                    <strong>
                        {{ $eleve->anneeScolaire?->scolaire_annee ?? '-' }}
                    </strong>
                </p>
            </div>
        </td>

        <!-- ==============================
             LOGO À DROITE (AGRANDI)
        =============================== -->
        <td class="logo-container">
            @if (
                $etablissement?->logo &&
                file_exists(
                    storage_path(
                        'app/public/' . $etablissement->logo
                    )
                )
            )
                <img
                    class="school-logo"
                    src="{{ storage_path('app/public/' . $etablissement->logo) }}"
                    alt="Logo de l'établissement"
                >
            @endif
        </td>
    </tr>
</table>


<!-- =====================================================
     PHOTO DE L'ÉLÈVE
====================================================== -->

<div class="photo-container" style="margin-top: 10px;">
    @if (
        $eleve->photo &&
        file_exists(
            storage_path(
                'app/public/' . $eleve->photo
            )
        )
    )
        <img
            class="photo"
            src="{{ storage_path('app/public/' . $eleve->photo) }}"
            alt="Photo de l'élève"
        >
    @else
        <div
            class="photo"
            style="
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: bold;
                font-size: 20px;
            "
        >
            S
        </div>
    @endif
</div>


<!-- =====================================================
     1. INFORMATIONS DE L'ÉLÈVE
====================================================== -->

<h2>1. Informations de l'élève</h2>

<table>
    <tr>
        <td style="width: 50%;">
            <span class="label">
                Matricule :
            </span>
            {{ $eleve->matricule }}
        </td>
        <td style="width: 50%;">
            <span class="label">
                Nom :
            </span>
            {{ $eleve->nom }}
        </td>
    </tr>
    <tr>
        <td>
            <span class="label">
                Prénom :
            </span>
            {{ $eleve->prenom }}
        </td>
        <td>
            <span class="label">
                Sexe :
            </span>
            {{ $eleve->sexe }}
        </td>
    </tr>
    <tr>
        <td>
            <span class="label">
                Date de naissance :
            </span>
            {{ $eleve->naissance }}
        </td>
        <td>
            <span class="label">
                Lieu de naissance :
            </span>
            {{ $eleve->lieu }}
        </td>
    </tr>
    <tr>
        <td>
            <span class="label">
                Classe :
            </span>
            {{ $eleve->classe?->name ?? '-' }}
        </td>
        <td>
            <span class="label">
                Date d'inscription :
            </span>
            {{ $eleve->date_inscription ?? '-' }}
        </td>
</table>


<!-- =====================================================
     2. INFORMATIONS DU PARENT / TUTEUR
====================================================== -->

<h2>2. Informations du parent / tuteur</h2>

<table>
    <tr>
        <td style="width: 50%;">
            <span class="label">
                Nom :
            </span>
            {{ $eleve->prenom ?? '-' }}
        </td>
        <td style="width: 50%;">
            <span class="label">
                Téléphone :
            </span>
            {{ $eleve->contact_parent ?? '-' }}
        </td>
    </tr>
</table>


<!-- =====================================================
     3. INFORMATIONS FINANCIÈRES
====================================================== -->

<h2>3. Informations financières</h2>

@php
    $frais = (float) (
        $eleve->classe?->niveau?->montant ?? 0
    );
    $paye = (float) (
        $eleve->paiements->sum('montant')
    );
    $reste = max(0, $frais - $paye);
@endphp

<table>
    <tr class="table-header">
        <td style="width: 33.33%;">
            Frais de scolarité
        </td>
        <td style="width: 33.33%;">
            Montant payé
        </td>
        <td style="width: 33.33%;">
            Reste à payer
        </td>
    </tr>
    <tr class="text-center">
        <td>
            {{ number_format($frais, 0, ',', ' ') }}
            FCFA
        </td>
        <td>
            {{ number_format($paye, 0, ',', ' ') }}
            FCFA
        </td>
        <td>
            {{ number_format($reste, 0, ',', ' ') }}
            FCFA
        </td>
    </tr>
</table>


<!-- =====================================================
     4. DÉCLARATION
====================================================== -->

<h2>4. Déclaration</h2>

<div class="declaration-box">
    Je soussigné(e), parent ou tuteur de l'élève
    <strong>
        {{ $eleve->nom }}
        {{ $eleve->prenom }}
    </strong>,
    certifie que les informations fournies dans cette fiche
    sont exactes et m'engage à respecter le règlement intérieur
    de l'établissement.
</div>


<!-- =====================================================
     SIGNATURES
====================================================== -->

<table class="signatures-container">
    <tr>
        <td style="width: 33.33%;">
            <div class="signature-title">
                Parent / Tuteur
            </div>
            <div class="signature-sub">
                Signature
            </div>
        </td>
        <td style="width: 33.33%;">
            <div class="signature-title">
                Service de scolarité
            </div>
            <div class="signature-sub">
                Signature
            </div>
        </td>
        <td style="width: 33.33%;">
            <div class="signature-title">
                Directeur / Proviseur
            </div>
            <div class="signature-sub">
                Signature et cachet
            </div>
        </td>
    </tr>
</table>

</body>
</html>