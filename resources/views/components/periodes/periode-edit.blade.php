<div>

    @if (session()->has('error'))

        <div class="alert alert-danger alert-dismissible fade show">

            <i class="bi bi-exclamation-triangle me-1"></i>

            {{ session('error') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    @endif


    {{-- TITRE --}}
    <div class="pagetitle">

        <h1>Modifier une période scolaire</h1>

        <nav>

            <ol class="breadcrumb">

                <li class="breadcrumb-item">

                    <a href="{{ url('/dashbord') }}">
                        Accueil
                    </a>

                </li>

                <li class="breadcrumb-item">

                    <a href="{{ route('periodes.index') }}">
                        Périodes scolaires
                    </a>

                </li>

                <li class="breadcrumb-item active">
                    Modifier
                </li>

            </ol>

        </nav>

    </div>


    <section class="section">

        <div class="row">

            <div class="col-12">

                <div class="card">

                    <div class="card-body">

                        <h5 class="card-title">

                            <i class="bi bi-pencil-square me-2"></i>

                            Modifier la période scolaire

                        </h5>


                        <form wire:submit="update">

                            <div class="row">


                                {{-- ANNÉE SCOLAIRE --}}
                                <div class="col-md-6 mb-3">

                                    <label class="form-label">

                                        Année scolaire

                                        <span class="text-danger">*</span>

                                    </label>

                                    <select
                                        wire:model.live="annee_scolaire_id"
                                        class="form-select @error('annee_scolaire_id') is-invalid @enderror"
                                    >

                                        <option value="">
                                            -- Sélectionner une année scolaire --
                                        </option>

                                        @foreach ($annees as $annee)

                                            <option value="{{ $annee->id }}">

                                                {{ $annee->scolaire_annee }}

                                            </option>

                                        @endforeach

                                    </select>

                                    @error('annee_scolaire_id')

                                        <div class="invalid-feedback">

                                            {{ $message }}

                                        </div>

                                    @enderror

                                </div>


                                {{-- TYPE --}}
                                <div class="col-md-6 mb-3">

                                    <label class="form-label">

                                        Type de période

                                        <span class="text-danger">*</span>

                                    </label>

                                    <select
                                        wire:model.live="type"
                                        class="form-select @error('type') is-invalid @enderror"
                                    >

                                        <option value="">
                                            -- Sélectionner le type --
                                        </option>

                                        <option value="semestre">
                                            Semestre
                                        </option>

                                        <option value="trimestre">
                                            Trimestre
                                        </option>

                                    </select>

                                    @error('type')

                                        <div class="invalid-feedback">

                                            {{ $message }}

                                        </div>

                                    @enderror

                                </div>


                                {{-- PÉRIODE --}}
                                <div class="col-md-6 mb-3">

                                    <label class="form-label">

                                        Période

                                        <span class="text-danger">*</span>

                                    </label>

                                    <select
                                        wire:model.live="nom"
                                        class="form-select @error('nom') is-invalid @enderror"
                                    >

                                        <option value="">
                                            -- Sélectionner une période --
                                        </option>

                                        @if (!empty($annee_scolaire_id) && !empty($type))

                                            @foreach ($this->periodesDisponibles as $periode)

                                                <option value="{{ $periode['nom'] }}">

                                                    {{ $periode['nom'] }}

                                                </option>

                                            @endforeach

                                        @endif

                                    </select>

                                    @error('nom')

                                        <div class="invalid-feedback">

                                            {{ $message }}

                                        </div>

                                    @enderror

                                </div>


                                {{-- ORDRE --}}
                                <div class="col-md-6 mb-3">

                                    <label class="form-label">

                                        Ordre

                                    </label>

                                    <input
                                        type="number"
                                        wire:model="ordre"
                                        class="form-control @error('ordre') is-invalid @enderror"
                                        readonly
                                    >

                                    @error('ordre')

                                        <div class="invalid-feedback">

                                            {{ $message }}

                                        </div>

                                    @enderror

                                </div>


                                {{-- DATE DÉBUT --}}
                                <div class="col-md-6 mb-3">

                                    <label class="form-label">

                                        Date de début

                                        <span class="text-danger">*</span>

                                    </label>

                                    <input
                                        type="date"
                                        wire:model="date_debut"
                                        class="form-control @error('date_debut') is-invalid @enderror"
                                    >

                                    @error('date_debut')

                                        <div class="invalid-feedback">

                                            {{ $message }}

                                        </div>

                                    @enderror

                                </div>


                                {{-- DATE FIN --}}
                                <div class="col-md-6 mb-3">

                                    <label class="form-label">

                                        Date de fin

                                        <span class="text-danger">*</span>

                                    </label>

                                    <input
                                        type="date"
                                        wire:model="date_fin"
                                        class="form-control @error('date_fin') is-invalid @enderror"
                                    >

                                    @error('date_fin')

                                        <div class="invalid-feedback">

                                            {{ $message }}

                                        </div>

                                    @enderror

                                </div>

                            </div>


                            {{-- BOUTONS --}}
                            <div class="d-flex justify-content-end gap-2 mt-4">

                                <flux:button
                                    href="{{ route('periodes.index') }}"
                                    variant="ghost"
                                >

                                    <i class="bi bi-arrow-left me-1"></i>

                                    Annuler

                                </flux:button>


                                <flux:button
                                    type="submit"
                                    variant="primary"
                                    icon="pencil"
                                    wire:loading.attr="disabled"
                                    wire:target="update"
                                >

                                    <span
                                        wire:loading.remove
                                        wire:target="update"
                                    >

                                        Modifier

                                    </span>


                                    <span
                                        wire:loading
                                        wire:target="update"
                                    >

                                        Modification...

                                    </span>

                                </flux:button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </section>

</div>