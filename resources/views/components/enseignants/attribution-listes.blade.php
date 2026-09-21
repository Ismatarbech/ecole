<div>

    {{-- ================= MESSAGES ================= --}}
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif


    {{-- ================= HEADER ================= --}}
    <div class="pagetitle">
        <h1>Attributions</h1>

        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/">Accueil</a>
                </li>
                <li class="breadcrumb-item active">
                    Attributions
                </li>
            </ol>
        </nav>
    </div>


    {{-- ================= SEARCH + BUTTON ================= --}}
    <div class="d-flex justify-content-end mb-3">

        <div class="input-group me-3" style="max-width: 360px;">
            <span class="input-group-text bg-primary text-white">
                <i class="bi bi-search"></i>
            </span>

            <input type="search"
                   class="form-control border-primary"
                   wire:model.live="search"
                   placeholder="Rechercher un enseignant...">
        </div>

        @canany(['create_enseignants'])
            <flux:button href="{{ url('enseignants/attributions') }}" icon="user-plus">
                Assigner une classe
            </flux:button>
        @endcanany

    </div>


    {{-- ================= TABLE ================= --}}
    <div class="col-12">

        <div class="card recent-sales overflow-auto">

            <div class="card-body">

                <h5 class="card-title">
                    Liste des attributions <span>| Aujourd'hui</span>
                </h5>

                <table class="table table-borderless">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Enseignant</th>
                            <th>Classes</th>
                            <th>Matières</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($data as $item)

                            <tr>

                                <th>
                                    {{ $item['enseignant']->id }}
                                </th>

                                <td>
                                    <strong class="text-primary">
                                        {{ $item['enseignant']->name }}
                                    </strong>
                                </td>

                                {{-- CLASSES --}}
                                <td>
                                    @if($item['classes']->count())
                                        @foreach ($item['classes'] as $classeId => $relations)

                                            <span class="badge bg-primary mb-1">
                                                {{ $relations[0]->classe_name }}
                                            </span>

                                        @endforeach
                                    @else
                                        <span class="text-muted">
                                            Aucune classe
                                        </span>
                                    @endif
                                </td>

                                {{-- MATIERES --}}
                                <td>
                                    @if($item['classes']->count())
                                        @foreach ($item['classes'] as $classeId => $relations)

                                            <div class="mb-1">
                                                @foreach ($relations as $r)

                                                    <span class="badge bg-light text-dark border">
                                                        {{ $r->matiere_name }}
                                                    </span>

                                                @endforeach
                                            </div>

                                        @endforeach
                                    @else
                                        <span class="text-muted">
                                            Aucune matière
                                        </span>
                                    @endif
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="4" class="text-center">
                                    <div class="alert alert-info mb-0">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Aucun enseignant trouvé.
                                    </div>
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>


                {{-- ================= PAGINATION ================= --}}
                @if ($data->hasPages())

                    <div class="d-flex justify-content-center mt-3">
                        {{ $data->links() }}
                    </div>

                @endif


            </div>
        </div>

    </div>

</div>