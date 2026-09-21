<div>

    {{-- ===================================================== --}}
    {{-- MESSAGE --}}
    {{-- ===================================================== --}}

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-1"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif


    {{-- ===================================================== --}}
    {{-- TITRE --}}
    {{-- ===================================================== --}}

    <div class="pagetitle">
        <h1>Contacts</h1>

        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Accueil</a></li>
                <li class="breadcrumb-item active">Contacts</li>
            </ol>
        </nav>
    </div>


    {{-- ===================================================== --}}
    {{-- SEARCH --}}
    {{-- ===================================================== --}}

    <div class="d-flex justify-content-end mb-3">

        <div class="input-group me-3" style="max-width: 360px;">
            <span class="input-group-text bg-primary text-white">
                <i class="bi bi-search"></i>
            </span>

            <input type="search"
                   class="form-control border-primary"
                   wire:model.live="search"
                   placeholder="Rechercher un contact...">
        </div>

    </div>


    {{-- ===================================================== --}}
    {{-- TABLE --}}
    {{-- ===================================================== --}}

    <div class="card">

        <div class="card-body">

            <h5 class="card-title">Liste des contacts</h5>

            <table class="table table-borderless align-middle">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Matricule</th>
                        <th>Niveau</th>
                        <th>Sujet</th>
                        <th>Message</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($contacts as $contact)

                        <tr>
                            <td>{{ $contact->id }}</td>
                            <td>{{ $contact->nom }}</td>
                            <td>{{ $contact->matricule }}</td>
                            <td>{{ $contact->niveau }}</td>
                            <td>{{ $contact->sujet }}</td>
                            <td style="max-width:200px;">
                                {{ \Illuminate\Support\Str::limit($contact->reclammation, 50) }}
                            </td>

                            <td class="d-flex gap-1">

                                <button class="btn btn-danger btn-sm"
                                        wire:click="deleteContact({{ $contact->id }})"
                                        wire:confirm="Voulez-vous supprimer ce contact ?">
                                    <i class="bi bi-trash"></i>
                                </button>

                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="text-center">
                                <div class="alert alert-info mb-0">
                                    Aucun contact trouvé.
                                </div>
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

            {{-- ===================================================== --}}
            {{-- PAGINATION (style conditionnel propre) --}}
            {{-- ===================================================== --}}

            @if($contacts->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    {{ $contacts->links() }}
                </div>
            @endif

        </div>

    </div>

</div>