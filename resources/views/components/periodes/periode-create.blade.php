<div class="container py-4">

    {{-- MESSAGE --}}
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit.prevent="save">

        {{-- ANNÉE --}}
        <div class="mb-3">
            <label>Année scolaire</label>
            <select class="form-control" wire:model.live="annee_scolaire_id">
                <option value="">-- choisir --</option>
                @foreach($annees as $annee)
                    <option value="{{ $annee->id }}">
                        {{ $annee->scolaire_annee }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- TYPE --}}
        <div class="mb-3">
            <label>Type</label>
            <select class="form-control" wire:model.live="type">
                <option value="">-- type --</option>
                <option value="semestre">Semestre</option>
                <option value="trimestre">Trimestre</option>
            </select>
        </div>

        {{-- BLOQUAGE SI MIX --}}
        @if($this->annee_scolaire_id && $this->type && $this->periodesDisponibles() === [])
            <div class="alert alert-warning">
                ❌ Cette année utilise déjà un autre type de période.
            </div>
        @endif

        {{-- PÉRIODE --}}
        <div class="mb-3">
            <label>Période</label>
            <select class="form-control" wire:model.live="nom">
                <option value="">-- choisir --</option>

                @foreach($this->periodesDisponibles() as $p)
                    <option value="{{ $p['nom'] }}">
                        {{ $p['nom'] }}
                    </option>
                @endforeach
            </select>

            @error('nom')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- ORDRE --}}
        @if($ordre)
            <div class="alert alert-info">
                Ordre : {{ $ordre }}
            </div>
        @endif

        {{-- SUBMIT --}}
        <button class="btn btn-primary">
            Créer la période
        </button>

    </form>
</div>