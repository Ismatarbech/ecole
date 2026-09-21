<div>

    {{-- ========================================================= --}}
    {{-- MESSAGES SESSION --}}
    {{-- ========================================================= --}}

    @if (session()->has('success') || session()->has('message'))

        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-1"></i>
            {{ session('success') ?? session('message') }}

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>

    @endif


    @if (session()->has('error'))

        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle me-1"></i>
            {{ session('error') }}

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>

    @endif


    {{-- ========================================================= --}}
    {{-- TITRE --}}
    {{-- ========================================================= --}}

    <div class="pagetitle d-flex justify-content-between align-items-center">

        <div>
            <h1>Notes</h1>

            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Accueil</a></li>
                    <li class="breadcrumb-item active">Notes</li>
                </ol>
            </nav>
        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- ALERT LIVEWIRE --}}
    {{-- ========================================================= --}}

    @if($errorMessage)
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle me-1"></i>
            {{ $errorMessage }}
            <button type="button" class="btn-close" wire:click="$set('errorMessage', '')"></button>
        </div>
    @endif


    @if($successMessage)
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-1"></i>
            {{ $successMessage }}
            <button type="button" class="btn-close" wire:click="$set('successMessage', '')"></button>
        </div>
    @endif


    {{-- ========================================================= --}}
    {{-- FILTRES --}}
    {{-- ========================================================= --}}

    <div class="row g-2 mb-3 align-items-center">

        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-text bg-primary text-white">
                    <i class="bi bi-search"></i>
                </span>

                <input type="search"
                       class="form-control border-primary"
                       wire:model.live="search"
                       placeholder="Rechercher une note...">
            </div>
        </div>

        <div class="col-md-3">
            <select class="form-select" wire:model.live="id_classe">
                <option value="">Toutes les classes</option>
                @foreach($classes as $classe)
                    <option value="{{ $classe->id }}">{{ $classe->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <select class="form-select" wire:model.live="matiere_id">
                <option value="">Toutes les matières</option>
                @foreach($matieres as $matiere)
                    <option value="{{ $matiere->id }}">{{ $matiere->description }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            @canany(['create_notes'])
                <flux:button  href="{{ route('note.create') }}" icon="user-plus">
                    Inserer une note
                </flux:button>
            @endcanany
        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- TABLE --}}
    {{-- ========================================================= --}}

    <div class="card">

        <div class="card-body">

            <h5 class="card-title">Liste des notes</h5>

            <table class="table table-borderless datatable">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Matricule</th>
                        <th>Nom</th>
                        <th>Classe</th>
                        <th>Matière</th>
                        <th>Devoir</th>
                        <th>Composition</th>
                        <th>Enseignant</th>
                        <th>État</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($note as $notes)

                        <tr>

                            <td>{{ $notes->id }}</td>
                            <td>{{ $notes->eleve?->matricule ?? '-' }}</td>
                            <td>{{ $notes->eleve?->nom }} {{ $notes->eleve?->prenom }}</td>
                            <td>{{ $notes->eleve?->classe?->name ?? '-' }}</td>
                            <td>{{ $notes->matiere?->nom ?? '-' }}</td>
                            <td>{{ $notes->devoir ?? '-' }}</td>
                            <td>{{ $notes->composition ?? '-' }}</td>
                            <td>{{ $notes->enseignant?->name ?? '-' }}</td>

                            <td>
                                @if($notes->modification_autorisee)
                                    <span class="badge bg-success">Modifiable</span>
                                @else
                                    <span class="badge bg-warning text-dark">Définitive</span>
                                @endif
                            </td>

                            <td>

                                @if(auth()->user()->hasRole('super-admin'))
                                    <button class="btn btn-sm btn-warning"
                                            wire:click="autoriserModification({{ $notes->id }})">
                                        <i class="bi bi-lock"></i>
                                    </button>
                                @endif

                                @canany(['delete_notes'])
                                    <button class="btn btn-sm btn-danger"
                                            wire:click="deleteNote({{ $notes->id }})">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                @endcanany

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="10" class="text-center">
                                <div class="alert alert-info mb-0">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Aucune note trouvée.
                                </div>
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>


            {{-- ========================================================= --}}
            {{-- PAGINATION CUSTOM (DISPARAÎT SI <= 10) --}}
            {{-- ========================================================= --}}

            @if(method_exists($note, 'links') && $note->total() > 0 && $note->lastPage() > 1)

    <div class="d-flex justify-content-end mt-3">

        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-end">

                {{-- PREVIOUS --}}
                @if ($note->onFirstPage())
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
                @foreach ($note->getUrlRange(1, $note->lastPage()) as $page => $url)
                    <li class="page-item {{ $note->currentPage() == $page ? 'active' : '' }}">
                        <button class="page-link" wire:click="gotoPage({{ $page }})">
                            {{ $page }}
                        </button>
                    </li>
                @endforeach

                {{-- NEXT --}}
                @if ($note->hasMorePages())
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