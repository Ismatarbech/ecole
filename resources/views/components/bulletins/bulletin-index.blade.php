    <style>

        body {
            font-family: Arial, sans-serif;
            color: #000;
            background: #f6f9ff;
        }

        .bulletin-container {
            background: #fff;
            padding: 30px;
            margin: 30px auto;
            max-width: 1100px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.08);
        }

        /* En-tête */

        .bulletin-header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
        }

        .bulletin-header h4 {
            margin: 5px;
            font-weight: bold;
        }

        .bulletin-header p {
            margin: 5px;
        }

        .school-info {
            text-align: center;
            font-size: 14px;
            margin-top: 10px;
        }

        .school-name {
            font-size: 18px;
            font-weight: bold;
        }

        /* Informations élève */

        .section-title {
            margin-top: 25px;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .student-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            border: 1px solid #000;
            padding: 12px;
        }

        .student-info div {
            padding: 5px;
        }

        /* Table */

        .bulletin-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .bulletin-table,
        .bulletin-table th,
        .bulletin-table td {
            border: 1px solid #000;
        }

        .bulletin-table th {
            background: #ddd;
            text-align: center;
            font-weight: bold;
            padding: 8px;
        }

        .bulletin-table td {
            padding: 8px;
            text-align: center;
        }

        /* Appréciation */

        .appreciation {
            margin-top: 15px;
            border: 1px solid #000;
            padding: 15px;
            min-height: 100px;
        }

        /* Signatures */

        .signature {
            margin-top: 60px;
            display: flex;
            justify-content: space-between;
            text-align: center;
        }

        .signature div {
            width: 30%;
        }

        .cachet {
            margin-top: 50px;
            text-align: center;
        }

        /* Boutons */

        .actions {
            max-width: 1100px;
            margin: 20px auto;
            text-align: right;
        }

        /* Impression */

        @media print {

            body {
                background: #fff;
            }

            .bulletin-container {
                margin: 0;
                padding: 10px;
                box-shadow: none;
                max-width: 100%;
            }

            .actions,
            .back-to-top {
                display: none !important;
            }

            .bulletin-table {
                page-break-inside: avoid;
            }

        }

        /* Responsive */

        @media (max-width: 768px) {

            .bulletin-container {
                margin: 10px;
                padding: 15px;
            }

            .student-info {
                grid-template-columns: 1fr;
            }

            .signature {
                flex-direction: column;
                gap: 40px;
            }

            .signature div {
                width: 100%;
            }

        }

    </style>

</head>


<body>

<div>
<!-- Bouton impression -->

<div class="actions">

    <button onclick="window.print()" class="btn btn-primary">
        <i class="bi bi-printer"></i>
        Imprimer le bulletin
    </button>

</div>


<!-- Bulletin -->

<div class="bulletin-container">


    <!-- ========================= -->
    <!-- EN-TÊTE -->
    <!-- ========================= -->

    <div class="bulletin-header">

        <h4>RÉPUBLIQUE DU TCHAD</h4>

        <p>
            <strong>Unité - Travail - Progrès</strong>
        </p>

        <div class="school-info">

            Ministère de l'Éducation Nationale
            <br>

            <span class="school-name">
                Lycée / Collège Exemple
            </span>

            <br>

            Année scolaire :
            <strong>2025 - 2026</strong>

        </div>

    </div>


    <!-- ========================= -->
    <!-- INFORMATIONS ÉLÈVE -->
    <!-- ========================= -->

    <h5 class="section-title">
        Informations de l'élève
    </h5>


    <div class="student-info">

        <div>
            <strong>Nom :</strong>
            Mahamat Issa
        </div>

        <div>
            <strong>Prénom :</strong>
            Tahir
        </div>

        <div>
            <strong>Classe :</strong>
            Terminale D
        </div>

        <div>
            <strong>Matricule :</strong>
            20260001
        </div>

        <div>
            <strong>Date de naissance :</strong>
            01/01/2008
        </div>

        <div>
            <strong>Effectif :</strong>
            45 élèves
        </div>

    </div>


    <!-- ========================= -->
    <!-- RÉSULTATS SCOLAIRES -->
    <!-- ========================= -->

    <h5 class="section-title">
        Résultats scolaires
    </h5>


    <table class="bulletin-table">

        <thead>

            <tr>

                <th>Matière</th>

                <th>Coefficient</th>

                <th>Composition /20</th>

                <th>Devoir /20</th>

                <th>Moyenne</th>

                <th>Observation</th>

            </tr>

        </thead>


        <tbody>

            <tr>

                <td>Français</td>

                <td>3</td>

                <td>15</td>

                <td>15</td>

                <td>15</td>

                <td>Très bien</td>

            </tr>


            <tr>

                <td>Mathématiques</td>

                <td>4</td>

                <td>14</td>

                <td>14</td>

                <td>14</td>

                <td>Bon travail</td>

            </tr>


            <tr>

                <td>Anglais</td>

                <td>2</td>

                <td>13</td>

                <td>13</td>

                <td>13</td>

                <td>Satisfaisant</td>

            </tr>


            <tr>

                <td>Physique Chimie</td>

                <td>3</td>

                <td>16</td>

                <td>16</td>

                <td>16</td>

                <td>Excellent</td>

            </tr>


            <tr>

                <td>SVT</td>

                <td>2</td>

                <td>12</td>

                <td>12</td>

                <td>12</td>

                <td>Peut mieux faire</td>

          
        </tbody>

    </table>




    <table class="bulletin-table">

        <thead>

            <tr>

                <th>Total Points</th>

                <th>Moyenne générale</th>

                <th>Rang</th>

                <th>Absences</th>

            </tr>

        </thead>


        <tbody>

            <tr>

                <td>245</td>

                <td>14.50 /20</td>

                <td>5ème</td>

                <td>2</td>

            </tr>

        </tbody>

    </table>


    <!-- ========================= -->
    <!-- APPRÉCIATION -->
    <!-- ========================= -->

    <h5 class="section-title">
        Appréciation générale
    </h5>


    <div class="appreciation">

        Élève sérieux et travailleur.
        <br>

        Les résultats sont satisfaisants.
        <br>

        Il doit continuer ses efforts.

    </div>


    <!-- ========================= -->
    <!-- SIGNATURES -->
    <!-- ========================= -->

    <div class="signature">


        <div>

            <strong>Professeur Principal</strong>

            <br><br><br>

            Signature

        </div>


        <div>

            <strong>Directeur / Proviseur</strong>

            <br><br><br>

            Signature

        </div>


        <div>

            <strong>Parent</strong>

            <br><br><br>

            Signature

        </div>


    </div>


    <!-- ========================= -->
    <!-- CACHET -->
    <!-- ========================= -->

    <div class="cachet">

        <br><br>

        <strong>Cachet de l'établissement</strong>

    </div>


</div>


<!-- ========================= -->
<!-- VENDOR JS FILES -->
<!-- ========================= -->

<a href="#"
   class="back-to-top d-flex align-items-center justify-content-center">

    <i class="bi bi-arrow-up-short"></i>

</a>
</div>

