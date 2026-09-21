<div class="container py-4">

    {{-- SUCCESS --}}
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ERROR --}}
    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif


    <div class="card shadow-sm">

        <div class="card-body">

            <h4 class="card-title">
                📅 Année scolaire
            </h4>

            <p class="text-muted">
                Format recommandé : 2025-2026
            </p>

            <form wire:submit.prevent="save">

                {{-- INPUT --}}
                <div class="mb-3">

                    <label class="form-label fw-bold">
                        Année scolaire
                    </label>

                    <input type="text"
                           class="form-control form-control-lg"
                           wire:model="annee"
                           placeholder="Ex: 2025-2026">

                    <small class="text-muted">
                        ✔ Vous pouvez écrire: 2025-2026 / 2025 / 2026 / 2025 2026
                    </small>

                </div>


                {{-- PREVIEW (SANS ERREUR) --}}
                @if ($annee)
                    <div class="alert alert-info">
                        <strong>Format final :</strong>
                        <span class="badge bg-primary">
                            {{ preg_replace('/\s+/', '', str_replace('/', '-', $annee)) }}
                        </span>
                    </div>
                @endif


                {{-- INFO --}}
                <div class="alert alert-warning">
                    ⚠ Une seule année scolaire peut exister dans le système.
                </div>


                {{-- BUTTON --}}
                <div class="text-end">

                    <button class="btn btn-primary btn-lg"
                            type="submit"
                            wire:loading.attr="disabled">

                        <span wire:loading.remove>
                            ➕ Créer
                        </span>

                        <span wire:loading>
                            Traitement...
                        </span>

                    </button>

                </div>

            </form>

        </div>
    </div>

</div>