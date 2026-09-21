<div>

    {{-- ===================================================== --}}
    {{-- TITRE --}}
    {{-- ===================================================== --}}

    <div class="pagetitle">
        <h1>Réclamation</h1>

        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Accueil</a></li>
                <li class="breadcrumb-item active">Réclamation</li>
            </ol>
        </nav>
    </div>


    {{-- ===================================================== --}}
    {{-- CARD FORM --}}
    {{-- ===================================================== --}}

    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white border-0 d-flex align-items-center justify-content-between">

            <h5 class="mb-0 fw-bold">
                <i class="bi bi-chat-dots text-primary me-2"></i>
                Nouvelle réclamation
            </h5>

            <span class="badge bg-primary-subtle text-primary">
                Support étudiant
            </span>

        </div>


        <div class="card-body">

            <form class="row g-3" wire:submit="saveContact">


                {{-- MATRICULE --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Matricule</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                        <input type="text"
                               class="form-control"
                               wire:model="matricule"
                               placeholder="Ex: 2026-001">
                    </div>
                </div>


                {{-- NOM --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nom & Prénom</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text"
                               class="form-control"
                               wire:model="nom"
                               placeholder="Nom complet">
                    </div>
                </div>


                {{-- NIVEAU --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Niveau</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-mortarboard"></i></span>
                        <input type="text"
                               class="form-control"
                               wire:model="niveau"
                               placeholder="Ex: Terminale">
                    </div>
                </div>


                {{-- SUJET --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Sujet</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-tag"></i></span>
                        <input type="text"
                               class="form-control"
                               wire:model="sujet"
                               placeholder="Sujet de la réclamation">
                    </div>
                </div>


                {{-- RECLAMATION --}}
                <div class="col-12">
                    <label class="form-label fw-semibold">Réclamation</label>

                    <div class="input-group">
                        <span class="input-group-text align-items-start pt-2">
                            <i class="bi bi-chat-text"></i>
                        </span>

                        <textarea class="form-control"
                                  rows="5"
                                  wire:model="reclammation"
                                  placeholder="Décrivez votre problème en détail..."></textarea>
                    </div>
                </div>


                {{-- BUTTONS --}}
                <div class="col-12 d-flex justify-content-end gap-2 mt-3">

                    <button type="reset" class="btn btn-light border">
                        <i class="bi bi-arrow-counterclockwise me-1"></i>
                        Annuler
                    </button>

                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-send me-1"></i>
                        Envoyer
                    </button>

                </div>


            </form>

        </div>
    </div>

</div>