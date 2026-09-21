<x-layouts::app :title="__('Dashboard')">
  

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Accueil</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">

            @canany(['view_nombres','view_any_nombres'])
            <!-- Sales Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filtre</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Aujourd'hui</a></li>
                    <li><a class="dropdown-item" href="#">Mois passé</a></li>
                    <li><a class="dropdown-item" href="#">Année passé</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Nombre d'eleve <span>| inscrit</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ number_format($nombreElevesActifs, 0, ',', ' ') }}</h6>
                      <span class="text-success small pt-1 fw-bold">{{ $pourcentageElevesActifs }}%</span> <span class="text-muted small pt-2 ps-1">inscrits cette année</span>

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->
            @endcanany

          @canany(['view_revenues','view_any_revenues'])
            <!-- Revenue Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card revenue-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filtre</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Aujourd'hui</a></li>
                    <li><a class="dropdown-item" href="#">Mois passé</a></li>
                    <li><a class="dropdown-item" href="#">Année passé</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Revenue <span>| Par an</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-cash"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ number_format($revenuActif, 0, ',', ' ') }} Cfa</h6>
                      <span class="text-success small pt-1 fw-bold">{{ $pourcentageRevenu }}%</span> <span class="text-muted small pt-2 ps-1">des frais versés</span>

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->
            @endcanany

            @canany(['view_totals','view_any_totals'])
            <!-- Customers Card -->
            <div class="col-xxl-4 col-xl-12">

              <div class="card info-card customers-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filtre</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Aujourd'hui</a></li>
                    <li><a class="dropdown-item" href="#">Mois passé</a></li>
                    <li><a class="dropdown-item" href="#">Année passé</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Nombre <span>| Totale</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ number_format($nombreElevesTotal, 0, ',', ' ') }}</h6>
                      <span class="text-muted small pt-1 fw-bold">total</span> <span class="text-muted small pt-2 ps-1">sur la plateforme</span>

                    </div>
                  </div>

                </div>
              </div>

            </div><!-- End Customers Card -->
            @endcanany

            @canany(['view_rapports','view_any_rapports'])
            <!-- Reports -->
            <div class="col-12">
              <div class="card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filtre</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Aujourd'hui</a></li>
                    <li><a class="dropdown-item" href="#">Mois passé</a></li>
                    <li><a class="dropdown-item" href="#">Année passé</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Rapport des revenus <span>| année active</span></h5>

                  <!-- Line Chart -->
                  <div id="reportsChart"></div>

                  <script>
                    document.addEventListener("DOMContentLoaded", () => {
                      new ApexCharts(document.querySelector("#reportsChart"), {
                        series: [{
                          name: 'Élèves inscrits (cumul)',
                          data: @json(array_values($inscriptionsParMois->all()))
                        }, {
                          name: 'Paiements (cumul)',
                          data: @json(array_values($paiementsParMois->all()))
                        }, {
                          name: 'Revenue encaissé (FCFA)',
                          data: @json(array_values($revenusParMois->all()))
                        }],
                        chart: {
                          height: 350,
                          type: 'area',
                          toolbar: {
                            show: false
                          },
                        },
                        markers: {
                          size: 4
                        },
                        colors: ['#4154f1', '#ff771d', '#2eca6a'],
                        fill: {
                          type: "gradient",
                          gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.3,
                            opacityTo: 0.4,
                            stops: [0, 90, 100]
                          }
                        },
                        dataLabels: {
                          enabled: false
                        },
                        stroke: {
                          curve: 'smooth',
                          width: 2
                        },
                        xaxis: {
                          type: 'category',
                          categories: ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aout', 'Sep', 'Oct', 'Nov', 'Dec']
                        },
                        tooltip: {
                          y: {
                            formatter: function (value, { seriesIndex }) {
                              return new Intl.NumberFormat('fr-FR').format(value) + (seriesIndex === 2 ? ' FCFA' : '');
                            }
                          },
                        }
                      }).render();
                    });
                  </script>
                  <!-- End Line Chart -->

                </div>
              @endcanany
              </div>
            </div><!-- End Reports -->
            

            <!-- Recent Sales -->
            <div class="col-12">
              <div class="card recent-sales overflow-auto">

                <div class="card-body">
                  <h5 class="card-title">Top 5 des élèves <span>| meilleure moyenne</span></h5>

                  <table class="table table-borderless datatable">
                    <thead>
                      <tr>
                        <th scope="col">Rang</th>
                        <th scope="col">Matricule</th>
                        <th scope="col">Élève</th>
                        <th scope="col">Classe</th>
                        <th scope="col">Moyenne</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($meilleursEleves as $eleve)
                        <tr>
                          <th scope="row">{{ $loop->iteration }}</th>
                          <td>{{ $eleve->matricule }}</td>
                          <td>{{ $eleve->nom }} {{ $eleve->prenom }}</td>
                          <td>{{ $eleve->classe?->name ?? '-' }}</td>
                          <td><span class="badge bg-success">{{ number_format($eleve->moyenne_generale, 2, ',', ' ') }}/20</span></td>
                        </tr>
                      @empty
                        <tr><td colspan="5" class="text-center">Aucune moyenne disponible.</td></tr>
                      @endforelse
                    </tbody>
                  </table>

                </div>

              </div>
            </div><!-- End Recent Sales -->

            @canany(['view_revenueparans','view_any_revenueparans'])
            <!-- Top Selling -->
            <div class="col-12">
              <div class="card top-selling overflow-auto">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body pb-0">
                  <h5 class="card-title">Revenue <span>| par année scolaire</span></h5>

                  <table class="table table-borderless">
                    <thead>
                      <tr>
                        <th scope="col">Année scolaire</th>
                        <th scope="col">Statut</th>
                        <th scope="col">Nombre d'élèves</th>
                        <th scope="col">Revenue encaissé</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($revenusParAnnee as $annee)
                        <tr>
                          <td>{{ $annee->scolaire_annee }}</td>
                          <td><span class="badge {{ $annee->status === 'active' ? 'bg-success' : 'bg-secondary' }}">{{ $annee->status }}</span></td>
                          <td class="fw-bold">{{ $annee->eleves_count }}</td>
                          <td class="fw-bold">{{ number_format((float) ($annee->paiements_sum_montant ?? 0), 0, ',', ' ') }} FCFA</td>
                        </tr>
                      @empty
                        <tr><td colspan="4" class="text-center">Aucun revenu enregistré.</td></tr>
                      @endforelse
                    </tbody>
                  </table>

                </div>

              </div>
            </div><!-- End Top Selling -->
            @endcanany

          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">

          @canany(['view_recent','view_any_recent'])
          <!-- Recent Activity -->
          <div class="card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filtre</h6>
                </li>

                <li><span class="dropdown-item-text">Année active</span></li>
              </ul>
            </div>

            <div class="card-body">
              <h5 class="card-title">Activité récent <span>| d'aujourd'hui</span></h5>

              <div class="activity">

                @forelse($activites as $activite)
                  <div class="activity-item d-flex">
                    <div class="activite-label">{{ $activite['date']?->locale('fr')->diffForHumans() ?? '-' }}</div>
                    <i class="bi bi-circle-fill activity-badge text-{{ $activite['couleur'] }} align-self-start"></i>
                    <div class="activity-content">{{ $activite['texte'] }}</div>
                  </div>
                @empty
                  <div class="text-muted">Aucune activité récente.</div>
                @endforelse

              </div>

            </div>
          </div><!-- End Recent Activity -->
          @endcanany

          @canany(['view_barchart','view_any_barchart'])
          <!-- Budget Report -->
          <div class="card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div>
             <div class="card-body">
              <h5 class="card-title">Bar Chart</h5>

              <!-- Bar Chart -->
              <div id="barChart"></div>

              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  new ApexCharts(document.querySelector("#barChart"), {
                    series: [{
                      name: 'Effectif',
                      data: @json($elevesParNiveau->pluck('value')->values())
                    }],
                    chart: {
                      type: 'bar',
                      height: 350
                    },
                    plotOptions: {
                      bar: {
                        borderRadius: 4,
                        horizontal: true,
                      }
                    },
                    dataLabels: {
                      enabled: false
                    },
                    xaxis: {
                      categories: @json($elevesParNiveau->pluck('name')->values()),
                    }
                  }).render();
                });
              </script>
              <!-- End Bar Chart -->
              @endcanany

            </div>
          </div><!-- End Budget Report -->

          <!-- Website Traffic -->
          <div class="card"> 
           <div class="card-body pb-0">
              <h5 class="card-title">Répartition des élèves <span>| CP1 à Terminale</span></h5>

              <div id="trafficChart" style="min-height: 400px;" class="echart"></div>

              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  echarts.init(document.querySelector("#trafficChart")).setOption({
                    tooltip: {
                      trigger: 'item'
                    },
                    legend: {
                      top: '5%',
                      left: 'center'
                    },
                    series: [{
                      name: 'Élèves',
                      type: 'pie',
                      radius: ['40%', '70%'],
                      avoidLabelOverlap: false,
                      label: {
                        show: false,
                        position: 'center'
                      },
                      emphasis: {
                        label: {
                          show: true,
                          fontSize: '18',
                          fontWeight: 'bold'
                        }
                      },
                      labelLine: {
                        show: false
                      },
                      data: @json($elevesParNiveau)
                    }]
                  });
                });
              </script>

            </div>
          </div><!-- End Website Traffic -->

        </div><!-- End Right side columns -->

      </div>
    </section>


</x-layouts::app>
