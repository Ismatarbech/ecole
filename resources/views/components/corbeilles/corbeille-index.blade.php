<div class="container py-4">

<style>


.tabs { 
    display:flex; 
    gap:10px; 
    flex-wrap:wrap; 
    margin-bottom:20px; 
}

.tab {
    padding:8px 12px;
    border-radius:8px;
    background:#eee;
    cursor:pointer;
    font-weight:500;
}

.tab.active {
    background:#4154f1;
    color:white;
}

.box {
    background:white;
    padding:15px;
    border-radius:12px;
}

.item {
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:12px;
    border-bottom:1px solid #eee;
}

.btn {
    padding:5px 10px;
    border:none;
    border-radius:6px;
    font-size:13px;
    cursor:pointer;
}

.restore { background:#198754;color:white; }
.delete { background:#dc3545;color:white; }

.empty {
    padding:15px;
    text-align:center;
    color:#6c757d;
}
</style>
<div>

    {{-- ================= MESSAGES ================= --}}
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif


    {{-- ================= TITRE ================= --}}
    <div class="pagetitle">
        <h1>Corbeille</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/">Accueil</a>
                </li>
                <li class="breadcrumb-item active">Corbeille</li>
            </ol>
        </nav>
    </div>




{{-- TABS --}}
<div class="tabs">

    <div class="tab {{ $tab=='etablissements'?'active':'' }}" wire:click="$set('tab','etablissements')">Etablissements</div>
    <div class="tab {{ $tab=='users'?'active':'' }}" wire:click="$set('tab','users')">Utilisateurs</div>
    <div class="tab {{ $tab=='annees'?'active':'' }}" wire:click="$set('tab','annees')">Années</div>
    <div class="tab {{ $tab=='niveaux'?'active':'' }}" wire:click="$set('tab','niveaux')">Niveaux</div>
    <div class="tab {{ $tab=='classes'?'active':'' }}" wire:click="$set('tab','classes')">Classes</div>
    <div class="tab {{ $tab=='eleves'?'active':'' }}" wire:click="$set('tab','eleves')">Élèves</div>
    <div class="tab {{ $tab=='matieres'?'active':'' }}" wire:click="$set('tab','matieres')">Matières</div>
    <div class="tab {{ $tab=='notes'?'active':'' }}" wire:click="$set('tab','notes')">Notes</div>
    <div class="tab {{ $tab=='periodes'?'active':'' }}" wire:click="$set('tab','periodes')">Périodes</div>
    <div class="tab {{ $tab=='roles'?'active':'' }}" wire:click="$set('tab','roles')">Roles</div>
    <div class="tab {{ $tab=='permissions'?'active':'' }}" wire:click="$set('tab','permissions')">Permissions</div>

</div>


<div class="box">


{{-- USERS --}}
@if($tab=='users')
    @forelse($this->users as $item)

        <div class="item">
            <span>{{ $item->nom }} {{ $item->email }}</span>

            <div>
                <button class="btn restore"
                        wire:click="restoreUser({{ $item->id }})">
                    Restaurer
                </button>

                <button class="btn delete"
                        wire:click="deleteUser({{ $item->id }})">
                    Supprimer
                </button>
            </div>
        </div>

    @empty
        <div class="empty">Aucun utilisateur supprimé</div>
    @endforelse
@endif


{{-- ELEVES --}}
@if($tab=='eleves')
    @forelse($this->eleves as $item)

        <div class="item">
            <span>{{ $item->nom }} {{ $item->prenom }}</span>

            <div>
                <button class="btn restore"
                        wire:click="restoreEleve({{ $item->id }})">
                    Restaurer
                </button>

                <button class="btn delete"
                        wire:click="deleteEleve({{ $item->id }})">
                    Supprimer
                </button>
            </div>
        </div>

    @empty
        <div class="empty">Aucun élève supprimé</div>
    @endforelse
@endif


{{-- MATIERES --}}
@if($tab=='matieres')
    @forelse($this->matieres as $item)

        <div class="item">
            <span>{{ $item->nom }}</span>

            <div>
                <button class="btn restore"
                        wire:click="restoreMatiere({{ $item->id }})">
                    Restaurer
                </button>

                <button class="btn delete"
                        wire:click="deleteMatiere({{ $item->id }})">
                    Supprimer
                </button>
            </div>
        </div>

    @empty
        <div class="empty">Aucune matière supprimée</div>
    @endforelse
@endif


{{-- CLASSES --}}
@if($tab=='classes')
    @forelse($this->classes as $item)

        <div class="item">
            <span>{{ $item->name }}</span>

            <div>
                <button class="btn restore"
                        wire:click="restoreClasse({{ $item->id }})">
                    Restaurer
                </button>

                <button class="btn delete"
                        wire:click="deleteClasse({{ $item->id }})">
                    Supprimer
                </button>
            </div>
        </div>

    @empty
        <div class="empty">Aucune classe supprimée</div>
    @endforelse
@endif


{{-- ANNEES --}}
@if($tab=='annees')
    @forelse($this->annees as $item)

        <div class="item">
            <span>{{ $item->scolaire_annee }}</span>

            <div>
                <button class="btn restore"
                        wire:click="restoreAnnee({{ $item->id }})">
                    Restaurer
                </button>

                <button class="btn delete"
                        wire:click="deleteAnnee({{ $item->id }})">
                    Supprimer
                </button>
            </div>
        </div>

    @empty
        <div class="empty">Aucune année supprimée</div>
    @endforelse
@endif


{{-- NIVEAUX --}}
@if($tab=='niveaux')
    @forelse($this->niveaux as $item)

        <div class="item">
            <span>{{ $item->libelle }}</span>

            <div>
                <button class="btn restore"
                        wire:click="restoreNiveau({{ $item->id }})">
                    Restaurer
                </button>

                <button class="btn delete"
                        wire:click="deleteNiveau({{ $item->id }})">
                    Supprimer
                </button>
            </div>
        </div>

    @empty
        <div class="empty">Aucun niveau supprimé</div>
    @endforelse
@endif


{{-- ETABLISSEMENTS --}}
@if($tab=='etablissements')
    @forelse($this->etablissements as $item)

        <div class="item">
            <span>{{ $item->name }}</span>

            <div>
                <button class="btn restore"
                        wire:click="restoreEtablissement({{ $item->id }})">
                    Restaurer
                </button>

                <button class="btn delete"
                        wire:click="deleteEtablissement({{ $item->id }})">
                    Supprimer
                </button>
            </div>
        </div>

    @empty
        <div class="empty">Aucun établissement supprimé</div>
    @endforelse
@endif


{{-- ROLES --}}
@if($tab=='roles')
    @forelse($this->roles as $item)

        <div class="item">
            <span>{{ $item->name }}</span>

            <button class="btn restore"
                    wire:click="restoreRole({{ $item->id }})">
                Restaurer
            </button>
        </div>

    @empty
        <div class="empty">Aucun rôle supprimé</div>
    @endforelse
@endif


{{-- PERMISSIONS --}}
@if($tab=='permissions')
    @forelse($this->permissions as $item)

        <div class="item">
            <span>{{ $item->name }}</span>

            <button class="btn restore"
                    wire:click="restorePermission({{ $item->id }})">
                Restaurer
            </button>

        </div>

    @empty
        <div class="empty">Aucune permission supprimée</div>
    @endforelse
@endif


</div>
</div>