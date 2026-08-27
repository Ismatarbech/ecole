
<div>
<div>
    @if (session()->has('success') || session()->has('message'))
      <div class="alert alert-success">{{ session('success') ?? session('message') }}</div>
    @endif
    @if (session()->has('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
     <div class="pagetitle">
      <h1>Notes</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashbord">Accueil</a></li>
          <li class="breadcrumb-item active">Notes</li>
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
      <input type="search" class="form-control border-primary" wire:model.live="search" placeholder="Rechercher une note...">
    </div>
    @canany('create_notes')
        <flux:button href="{{route('note.create')}}" icon="user-plus">
            Ajoute niveau
        </flux:button>
    @endcanany
</div>
    <br>

   <!-- Recent Sales -->
            <div class="col-12">
              <div class="card recent-sales overflow-auto">

                <div class="card-body">
                  <h5 class="card-title">Liste des notes <span>| Aujourd'hui</span></h5>

                  <table class="table table-borderless datatable">
                    <thead>
                      <tr>
                        <th scope="col">id</th>
                        <th scope="col">Matiere</th>
                        <th scope="col">Note devoir</th>
                        <th scope="col">note composition</th>
                        <th scope="col">Matricule</th>
                        <th scope="col">Eléve</th>
                        <th scope="col">Enseignant</th>
                        <th scope="col">Classe</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                    <tr>
                        @forelse($note as $notes)
                        <th scope="row"><a href="#">{{$notes->id}}</a></th>
                          <td>{{ $notes->matiere->description }}</td>
                          <td>{{ $notes->devoir }}</td>
                          <td>{{ $notes->composition }}</td>
                          <td>{{ $notes->eleve->matricule }}</td>
                          <td>{{ $notes->eleve->nom }} {{ $notes->eleve->prenom }}</td>
                          <td>{{ $notes->enseignant?->name }}</td>
                          <td>{{ $notes->eleve?->classe?->name ?? 'Non affectée' }}</td>

                        <td>
                            @canany('update_notes')
                              <flux:button href="#" variant="primary" color="green" icon:trailing="pencil"></flux:button>
                            @endcanany

                            @canany('delete_notes')
                              <flux:button wire:click="deleteNote({{ $notes->id }})" wire:confirm="Voulez-vous vraiment supprimer cette note ?" variant="danger" color="red" icon:trailing="trash"></flux:button>
                            @endcanany
                        </td>

                      </tr>
                      @empty
                        <tr>
                          <td colspan="9" class="text-center">
                            <div class="alert alert-info mb-0">
                              <i class="bi bi-info-circle me-1"></i>
                              Aucune note trouvée.
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
