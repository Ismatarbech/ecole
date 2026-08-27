<div>
     <div class="pagetitle">
      <h1>Eleve</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard">Accueil</a></li>
          <li class="breadcrumb-item active">eleve</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    @if($errorMessage)
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle me-1"></i>
        {{ $errorMessage }}
        <button
          type="button"
          class="btn-close"
          wire:click="$set('errorMessage', '')"
          aria-label="Fermer"
        ></button>
      </div>
    @endif

    <div class="d-flex justify-content-end align-items-center mb-3">
      <select class="form-select me-3 border-primary" style="max-width: 260px;" wire:model.live="selectedClasseId">
        <option value="">Toutes les classes</option>
        @foreach($classes as $classe)
          <option value="{{ $classe->id }}">{{ $classe->name }}</option>
        @endforeach
      </select>
      <div class="input-group me-3 index-search" style="max-width: 360px;">
        <span class="input-group-text bg-primary text-white"><i class="bi bi-search"></i></span>
        <input type="search" class="form-control border-primary" wire:model.live="search" placeholder="Rechercher un élève...">
      </div>
      @canany('create_inscriptions')
          <flux:button href="{{route('inscriptions.create')}}" icon="user-plus">
              Nouvelle eleve
          </flux:button>
      @endcanany
    </div>
    <br>


   <!-- Recent Sales -->
            <div class="col-12">
              <div class="card recent-sales overflow-auto">
                <div class="card-body">
                  <h5 class="card-title">Liste des eleves <span>| Aujourd'hui</span></h5>
                  
                  <table class="table table-borderless datatable">
                    <thead>
                      <tr>
                        <th scope="col">id</th>
                        <th scope="col">Matricule</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Prenom</th>
                        <th scope="col">Date</th>
                        <th scope="col">Sexe</th>
                        <th scope="col">Classe</th>
                        <th scope="col">Année scolaire</th>
                        <th scope="col">Photo</th>
                        <th scope="col">Actions</th>
                        <th scope="col">Details</th>
                      </tr>
                    </thead>
                    <tbody>
                    @forelse($elevesParClasse as $classeId => $elevesClasse)
                        
                        @foreach($elevesClasse as $eleve)
                        <tr>
                        <td>{{$eleve->id}}</td>
                        <td>{{$eleve->matricule}}</td>
                        <td>{{$eleve->nom}}</td>
                        <td>{{$eleve->prenom}}</td>
                        <td>{{$eleve->naissance}}</td>
                        <td>{{$eleve->sexe}}</td>
                        <td>{{$eleve->classe?->name ?? 'Non affectée'}}</td>
                        <td>{{$eleve->anneeScolaire->scolaire_annee}}</td>
                        <td>
                          @if ($eleve->photo)
                            <img src="{{ asset('/storage/' . $eleve->photo) }}" alt="Profile" class="rounded-circle" width="30" height="30">
                          @else
                            <span class="text-muted">Aucune photo</span>
                          @endif
                    
                        </td>
                        <td>
                            @canany('update_inscriptions')
                              <flux:button href="{{ route('inscription.edit', $eleve->id) }}" variant="primary" color="white" icon:trailing="pencil"></flux:button>
                            @endcanany

                            @canany('delete_inscriptions')
                              <flux:button wire:click='deleteEleve({{ $eleve->id }})' variant="danger" color="red" icon:trailing="trash"></flux:button>
                            @endcanany
                        </td>
                        @canany('detail_inscriptions')
                             <td><a  href="{{ route('inscription.detail', $eleve->id) }}" class="btn btn-info rounded-pill">Détail</a></td>
                         @endcanany
                        </tr>
                        @endforeach
                      @empty
                        <tr>
                          <td colspan="11" class="text-center">
                            <div class="alert alert-info mb-0">
                              <i class="bi bi-info-circle me-1"></i>
                              Aucun élève trouvé.
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
