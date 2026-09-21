<div>

    {{-- ===================================================== --}}
    {{-- MESSAGE SUCCÈS --}}
    {{-- ===================================================== --}}

    @if (session()->has('success'))

        <div class="alert alert-success">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
        </div>

    @endif


    {{-- ===================================================== --}}
    {{-- MESSAGE ERREUR --}}
    {{-- ===================================================== --}}

    @if (session()->has('error'))

        <div class="alert alert-danger">
            <i class="bi bi-exclamation-triangle me-2"></i>
            {{ session('error') }}
        </div>

    @endif


    {{-- ===================================================== --}}
    {{-- ERREUR GÉNÉRALE --}}
    {{-- ===================================================== --}}

    @error('general')

        <div class="alert alert-danger">
            <i class="bi bi-exclamation-triangle me-2"></i>
            {{ $message }}
        </div>

    @enderror


    {{-- ===================================================== --}}
    {{-- CARD PRINCIPALE --}}
    {{-- ===================================================== --}}

    <div class="card">

        {{-- HEADER --}}

        <div class="card-header">

            <h5 class="card-title mb-0">
                <i class="bi bi-journal-check me-2"></i>
                Saisie des notes
            </h5>

        </div>


        <div class="card-body">

            <form wire:submit="save">


                {{-- ===================================================== --}}
                {{-- FILTRES --}}
                {{-- ===================================================== --}}

                <div class="row g-3 mb-4">


                    {{-- ================================================= --}}
                    {{-- CLASSE --}}
                    {{-- ================================================= --}}

                    <div class="col-md-4">

                        <label for="classe_id" class="form-label">
                            Classe
                        </label>

                        <flux:select
                            id="classe_id"
                            wire:model.live="classe_id"
                        >

                            <option value="">
                                Sélectionner une classe
                            </option>

                            @foreach($classes as $classe)

                                <option value="{{ $classe->id }}">
                                    {{ $classe->name }}
                                </option>

                            @endforeach

                        </flux:select>


                        @error('classe_id')

                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>



                    {{-- ================================================= --}}
                    {{-- PÉRIODE --}}
                    {{-- ================================================= --}}

                    <div class="col-md-4">

                        <label for="periode_id" class="form-label">
                            Période
                        </label>

                        <flux:select
                            id="periode_id"
                            wire:model.live="periode_id"
                        >

                            <option value="">
                                Sélectionner une période
                            </option>


                            @foreach($periodes as $periode)

                                <option value="{{ $periode->id }}">

                                    {{ $periode->nom
                                        ?? $periode->name
                                        ?? 'Période ' . $periode->id
                                    }}

                                </option>

                            @endforeach

                        </flux:select>


                        @error('periode_id')

                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>

                        @enderror


                        @if($periodes->isEmpty())

                            <div class="text-danger small mt-1">

                                <i class="bi bi-exclamation-circle me-1"></i>

                                Aucune période ouverte pour
                                l’année scolaire active.

                            </div>

                        @endif

                    </div>



                    {{-- ================================================= --}}
                    {{-- MATIÈRE --}}
                    {{-- ================================================= --}}

                    <div class="col-md-4">

                        <label for="matiere_id" class="form-label">
                            Matière
                        </label>

                        <flux:select
                            id="matiere_id"
                            wire:model.live="matiere_id"
                            :disabled="!$classe_id"
                        >

                            <option value="">
                                Sélectionner une matière
                            </option>


                            @foreach($matieres as $matiere)

                                <option value="{{ $matiere->id }}">

                                    {{ $matiere->description
                                        ?? $matiere->nom
                                    }}

                                </option>

                            @endforeach

                        </flux:select>


                        @error('matiere_id')

                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                </div>



                {{-- ===================================================== --}}
                {{-- TABLEAU DES ÉLÈVES --}}
                {{-- ===================================================== --}}

                @if(
                    $classe_id &&
                    $matiere_id &&
                    $periode_id
                )

                    <hr>


                    {{-- ================================================= --}}
                    {{-- TITRE LISTE --}}
                    {{-- ================================================= --}}

                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <h5 class="mb-0">

                            <i class="bi bi-people me-2"></i>

                            Liste des élèves

                        </h5>


                        <span class="badge bg-primary">

                            {{ $eleves->count() }} élève(s)

                        </span>

                    </div>



                    {{-- ================================================= --}}
                    {{-- LÉGENDE --}}
                    {{-- ================================================= --}}

                    <div class="mb-3">

                        <span class="badge bg-secondary me-2">
                            <i class="bi bi-lock-fill me-1"></i>
                            Note verrouillée
                        </span>

                        <span class="badge bg-warning text-dark me-2">
                            <i class="bi bi-unlock me-1"></i>
                            Modification autorisée
                        </span>

                        <span class="badge bg-primary">
                            <i class="bi bi-pencil me-1"></i>
                            Nouvelle note
                        </span>

                    </div>



                    {{-- ================================================= --}}
                    {{-- SI DES ÉLÈVES EXISTENT --}}
                    {{-- ================================================= --}}

                    @if($eleves->count() > 0)


                        <div class="table-responsive">

                            <table class="table table-bordered table-hover align-middle">


                                {{-- ===================================== --}}
                                {{-- EN-TÊTE --}}
                                {{-- ===================================== --}}

                                <thead class="table-light">

                                    <tr>

                                        <th>
                                            #
                                        </th>

                                        <th>
                                            Matricule
                                        </th>

                                        <th>
                                            Nom et prénom
                                        </th>

                                        <th style="min-width: 130px;">
                                            Devoir /20
                                        </th>

                                        <th style="min-width: 130px;">
                                            Composition /20
                                        </th>

                                        <th style="min-width: 120px;">
                                            Moyenne /20
                                        </th>

                                        <th style="min-width: 160px;">
                                            Appréciation
                                        </th>

                                    </tr>

                                </thead>



                                {{-- ===================================== --}}
                                {{-- CORPS --}}
                                {{-- ===================================== --}}

                                <tbody>


                                    @foreach($eleves as $index => $eleve)

                                        @php

                                            $noteExiste = in_array(
                                                $eleve->id,
                                                $notesEnregistrees
                                            );

                                            $modificationAutorisee =
                                                $notes[$eleve->id]['modification_autorisee']
                                                ?? false;

                                        @endphp


                                        <tr>


                                            {{-- ================================= --}}
                                            {{-- NUMÉRO --}}
                                            {{-- ================================= --}}

                                            <td>

                                                {{ $index + 1 }}

                                            </td>



                                            {{-- ================================= --}}
                                            {{-- MATRICULE --}}
                                            {{-- ================================= --}}

                                            <td>

                                                <strong>
                                                    {{ $eleve->matricule }}
                                                </strong>

                                            </td>



                                            {{-- ================================= --}}
                                            {{-- NOM --}}
                                            {{-- ================================= --}}

                                            <td>

                                                <div class="fw-semibold">

                                                    {{ $eleve->nom }}
                                                    {{ $eleve->prenom }}

                                                </div>


                                                {{-- STATUT DE LA NOTE --}}

                                                <div class="mt-1">

                                                    @if($noteExiste)

                                                        @if($modificationAutorisee)

                                                            <span class="badge bg-warning text-dark">

                                                                <i class="bi bi-unlock me-1"></i>

                                                                Modification autorisée

                                                            </span>

                                                        @else

                                                            <span class="badge bg-secondary">

                                                                <i class="bi bi-lock-fill me-1"></i>

                                                                Définitive

                                                            </span>

                                                        @endif

                                                    @else

                                                        <span class="badge bg-primary">

                                                            <i class="bi bi-pencil me-1"></i>

                                                            À saisir

                                                        </span>

                                                    @endif

                                                </div>

                                            </td>



                                            {{-- ================================= --}}
                                            {{-- DEVOIR --}}
                                            {{-- ================================= --}}

                                            <td>

                                                <input
                                                    type="number"
                                                    class="form-control
                                                        @if($noteExiste && !$modificationAutorisee)
                                                            bg-light
                                                        @endif"
                                                    wire:model.live="notes.{{ $eleve->id }}.devoir"
                                                    min="0"
                                                    max="20"
                                                    step="0.01"
                                                    placeholder="0 - 20"

                                                    @if(
                                                        $noteExiste &&
                                                        !$modificationAutorisee
                                                    )
                                                        disabled
                                                    @endif
                                                >


                                                @error("notes.$eleve->id.devoir")

                                                    <div class="text-danger small">

                                                        {{ $message }}

                                                    </div>

                                                @enderror

                                            </td>



                                            {{-- ================================= --}}
                                            {{-- COMPOSITION --}}
                                            {{-- ================================= --}}

                                            <td>

                                                <input
                                                    type="number"
                                                    class="form-control
                                                        @if($noteExiste && !$modificationAutorisee)
                                                            bg-light
                                                        @endif"
                                                    wire:model.live="notes.{{ $eleve->id }}.composition"
                                                    min="0"
                                                    max="20"
                                                    step="0.01"
                                                    placeholder="0 - 20"

                                                    @if(
                                                        $noteExiste &&
                                                        !$modificationAutorisee
                                                    )
                                                        disabled
                                                    @endif
                                                >


                                                @error("notes.$eleve->id.composition")

                                                    <div class="text-danger small">

                                                        {{ $message }}

                                                    </div>

                                                @enderror

                                            </td>



                                            {{-- ================================= --}}
                                            {{-- MOYENNE --}}
                                            {{-- ================================= --}}

                                            <td>

                                                <input
                                                    type="text"
                                                    class="form-control bg-light fw-bold text-center"
                                                    value="{{ $notes[$eleve->id]['moyenne'] ?? '' }}"
                                                    readonly
                                                >

                                            </td>



                                            {{-- ================================= --}}
                                            {{-- APPRÉCIATION --}}
                                            {{-- ================================= --}}

                                            <td>

                                                @php

                                                    $appreciation =
                                                        $notes[$eleve->id]['appreciation']
                                                        ?? '';

                                                @endphp


                                                @if($appreciation)

                                                     @if($appreciation === 'Exellence')

                                                        <span class="badge bg-success fs-6">
                                                            {{ $appreciation }}
                                                        </span>

                                                    @elseif($appreciation === 'Très bien')

                                                        <span class="badge bg-success fs-6">
                                                            {{ $appreciation }}
                                                        </span>

                                                    @elseif($appreciation === 'Bien')

                                                        <span class="badge bg-primary fs-6">
                                                            {{ $appreciation }}
                                                        </span>

                                                    @elseif($appreciation === 'Assez bien')

                                                        <span class="badge bg-info fs-6">
                                                            {{ $appreciation }}
                                                        </span>

                                                    @elseif($appreciation === 'Passable')

                                                        <span class="badge bg-warning text-dark fs-6">
                                                            {{ $appreciation }}
                                                        </span>

                                                    @elseif($appreciation === 'moyenne')

                                                        <span class="badge bg-warning text-dark fs-6">
                                                            {{ $appreciation }}
                                                        </span>

                                                    @elseif($appreciation === 'Insuffisant')

                                                        <span class="badge bg-danger fs-6">
                                                            {{ $appreciation }}
                                                        </span>

                                                    @else

                                                        <span class="badge bg-dark fs-6">
                                                            {{ $appreciation }}
                                                        </span>

                                                    @endif

                                                @else

                                                    <span class="text-muted">
                                                        —
                                                    </span>

                                                @endif

                                            </td>


                                        </tr>


                                    @endforeach


                                </tbody>

                            </table>

                        </div>



                        {{-- ================================================= --}}
                        {{-- BOUTON ENREGISTRER --}}
                        {{-- ================================================= --}}

                        <div class="mt-4 text-end">

                            <button
                                type="submit"
                                class="btn btn-primary"
                                wire:loading.attr="disabled"
                            >

                                <span wire:loading.remove>

                                    <i class="bi bi-save me-1"></i>

                                    Enregistrer les notes

                                </span>


                                <span wire:loading>

                                    <i class="bi bi-hourglass-split me-1"></i>

                                    Enregistrement...

                                </span>

                            </button>

                        </div>


                    @else


                        {{-- ================================================= --}}
                        {{-- AUCUN ÉLÈVE --}}
                        {{-- ================================================= --}}

                        <div class="alert alert-warning">

                            <i class="bi bi-exclamation-triangle me-2"></i>

                            Aucun élève n'est inscrit
                            dans cette classe.

                        </div>


                    @endif


                @else


                    {{-- ================================================= --}}
                    {{-- MESSAGE AVANT SÉLECTION --}}
                    {{-- ================================================= --}}

                    <div class="alert alert-info mt-3">

                        <i class="bi bi-info-circle me-2"></i>

                        Sélectionnez une
                        <strong>classe</strong>,
                        une <strong>période</strong>
                        et une <strong>matière</strong>
                        pour afficher les élèves.

                    </div>


                @endif


            </form>

        </div>

    </div>

</div>
