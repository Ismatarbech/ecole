<div>
    <div>
        @if (session()->has('success') || session()->has('message'))
            <div class="alert alert-success">{{ session('success') ?? session('message') }}</div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{-- =====================================================
             TITRE
        ====================================================== --}}

        <div class="pagetitle">

            <h1>Classe</h1>

            <nav>

                <ol class="breadcrumb">

                    <li class="breadcrumb-item">
                        <a href="/dashboard">
                            Accueil
                        </a>
                    </li>

                    <li class="breadcrumb-item active">
                        Classe
                    </li>

                </ol>

            </nav>

        </div>


        {{-- =====================================================
             MESSAGE SUCCÈS
        ====================================================== --}}

        @if($successMessage)

            <div
                class="alert alert-success alert-dismissible fade show"
                role="alert"
            >

                <i class="bi bi-check-circle me-1"></i>

                {{ $successMessage }}

                <button
                    type="button"
                    class="btn-close"
                    wire:click="$set('successMessage', '')"
                    aria-label="Close"
                >
                </button>

            </div>

        @endif


        {{-- =====================================================
             MESSAGE ERREUR
        ====================================================== --}}

        @if($errorMessage)

            <div
                class="alert alert-danger alert-dismissible fade show"
                role="alert"
            >

                <i class="bi bi-exclamation-triangle me-1"></i>

                {{ $errorMessage }}

                <button
                    type="button"
                    class="btn-close"
                    wire:click="$set('errorMessage', '')"
                    aria-label="Close"
                >
                </button>

            </div>

        @endif


        {{-- =====================================================
             BOUTON NOUVELLE CLASSE
        ====================================================== --}}

        <div class="d-flex justify-content-end mb-3">
            <div class="input-group me-3 index-search" style="max-width: 360px;">
                <span class="input-group-text bg-primary text-white"><i class="bi bi-search"></i></span>
                <input type="search" class="form-control border-primary" wire:model.live="search" placeholder="Rechercher une classe...">
            </div>

            @canany('create_classes')

                <flux:button
                    href="{{ route('classe.create') }}"
                    icon="user-plus"
                >
                    Nouvelle classe
                </flux:button>

            @endcanany

        </div>

        <br>


        {{-- =====================================================
             LISTE DES CLASSES
        ====================================================== --}}

        <div class="col-12">

            <div class="card recent-sales overflow-auto">

                <div class="card-body">

                    <h5 class="card-title">
                        Liste de salle de classe
                        <span>| Aujourd'hui</span>
                    </h5>


                    <table class="table table-borderless datatable">

                        <thead>

                            <tr>

                                <th scope="col">
                                    id
                                </th>

                                <th scope="col">
                                    Nom
                                </th>

                                <th scope="col">
                                    Niveau
                                </th>

                                <th scope="col">
                                    Montant
                                </th>

                                <th scope="col">
                                    Actions
                                </th>

                                <th scope="col">
                                    libellé
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($classe as $classes)

                                <tr>

                                    <th scope="row">
                                        <a href="#">
                                            {{ $classes->id }}
                                        </a>
                                    </th>

                                    <td>
                                        {{ $classes->name }}
                                    </td>

                                    <td>
                                        {{ $classes->niveau->libelle }}
                                    </td>

                                    <td>
                                        {{ $classes->niveau->montant }}
                                    </td>

                                    <td>

                                        {{-- MODIFIER --}}

                                        @canany('update_classes')

                                            <flux:button
                                                href="{{ route('classe.edit', $classes->id) }}"
                                                variant="primary" color="white" icon:trailing="pencil"></flux:button>


                                        @endcanany


                                        {{-- SUPPRIMER --}}

                                        @canany('delete_classes')

                                            <flux:button
                                                wire:click="deleteClasse({{ $classes->id }})"
                                                wire:confirm="Êtes-vous sûr de vouloir supprimer cette classe ?"
                                                variant="danger" color="red" icon:trailing="trash"></flux:button>


                                        @endcanany

                                    </td>

                                    <td>

                                        <span class="badge bg-success">
                                            {{ $classes->niveau->code }}
                                        </span>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="6" class="text-center">
                                        <div class="alert alert-info mb-0">
                                            <i class="bi bi-info-circle me-1"></i>
                                            Aucune classe trouvée.
                                        </div>
                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>


                    {{-- PAGINATION --}}

                    <div class="mt-3">

                        {{ $classe->links() }}

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
