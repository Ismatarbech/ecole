<div><div>
    @if (session()->has('success') || session()->has('message'))
      <div class="alert alert-success">{{ session('success') ?? session('message') }}</div>
    @endif
    @if (session()->has('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
     <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
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
    @if($successMessage)
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-1"></i>
        {{ $successMessage }}
        <button type="button" class="btn-close" wire:click="$set('successMessage', '')" aria-label="Fermer"></button>
      </div>
    @endif
 <div class="d-flex justify-content-end mb-3">
    <div class="input-group me-3 index-search" style="max-width: 360px;">
      <span class="input-group-text bg-primary text-white"><i class="bi bi-search"></i></span>
      <input type="search" class="form-control border-primary" wire:model.live="search" placeholder="Rechercher une matière...">
    </div>
    @canany('create_matieres')
        <flux:button href="{{route('matiere.create')}}" icon="user-plus">
            Inserer une matiere
        </flux:button>
    @endcanany
</div>
    <br>

   <!-- Recent Sales -->
            <div class="col-12">
              <div class="card recent-sales overflow-auto">

                <div class="card-body">
                  <h5 class="card-title">Recent Sales <span>| Today</span></h5>

                  <table class="table table-borderless datatable">
                    <thead>
                      <tr>
                        <th scope="col">Matricule</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Description</th>
                        <th scope="col">Coefficient</th>
                        <th scope="col">Niveau</th>
                        <th scope="col">Actions</th>
                        <th scope="col">Actif</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                         @forelse($matieres as $matiere)
                        <th scope="row"><a href="#">{{$matiere->id}}</a></th>
                        <td>{{$matiere->nom}}</td>
                        <td>{{$matiere->description}}</td>
                        <td>{{$matiere->coefficient}}</td>
                        <td>{{$matiere->niveau->code}}</td>
                        <td>
                        @canany('update_matieres')
                        <flux:button href="#" variant="primary" color="green" icon:trailing="pencil"></flux:button>
                        @endcanany

                       @canany('delete_matieres')
                        <flux:button wire:click='deleteMatiere({{ $matiere->id }})' variant="danger" color="red" icon:trailing="trash"></flux:button>
                        @endcanany
                        </td>
                        <td><span class="badge bg-success">Approved</span></td>
                      </tr>
                      @empty
                        <tr>
                          <td colspan="7" class="text-center">
                            <div class="alert alert-info mb-0">
                              <i class="bi bi-info-circle me-1"></i>
                              Aucune matière trouvée.
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