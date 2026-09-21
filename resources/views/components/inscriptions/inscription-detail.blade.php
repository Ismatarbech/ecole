<div>
<div class="pagetitle">
      <h1>Profile</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Accueil</a></li>
          <li class="breadcrumb-item">Eleve</li>
          <li class="breadcrumb-item active">Profile</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
    

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Information d'éléve</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-note">Bulletins</button>
                </li>

                 <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-carte">Carte d'eleve</button>
                </li>

              </ul>

              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                  
                    {{-- Bouton impression --}}
                            <div class="actionsi">
                                <a href="{{ route('inscription.pdf.fiche', $eleve->id) }}" class="btn btn-primary">
                                    <i class="bi bi-file-earmark-pdf"></i>
                                    Telecharger
                                </a>
                            </div>

                    <div class="fiche-containeri">

                        {{-- ========================= --}}
                        {{-- EN-TÊTE --}}
                        {{-- ========================= --}}

                        <div class="fiche-headeri">

                            <h4>RÉPUBLIQUE DU TCHAD</h4>

                            <p>
                                <strong>Unité - Travail - Progrès</strong>
                            </p>

                            <p>
                                Ministère de l'Éducation Nationale
                            </p>

                            <p>
                                FICHE D'INSCRIPTION
                            </p>

                            <p>
                                Année scolaire :
                                <strong>{{ $eleve->anneeScolaire?->scolaire_annee ?? '-' }}</strong>
                            </p>

                        </div>
                    

                        {{-- ========================= --}}
                        {{-- PHOTO --}}
                        {{-- ========================= --}}

                        <div class="photo-containeri">
                            @if ($eleve->photo)
                            <img src="{{ asset('/storage/' . $eleve->photo) }}" class="photoi" alt="Photo élève">
                            @else
                            <span class="text-muted">Aucune photo</span>
                            @endif
                        </div>


                        {{-- ========================= --}}
                        {{-- INFORMATIONS ÉLÈVE --}}
                        {{-- ========================= --}}

                        <div class="section-titlei">
                            1. Informations de l'élève
                        </div>

                        <div class="info-gridi">
                    

                            <div class="info-itemi">
                                <strong>Matricule :</strong>
                                {{ $eleve->matricule }}
                            </div>

                            <div class="info-itemi">
                                <strong>Nom :</strong>
                                {{ $eleve->nom }}

                            </div>

                            <div class="info-itemi">
                                <strong>Prénom :</strong>
                                {{ $eleve->prenom }}

                            </div>

                            <div class="info-itemi">
                                <strong>Sexe :</strong>
                                {{ $eleve->sexe }}

                            </div>

                            <div class="info-itemi">
                                <strong>Date de naissance :</strong>
                                {{ $eleve->naissance }}

                            </div>

                            <div class="info-itemi">
                                <strong>Lieu de naissance :</strong>
                                {{ $eleve->lieu }}

                            </div>

                            <div class="info-itemi">
                                <strong>Classe :</strong>
                                {{ $eleve->classe?->name ?? '-' }}

                            </div>

                            <div class="info-itemi">
                                <strong>Date d'inscription :</strong>
                                 {{ $eleve->date_inscription ?? '-' }}

                            </div>

                        </div>


                        {{-- ========================= --}}
                        {{-- PARENT / TUTEUR --}}
                        {{-- ========================= --}}

                        <div class="section-titlei">
                            2. Informations du parent / tuteur
                        </div>

                        <div class="info-gridi">

                            <div class="info-itemi">
                                <strong>Nom et prénom :</strong>
                                {{ $eleve->tuteur }}

                            </div>

                            <div class="info-itemi">
                                <strong>Téléphone :</strong>
                                {{ $eleve->contact_tuteur }}

                            </div>

                          

                        </div>


                        {{-- ========================= --}}
                        {{-- PAIEMENT --}}
                        {{-- ========================= --}}

                        <div class="section-titlei">
                            3. Informations financières
                        </div>

                        <table class="paiement-tablei">

                            <thead>
                                <tr>
                                    <th>Frais de scolarité</th>
                                    <th>Montant payé</th>
                                    <th>Reste à payer</th>
                                </tr>
                            </thead>

                            @php
                                $frais = (float) ($eleve->classe?->niveau?->montant ?? 0);

                                $paye = (float) $eleve->paiements()->sum('montant');

                                $reste = $frais - $paye;
                            @endphp

                        <tbody>
                            <tr>

                                {{-- FRAIS DE SCOLARITE --}}
                                <td>
                                    {{ number_format($frais, 0, ',', ' ') }} FCFA
                                </td>

                                {{-- TOTAL PAYE --}}
                                <td>
                                    {{ number_format($paye, 0, ',', ' ') }} FCFA
                                </td>

                                {{-- RESTE --}}
                                <td>
                                    <strong>
                                        {{ number_format(max(0, $reste), 0, ',', ' ') }} FCFA
                                    </strong>
                                </td>

                            </tr>
                        </tbody>
                                            
                        </table>


                        {{-- ========================= --}}
                        {{-- DÉCLARATION --}}
                        {{-- ========================= --}}

                        <div class="section-titlei">
                            4. Déclaration
                        </div>

                        <div class="declarationi">

                            Je soussigné(e), parent ou tuteur de l'élève
                            <strong>
                                
                            </strong>,
                            certifie que les informations fournies dans cette fiche
                            sont exactes et m'engage à respecter le règlement
                            intérieur de l'établissement.

                        </div>


                        {{-- ========================= --}}
                        {{-- SIGNATURES --}}
                        {{-- ========================= --}}

                        <div class="signaturesi">

                            <div>
                                <strong>Parent / Tuteur</strong>
                                <br><br><br>
                                Signature
                            </div>

                            <div>
                                <strong>Service de scolarité</strong>
                                <br><br><br>
                                Signature
                            </div>

                            <div>
                                <strong>Directeur / Proviseur</strong>
                                <br><br><br>
                                Signature et cachet
                            </div>

                        </div>

                </div>

               </div>

                                  
      <div class="tab-pane fade profile-note" id="profile-note">

    <!-- Bouton impression -->
    <div class="actions">
        <a href="{{ route('inscription.pdf.bulletin', $eleve->id) }}" class="btn btn-primary">
            <i class="bi bi-file-earmark-pdf"></i>
            Telecharger
        </a>
    </div>

    <!-- Bulletin -->
    <div class="bulletin-container">

        @foreach ($eleve->anneeScolaire->periodes->where('statut', 'active') as $periode)

            <!-- ========================= -->
            <!-- TITRE PERIODE -->
            <!-- ========================= -->

            <div style="text-align:center; font-weight:bold; font-size:18px; margin:10px 0;">
                {{ strtoupper($periode->type) }} {{ $periode->ordre }} - {{ $periode->nom }}
            </div>

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

                    Année scolaire :
                    <strong>{{ $eleve->anneeScolaire?->scolaire_annee ?? '-' }}</strong>

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
                    {{ $eleve->nom }}
                </div>

                <div>
                    <strong>Prénom :</strong>
                    {{ $eleve->prenom }}
                </div>

                <div>
                    <strong>Classe :</strong>
                    {{ $eleve->classe?->name ?? '-' }}
                </div>

                <div>
                    <strong>Matricule :</strong>
                    {{ $eleve->matricule }}
                </div>

                <div>
                    <strong>Date de naissance :</strong>
                    {{ $eleve->naissance }}
                </div>

                <div>
                    <strong>Effectif :</strong>
                    {{ $effectif }} élèves
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
                        <th>Devoir</th>
                        <th>Composition</th>
                        <th>Coefficient</th>
                        <th>Moyenne</th>
                        <th>Observation</th>
                    </tr>
                </thead>

                @php
                    $totalPoints = 0;
                    $totalCoefficients = 0;
                    $totalgenerale = 0;
                    $moyenneNote = 0;
                @endphp

                <tbody>

                    @forelse ($eleve->notes->where('periode_id', $periode->id) as $note)

                        @php
                            $devoir = (float) ($note->devoir ?? 0);
                            $composition = (float) ($note->composition ?? 0);
                            $coefficient = (float) ($note->matiere?->coefficient ?? 0);

                            $moyenneMatiere = (($devoir + $composition) / 2) * $coefficient;

                            $moyenneNote = (($devoir + $composition) / 2);

                            $totalPoints += $moyenneMatiere;
                            $totalCoefficients += $coefficient;

                            $totalgenerale = $totalCoefficients > 0
                                ? $totalPoints / $totalCoefficients
                                : 0;
                        @endphp

                        <tr>
                            <td>
                                {{ $note->matiere?->description ?? $note->matiere?->nom ?? '-' }}
                            </td>

                            <td>{{ $note->devoir ?? '-' }}</td>

                            <td>{{ $note->composition ?? '-' }}</td>

                            <td>{{ $coefficient }}</td>

                            <td>
                                <strong>
                                    {{ number_format($moyenneMatiere, 2, ',', ' ') }}
                                </strong>
                            </td>

                            <td>
                                @if ($moyenneNote >= 18)
                                    <span class="badge bg-success">Excellente</span>
                                @elseif ($moyenneNote >= 16)
                                    <span class="badge bg-warning text-dark">Tres bien</span>
                                @elseif ($moyenneNote >= 14)
                                    <span class="badge bg-warning text-dark">Bien</span>
                                @elseif ($moyenneNote >= 12)
                                    <span class="badge bg-warning text-dark">Assez bien</span>
                                @elseif ($moyenneNote >= 11)
                                    <span class="badge bg-warning text-dark">Passable</span>
                                @elseif ($moyenneNote >= 10)
                                    <span class="badge bg-warning text-dark">Moyenne</span>
                                @elseif ($moyenneNote >= 8)
                                    <span class="badge bg-warning text-dark">Insuffisant</span>
                                @else
                                    <span class="badge bg-danger">Tres insuffisant</span>
                                @endif
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                Aucune note enregistrée.
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

            <!-- ========================= -->
            <!-- TOTAL -->
            <!-- ========================= -->

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
                        <td>{{ number_format($totalPoints, 2, ',', ' ') }}</td>
                        <td>{{ number_format($totalgenerale, 2, ',', ' ') }}</td>
                        <td>{{ $rang ? $rang . 'ème / ' . $effectif : '-' }}</td>
                        <td>0</td>
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

            <hr style="margin:30px 0;">

        @endforeach

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
                                
                  <div class="tab-pane fade profile-carte" id="profile-carte">
                      <div class="actions">
                          <a href="{{ route('inscription.pdf.carte', $eleve->id) }}" class="btn btn-primary">
                              <i class="bi bi-file-earmark-pdf"></i>
                              Telecharger
                          </a>
                      </div>

                    <div class="card-containere">


                        {{-- ========================= --}}
                        {{-- RECTO --}}
                        {{-- ========================= --}}

                        <div class="student-carde">

                            <div class="card-headere">

                                RÉPUBLIQUE DU TCHAD
                                <br>

                                <strong>
                                    Unité - Travail - Progrès
                                </strong>
                                <br>       
                                

                                <div class="card-titlee">
                                    CARTE D'ÉLÈVE
                                </div>

                            </div>


                            <div class="card-bodye">

                                {{-- Photo --}}

                                <div>


                                        <img
                                            src="{{ asset('/storage/' . $eleve->photo) }}"
                                            class="student-photoe">


                                        <div
                                            class="student-photo d-flex align-items-center justify-content-center">

                                        

                                        </div>


                                </div>


                                {{-- Informations --}}

                                <div class="student-detailse">

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
                                        {{ $eleve->classe?->name ?? '-' }}
                                    </div>

                                    <div>
                                        <strong>Année :</strong>
                                        {{ $eleve->date_inscription ?? '-' }}

                                    </div>

                                    <div>
                                        <strong>Tél :</strong>
                                        {{ $eleve->contact_parent ?? '-' }}
                                    </div>

                                </div>

                            </div>


                            <div class="signature-carde">

                                Signature du responsable

                            </div>


                            <div class="card-footere">

                                {{ $etablissement?->nom ?? 'Établissement scolaire' }}
                                -
                                Carte valable pour l'année scolaire


                            </div>

                        </div>


                        {{-- ========================= --}}
                        {{-- VERSO --}}
                        {{-- ========================= --}}

                        <div class="student-carde">

                            <div class="card-headere">

                                <strong>
                                    INFORMATIONS IMPORTANTES
                                </strong>

                            </div>

                            <div style="padding: 15px; font-size: 11px; line-height: 1.7 text-center;">

                                <strong class="card-titlee">{{ $etablissement?->nom ?? "l'etablissement" }}</strong>
                                <br>
                                <br>
                                <br>
                                <br>
                                <hr>

                            


                            Cette carte est personnelle et ne peut être
                                utilisée par une autre personne.

                            </div>

                            <div class="card-footere">

                                Signature et cachet de l'établissement

                            </div>

                        </div>

                    </div>

                 </div>

              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
      </div>
    </div>
    </section>