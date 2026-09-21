<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <style>
        @page { margin: 15px; }
        * { box-sizing: border-box; }
        body { font-family: DejaVu Sans, sans-serif; color: #20252b; margin: 0; padding: 0; }
        
        .card { 
            border: 2px solid #002664;
            border-radius: 8px; 
            height: 215px; 
            width: 330px;
            margin-bottom: 20px; 
            overflow: hidden;
            position: relative;
            background: #ffffff;
        }

        /* --- LOGO EN BACKGROUND UNIQUEMENT SUR LE VERSO --- */
        .bg-watermark {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
            object-position: center;
            opacity: 0.06;
            z-index: 1;
            pointer-events: none;
        }

        .card > *:not(.bg-watermark) {
            position: relative;
            z-index: 2;
        }

        /* --- GRAND DRAPEAU DU TCHAD --- */
        .chad-flag {
            width: 100%;
            height: 16px;
            display: table;
            table-layout: fixed;
        }
        .flag-blue { display: table-cell; background-color: #002664; width: 33.33%; }
        .flag-yellow { display: table-cell; background-color: #FECB00; width: 33.33%; }
        .flag-red { display: table-cell; background-color: #C8102E; width: 33.33%; }

        /* --- EN-TÊTE RECTO (Sans logo) --- */
        .recto-header {
            text-align: center;
            padding: 10px 2px 6px;
            background-color: #002664;
            color: #ffffff;
        }
        .recto-header h2 { font-size: 8.5px; text-transform: uppercase; margin: 0; color: #dbeafe; font-weight: bold; }
        .recto-header p { font-size: 8px; font-weight: bold; margin: 1px 0; color: #fecb00; }
        .recto-header h1 { font-size: 12.5px; text-transform: uppercase; margin: 4px 0 0; color: #ffffff; font-weight: bold; letter-spacing: 0.5px; }

        /* --- CORPS RECTO --- */
        .recto-body {
            padding: 8px;
            display: table;
            width: 100%;
        }
        .photo-cell {
            display: table-cell;
            width: 85px;
            vertical-align: top;
        }
        .photo { 
            width: 80px; 
            height: 92px; 
            object-fit: cover; 
            border: 1.5px solid #002664; 
            border-radius: 3px;
        }
        .info-cell {
            display: table-cell;
            vertical-align: top;
            padding-left: 8px;
        }
        
        table.info-table { width: 100%; border-collapse: collapse; }
        table.info-table td { padding: 2px 0; font-size: 9.5px; vertical-align: top; color: #20252b; }
        .label { font-weight: bold; color: #002664; width: 45%; }

        .signature-resp {
            position: absolute;
            bottom: 24px;
            right: 8px;
            font-size: 7.5px;
            color: #555;
        }

        /* --- PIED DE PAGE --- */
        .footer { 
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            border-top: 1px solid #002664; 
            text-align: center; 
            font-size: 8px; 
            padding: 3px; 
            background-color: #002664;
            color: #ffffff;
            font-weight: bold;
        }

        /* --- EN-TÊTE VERSO --- */
        .verso-header {
            text-align: center;
            padding: 5px;
            background-color: #002664;
            font-weight: bold;
            font-size: 10.5px;
            color: #ffffff;
            letter-spacing: 0.5px;
        }

        .verso-body {
            padding: 8px 12px;
            font-size: 9px;
            color: #20252b;
            text-align: center;
        }
        
        /* Logo plus grand et bien centré sur le verso */
        .verso-logo {
            width: 65px;
            height: 65px;
            object-fit: contain;
            margin: 0 auto 3px auto;
            display: block;
        }

        /* Nom de l'établissement plus grand et centré */
        .verso-school-name {
            font-size: 12.5px;
            font-weight: bold;
            color: #002664;
            text-transform: uppercase;
            margin: 0 0 4px 0;
            text-align: center;
        }

        .verso-body p { margin: 3px 0; text-align: left; }
        .divider { border-bottom: 1px solid #cbd5e1; margin: 4px 0; }
        .signature-verso { margin-top: 10px; font-size: 8px; color: #475569; }
    </style>
</head>
<body>

    <div class="card">
        <div class="recto-header">
            <h2>REPUBLIQUE DU TCHAD</h2>
            <p>Unite - Travail - Progres</p>
            <h1>CARTE D'ELEVE</h1>
        </div>

        <div class="recto-body">
            <div class="photo-cell">
                @if ($eleve->photo && file_exists(storage_path('app/public/' . $eleve->photo)))
                    <img class="photo" src="{{ storage_path('app/public/' . $eleve->photo) }}" alt="Photo de l'eleve">
                @endif
            </div>
            <div class="info-cell">
                <table class="info-table">
                    <tr><td class="label">Matricule :</td><td>{{ $eleve->matricule }}</td></tr>
                    <tr><td class="label">Nom :</td><td>{{ $eleve->nom }}</td></tr>
                    <tr><td class="label">Prenom :</td><td>{{ $eleve->prenom }}</td></tr>
                    <tr><td class="label">Classe :</td><td>{{ $eleve->classe?->name ?? '-' }}</td></tr>
                    <tr><td class="label">Annee :</td><td>{{ $eleve->anneeScolaire?->scolaire_annee ?? '-' }}</td></tr>
                    <tr><td class="label">Telephone :</td><td>{{ $eleve->contact_parent ?? '' }}</td></tr>
                </table>
            </div>
        </div>

        <div class="footer">{{ $etablissement?->nom ?? 'Etablissement scolaire' }} - Carte valable pour une année scolaire</div>
    </div>

    <div class="card">
        @if ($etablissement?->logo && file_exists(storage_path('app/public/' . $etablissement->logo)))
            <img class="bg-watermark" src="{{ storage_path('app/public/' . $etablissement->logo) }}" alt="Filigrane fond de carte">
        @endif

        <div class="chad-flag">
            <div class="flag-blue"></div>
            <div class="flag-yellow"></div>
            <div class="flag-red"></div>
        </div>

        <div class="verso-header">INFORMATIONS IMPORTANTES</div>

        <div class="verso-body">
            @if ($etablissement?->logo && file_exists(storage_path('app/public/' . $etablissement->logo)))
                <img class="verso-logo" src="{{ storage_path('app/public/' . $etablissement->logo) }}" alt="Logo de l'etablissement">
            @endif
            <div class="verso-school-name">{{ $etablissement?->nom ?? 'Etablissement scolaire' }}</div>
            <div class="divider"></div>
            <p>Cette carte est personnelle et ne peut etre utilisee par une autre.</p>
            <p class="signature-verso" class="text-center" >Signature et cachet de l'etablissement</p>
        </div>
        
        <div class="footer">Document officiel de {{ $etablissement?->nom ?? "l'etablissement" }}</div>
    </div>

</body>
</html>