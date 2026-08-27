<div>
      <div>
        @if (session()->has('success') || session()->has('message'))
          <div class="alert alert-success">{{ session('success') ?? session('message') }}</div>
        @endif
        @if (session()->has('error'))
          <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <div class="pagetitle">
          <h1>Permission</h1>
          <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="/dashboard">Accueil</a></li>
              <li class="breadcrumb-item active">Permission</li>
            </ol>
          </nav>
        </div><!-- End Page Title -->
        @if($successMessage)
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i>
            {{ $successMessage }}
            <button type="button" class="btn-close" wire:click="$set('successMessage', '')" aria-label="Fermer"></button>
          </div>
        @endif

        @if($errorMessage)
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-1"></i>
            {{ $errorMessage }}
            <button type="button" class="btn-close" wire:click="$set('errorMessage', '')" aria-label="Fermer"></button>
          </div>
        @endif
        <div class="d-flex justify-content-end mb-3">
          <div class="input-group me-3 index-search" style="max-width: 360px;">
            <span class="input-group-text bg-primary text-white"><i class="bi bi-search"></i></span>
            <input type="search" class="form-control border-primary" wire:model.live="search" placeholder="Rechercher une permission...">
          </div>
          @canany('create_users')
          <flux:button href="{{route('permissions.create')}}" icon="user-plus">
              Nouveau Permission
          </flux:button>
          @endcanany
      </div>
      <br>

   <!-- Recent Sales -->
      <div class="col-12">
        <div class="card recent-sales overflow-auto">
          <div class="card-body">
            <h5 class="card-title">Liste des permissions <span>| Aujourd'hui</span></h5>

            <table class="table table-borderless datatable">
                    <thead>
                      <tr>
                        <th scope="col">id</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Actions</th>
                        <th scope="col">Permissions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                         @forelse($permissions as $permission)
                        <th scope="row"><a href="#">{{$permission->id}}</a></th>
                        <td>{{$permission->name}}</td>
                        <td>
                            @canany('update_permissions')
                              <flux:button href="{{ route('permissions.edit',$permission->id)}}" variant="primary" color="white" icon:trailing="pencil"></flux:button>
                            @endcanany

                            @canany('delete_permissions')
                              <flux:button wire:click='deletePermission({{ $permission->id }})' variant="danger" color="red" icon:trailing="trash"></flux:button>
                            @endcanany
                        </td>
                        <td><span class="badge bg-success">{{$permission->name}}</span></td>
                      </tr>
                      @empty
                        <tr>
                          <td colspan="4" class="text-center">
                            <div class="alert alert-info mb-0">
                              <i class="bi bi-info-circle me-1"></i>
                              Aucune permission trouvée.
                            </div>
                          </td>
                        </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>

              </div>
            </div><!-- End Recent Sales -->
  </div>