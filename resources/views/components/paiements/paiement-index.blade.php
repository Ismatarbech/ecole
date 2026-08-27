<div>
     <div class="pagetitle">
      <h1>Paiement</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Accueil</a></li>
          <li class="breadcrumb-item active">Paiement</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    @if($errorMessage)
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle me-1"></i>
        {{ $errorMessage }}
        <button type="button" class="btn-close" wire:click="$set('errorMessage', '')" aria-label="Fermer"></button>
      </div>
    @endif
  <div class="d-flex justify-content-end mb-3">
        <div class="input-group me-3 index-search" style="max-width: 360px;">
          <span class="input-group-text bg-primary text-white"><i class="bi bi-search"></i></span>
          <input type="search" class="form-control border-primary" wire:model.live="search" placeholder="Rechercher un paiement...">
        </div>
        @canany('create_paiements')
        <flux:button href="{{route('paiement.create')}}" icon="user-plus">
            Paiement
        </flux:button>
        @endcanany
    </div>
    <br>

   <!-- Recent Sales -->
            <div class="col-12">
              <div class="card recent-sales overflow-auto">

                <div class="card-body">
                  <h5 class="card-title">Liste des eleves qui ont payées <span>| Aujourd'hui</span></h5>

                  <table class="table table-borderless datatable">
                    <thead>
                      <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Matricule</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Classe</th>
                        <th scope="col">Somme payer</th>
                        <th scope="col">Date de paiement</th>
                        <th scope="col">Année Scolaire</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        @forelse($paiement as $paiements)
                        @php
                          $frais = (float) ($paiements->eleve->classe?->niveau?->montant ?? 0);
                          $totalPaye = (float) $paiements->eleve->paiements
                            ->where('annee_scolaire_id', $paiements->annee_scolaire_id)
                            ->sum('montant');
                          $paiementComplet = $frais > 0 && $totalPaye >= $frais;
                        @endphp
                        <th scope="row"><a href="#">{{$paiements->id}}</a></th>
                          <td>{{ $paiements->eleve->matricule }}</td>
                          <td>{{ $paiements->eleve->nom }}</td>
                          <td>{{ $paiements->classe->name }}</td>
                          <td class="{{ $paiementComplet ? 'text-success fw-bold' : '' }}">
                            {{ $paiements->montant }}
                            @if($paiementComplet)
                              <span class="badge bg-success ms-1">Paiement complet</span>
                            @endif
                          </td>
                          <td>{{ $paiements->date_paiement }}</td>
                          <td>{{ $paiements->anneescolaire->scolaire_annee }}</td>
                          
                        <td>
                            @canany('update_paiements')
                              <flux:button href="#" variant="primary" color="green" icon:trailing="pencil"></flux:button>
                            @endcanany

                            @canany('delete_paiements')
                              <flux:button wire:click='#' variant="danger" color="red" icon:trailing="trash"></flux:button>
                            @endcanany
                        </td>
                      </tr>
                      @empty
                        <tr>
                          <td colspan="8" class="text-center">
                            <div class="alert alert-info mb-0">
                              <i class="bi bi-info-circle me-1"></i>
                              Aucun paiement trouvé.
                            </div>
                          </td>
                        </tr>
                      @endforelse
                       
                    </tbody>
                  </table>
                </div>

              </div>
            </div><!-- End Recent Sales -->
</div>