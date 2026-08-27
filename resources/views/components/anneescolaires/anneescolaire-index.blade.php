
<div>
<div>
  @if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
    </div>
  @endif

  @if (session()->has('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
    </div>
  @endif

     <div class="pagetitle">
      <h1>Année scolaire</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Accueil</a></li>
          <li class="breadcrumb-item active">Année scolaire</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
 <div class="d-flex justify-content-end mb-3">
    <div class="input-group me-3 index-search" style="max-width: 360px;">
      <span class="input-group-text bg-primary text-white"><i class="bi bi-search"></i></span>
      <input type="search" class="form-control border-primary" wire:model.live="search" placeholder="Rechercher une année...">
    </div>
    @canany(['create_annee_scolaire'])
        <flux:button href="{{route('anneescolaire.create')}}" icon="user-plus">
            Nouvelle année scolaire
        </flux:button>
    @endcanany
</div>
    <br>
            <!-- Recent Sales -->
            <div class="col-12">
              <div class="card recent-sales overflow-auto">

               

                <div class="card-body">
                  <h5 class="card-title">Liste de l'année <span>| Aujourd'hui</span></h5>

                  <table class="table table-borderless datatable">
                    <thead>
                      <tr>
                        <th scope="col">id</th>
                        <th scope="col">Année scolaire</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                   <tbody>
                  @forelse($anneescolaires as $annee)
                      <tr wire:key="annee-{{ $annee->id }}">

                          <th scope="row">
                              <a href="#">{{ $annee->id }}</a>
                          </th>

                          <td>
                              {{ $annee->scolaire_annee }}
                          </td>

                          <td>
                              @if($annee->status === 'active')
                                  <span class="badge bg-success">
                                      Active
                                  </span>
                              @else
                                  <span class="badge bg-danger">
                                      Inactive
                                  </span>
                              @endif
                          </td>

                          <td>
                              @if($annee->status === 'inactive')

                                  <button
                                      type="button"
                                      class="btn btn-success"
                                      wire:click="toggleStatus({{ $annee->id }})"
                                      wire:confirm="Voulez-vous vraiment activer cette année scolaire ?"
                                  >
                                      
                                      <i class="bi bi-check-circle"></i>
                                  </button>

                              @else

                                  <button
                                      type="button"
                                      class="btn btn-danger"
                                      wire:click="toggleStatus({{ $annee->id }})"
                                      wire:confirm="Voulez-vous vraiment désactiver cette année scolaire ?"
                                  >
                                     
                                      <i class="bi bi-exclamation-octagon"></i>
                                  </button>

                            @endif
                            @canany(['update_annee_scolaire'])
                              <flux:button href="{{ route('anneescolaire.edit', $annee->id) }}" variant="primary" color="white" icon:trailing="pencil"></flux:button>
                            @endcanany

                            @canany(['delete_annee_scolaire'])
                              <flux:button wire:click="deleteAnneescolaire({{ $annee->id }})" wire:confirm="Voulez-vous vraiment supprimer cette année scolaire ?" variant="danger" color="red" icon:trailing="trash"></flux:button>
                            @endcanany
                          </td>

                      </tr>
                    @empty
                      <tr>
                        <td colspan="4" class="text-center">
                          <div class="alert alert-info mb-0">
                            <i class="bi bi-info-circle me-1"></i>
                            Aucune année scolaire trouvée.
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