<div> 
    <div class="pagetitle"> 
      <h1>Eleve</h1> 
      <nav> 
        <ol class="breadcrumb"> 
          <li class="breadcrumb-item"><a href="/">Accueil</a></li> 
          <li class="breadcrumb-item active">eleve</li> 
        </ol> 
      </nav> 
    </div>

    {{-- ERROR --}}
    @if($errorMessage) 
      <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-4" role="alert"> 
        <i class="bi bi-exclamation-triangle-fill me-2"></i> 
        {{ $errorMessage }} 
        <button type="button" class="btn-close" wire:click="$set('errorMessage', '')"></button> 
      </div> 
    @endif 

    {{-- FILTER --}}
    <div class="card border-0 shadow-sm mb-4">
      <div class="card-body p-3">
        <div class="row g-2 align-items-center">

          <div class="col-12 col-md-4 col-lg-3">
            <div class="input-group">
              <span class="input-group-text bg-light border-end-0 text-muted">
                <i class="bi bi-funnel"></i>
              </span>
              <select class="form-select border-start-0 ps-0 shadow-none" wire:model.live="selectedClasseId"> 
                <option value="">Toutes les classes</option> 
                @foreach($classes as $classe) 
                  <option value="{{ $classe->id }}">{{ $classe->name }}</option> 
                @endforeach 
              </select> 
            </div>
          </div>

          <div class="col-12 col-md-8 col-lg-4">
            <div class="input-group"> 
              <span class="input-group-text bg-light border-end-0 text-muted">
                <i class="bi bi-search"></i>
              </span> 
              <input type="search" class="form-control border-start-0 ps-0 shadow-none"
                     wire:model.live="search"
                     placeholder="Rechercher un élève..."> 
            </div> 
          </div>

          <div class="col-12 col-lg-5 d-flex justify-content-lg-end gap-2 mt-2 mt-lg-0">

            <button type="button"
                    class="btn btn-outline-success"
                    wire:click="exporterClasse"
                    @disabled($selectedClasseId === '')>
              <i class="bi bi-file-earmark-excel-fill me-2"></i>
              Exporter Excel
            </button>

            @canany('create_inscriptions') 
                <flux:button href="{{route('inscriptions.create')}}" icon="user-plus"> 
                    Nouvelle eleve 
                </flux:button> 
            @endcanany

          </div>

        </div>
      </div>
    </div>

    {{-- TABLE --}}
    <div class="col-12"> 
      <div class="card recent-sales overflow-auto border-0 shadow-sm"> 
        <div class="card-body"> 
          <h5 class="card-title">Liste des eleves <span>| Aujourd'hui</span></h5> 

          <table class="table table-borderless align-middle"> 
            <thead> 
              <tr> 
                <th>id</th> 
                <th>Matricule</th> 
                <th>Nom</th> 
                <th>Prenom</th> 
                <th>Date</th> 
                <th>Sexe</th> 
                <th>Classe</th> 
                <th>Année scolaire</th> 
                <th>Photo</th> 
                <th>Actions</th> 
                <th>Details</th> 
              </tr> 
            </thead> 

            <tbody> 
            @forelse($eleves as $eleve) 
                <tr> 
                    <td>{{$eleve->id}}</td> 
                    <td><span class="fw-bold text-primary">{{$eleve->matricule}}</span></td> 
                    <td>{{$eleve->nom}}</td> 
                    <td>{{$eleve->prenom}}</td> 
                    <td>{{$eleve->naissance}}</td> 
                    <td>{{$eleve->sexe}}</td> 
                    <td><span class="badge bg-light text-dark border">{{$eleve->classe?->name ?? 'Non affectée'}}</span></td> 
                    <td>{{$eleve->anneeScolaire->scolaire_annee}}</td> 
                    <td>
                      @if ($eleve->photo) 
                        <img src="{{ asset('/storage/' . $eleve->photo) }}" class="rounded-circle" width="32" height="32">
                      @else 
                        <span class="text-muted small">Aucune photo</span> 
                      @endif 
                    </td> 

                    <td>
                        @canany('update_inscriptions') 
                          <flux:button href="{{ route('inscription.edit', $eleve->id) }}" variant="primary" color="white" icon:trailing="pencil"></flux:button> 
                        @endcanany 

                        @canany('delete_inscriptions') 
                          <flux:button wire:click="deleteEleve({{ $eleve->id }})"
                                        wire:confirm="Etes vous vraiment supprimer cet eleve ?"
                                        variant="danger" color="red" icon:trailing="trash"></flux:button> 
                        @endcanany 
                    </td> 

                    @canany('detail_inscriptions') 
                        <td>
                          <a href="{{ route('inscription.detail', $eleve->id) }}" class="btn btn-sm btn-outline-info rounded-pill px-3">
                            Détail
                          </a>
                        </td> 
                    @endcanany 

                </tr> 
            @empty 
                <tr>
                    <td colspan="12" class="text-center">
                      <div class="alert alert-info mb-0">
                        <i class="bi bi-info-circle me-1"></i>
                        Aucun eleve trouvé.
                      </div>
                    </td>
                </tr> 
            @endforelse 
            </tbody> 
          </table> 

          {{-- ================= PAGINATION CONDITION ================= --}}
          @if(method_exists($eleves, 'links') && $eleves->count() > 10)
              <div class="d-flex justify-content-end mt-3">

                  <nav aria-label="Page navigation">
                      <ul class="pagination justify-content-end">

                          {{-- PREVIOUS --}}
                          @if ($eleves->onFirstPage())
                              <li class="page-item disabled">
                                  <span class="page-link">précédente</span>
                              </li>
                          @else
                              <li class="page-item">
                                  <button class="page-link" wire:click="previousPage">
                                      précédente
                                  </button>
                              </li>
                          @endif

                          {{-- NUMBERS --}}
                          @foreach ($eleves->getUrlRange(1, $eleves->lastPage()) as $page => $url)
                              <li class="page-item {{ $eleves->currentPage() == $page ? 'active' : '' }}">
                                  <button class="page-link" wire:click="gotoPage({{ $page }})">
                                      {{ $page }}
                                  </button>
                              </li>
                          @endforeach

                          {{-- NEXT --}}
                          @if ($eleves->hasMorePages())
                              <li class="page-item">
                                  <button class="page-link" wire:click="nextPage">
                                      Suivant
                                  </button>
                              </li>
                          @else
                              <li class="page-item disabled">
                                  <span class="page-link">Suivant</span>
                              </li>
                          @endif

                      </ul>
                  </nav>

              </div>
          @endif

        </div> 
      </div> 
    </div>
</div>