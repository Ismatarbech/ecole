<style>

    body {
        font-family: Arial, sans-serif;
        background: #f6f9ff;
    }

    .card-container {
        display: flex;
        gap: 30px;
        justify-content: center;
        align-items: center;
        margin-top: 50px;
        flex-wrap: wrap;
    }

    .student-card {
        width: 340px;
        height: 215px;
        background: #fff;
        border: 1px solid #000;
        border-radius: 10px;
        overflow: hidden;
        position: relative;
    }

    .card-header {
        text-align: center;
        border-bottom: 1px solid #000000;
        padding: 1px;
        font-size: 11px;
    }

    .card-header strong {
        font-size: 13px;
    }

    .card-title {
        font-weight: bold;
        font-size: 14px;
        margin-top: 0.1px;
    }

    .card-body {
        display: flex;
        padding: 1px;
        gap: 12px;
    }

    .student-photo {
        width: 75px;
        height: 90px;
        border: 1px solid #000;
        object-fit: cover;
    }

    .student-details {
        font-size: 11px;
        line-height: 1.7;
    }

    .student-details strong {
        font-weight: bold;
    }

    .card-footer {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        border-top: 1px solid #000;
        padding: 5px;
        text-align: center;
        font-size: 9px;
    }

    .signature-card {
        text-align: right;
        font-size: 9px;
        padding-right: 12px;
    }

    .actions {
        text-align: center;
        margin: 20px;
    }

    @media print {

        body {
            background: #fff;
        }

        .actions {
            display: none;
        }

        .card-container {
            margin-top: 10px;
        }

        .student-card {
            box-shadow: none;
        }

    }

</style>


<div>

    {{-- Bouton impression --}}
    <div class="actions">

        <button onclick="window.print()" class="btn btn-primary">

            <i class="bi bi-printer"></i>

            Imprimer la carte

        </button>

    </div>


    <div class="card-container">


        {{-- ========================= --}}
        {{-- RECTO --}}
        {{-- ========================= --}}

        <div class="student-card">

            <div class="card-header">

                RÉPUBLIQUE DU TCHAD
                <br>

                <strong>
                    Unité - Travail - Progrès
                </strong>

                <div class="card-title">
                    CARTE D'ÉLÈVE
                </div>

            </div>


            <div class="card-body">

                {{-- Photo --}}

                <div>


                        <img
                            src="{{ asset('/storage/' . $eleve->photo) }}"
                            class="student-photo">


                        <div
                            class="student-photo d-flex align-items-center justify-content-center">

                            Photo

                        </div>


                </div>


                {{-- Informations --}}

                <div class="student-details">

                    <div>
                        <strong>Matricule :</strong>
                         {{ $eleve->matricule }}
                    </div>

                    <div>
                        <strong>Nom :</strong>
                        {{ $eleve->nom }}
                    </div>

                    <div>
                        <strong>Prénom :</strong>
                         {{ $eleve->prenom }}
                    </div>

                    <div>
                        <strong>Classe :</strong>
                        {{ $eleve->classe->name }}
                    </div>

                    <div>
                        <strong>Année :</strong>
                        {{ $eleve->anneeScolaire->scolaire_annee }}

                    </div>

                    <div>
                        <strong>Tél :</strong>
                          {{ $eleve->contact_eleve }}
                    </div>

                </div>

            </div>


            <div class="signature-card">

                Signature du responsable

            </div>


            <div class="card-footer">

                Lycée / Collège Exemple
                -
                Carte valable pour l'année scolaire


            </div>

        </div>


        {{-- ========================= --}}
        {{-- VERSO --}}
        {{-- ========================= --}}

        <div class="student-card">

            <div class="card-header">

                <strong>
                    INFORMATIONS IMPORTANTES
                </strong>

            </div>

            <div style="padding: 15px; font-size: 11px; line-height: 1.7 text-center;">

                <strong class="card-title">College et lycée : .........</strong>
                <br>
                <br>
                <br>
                <br>
                <hr>

              


               Cette carte est personnelle et ne peut être
                utilisée par une autre personne.

            </div>

            <div class="card-footer">

                Signature et cachet de l'établissement

            </div>

        </div>

    </div>

</div>