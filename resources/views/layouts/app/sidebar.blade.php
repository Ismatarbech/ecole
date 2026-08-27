<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
     @php
       $contactsDashboard = \App\Models\Contact::latest()->take(4)->get();
       $contactsDashboardCount = \App\Models\Contact::count();
     @endphp
     <!-- ======= Sidebar ======= -->
    <main id="main" class="main">
          <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="/" class="logo d-flex align-items-center">
        <img src="/assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">chool</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

           
    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

        <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-chat-left-text"></i>
            <span class="badge bg-success badge-number">{{ $contactsDashboardCount }}</span>
          </a><!-- End Messages Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
            <li class="dropdown-header">
              {{ $contactsDashboardCount }} nouveau(x) message(s)
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            @forelse($contactsDashboard as $contact)
              @php
                  $eleveContact = \App\Models\Eleve::where('matricule', $contact->matricule)->first();
              @endphp
              <li class="message-item">
                <a href="#">
                  @if($eleveContact?->photo && file_exists(storage_path('app/public/' . $eleveContact->photo)))
                    <img src="{{ asset('storage/' . $eleveContact->photo) }}" alt="Photo de {{ $contact->nom }}" class="message-avatar rounded-circle">
                  @else
                    <span class="message-avatar message-avatar-fallback rounded-circle">
                      <i class="bi bi-person-fill"></i>
                    </span>
                  @endif
                  <div class="message-content">
                    <h4>{{ $contact->nom }} {{ $eleveContact?->prenom }}</h4>
                    <p class="message-subject">{{ $contact->sujet }}</p>
                    <p class="message-preview">{{ $contact->reclammation }}</p>
                    <p class="message-time">{{ $contact->created_at?->locale('fr')->diffForHumans() ?? '-' }}</p>
                  </div>
                </a>
              </li>
              @if(!$loop->last)
                <li><hr class="dropdown-divider"></li>
              @endif
            @empty
              <li class="message-item">
                <a href="#"><i class="bi bi-info-circle text-primary"></i><div><p>Aucun message.</p></div></a>
              </li>
            @endforelse

            <li class="dropdown-footer">
              <a href="#">Show all messages</a>
            </li>

          </ul><!-- End Messages Dropdown Items -->

        </li><!-- End Messages Nav -->

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="/assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2">{{ auth()->user()->name }}</span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>{{ auth()->user()->name }}</h6>
              <span>{{ auth()->user()->email }}</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
             <li>
              <flux:menu.item :href="route('profile.index')" class="dropdown-item d-flex align-items-center" wire:navigate>
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </flux:menu.item>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <flux:menu.item :href="route('profile.edit')" class="dropdown-item d-flex align-items-center" wire:navigate>
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </flux:menu.item>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>


            <li>
               <form method="POST" action="{{ route('logout') }}" >
                  @csrf
                  <flux:menu.item as="button" type="submit" data-test="logout-button" class="dropdown-item d-flex align-items-center">
                  <i class="bi bi-box-arrow-right"></i>
                  <span>Sign Out</span>
                  </flux:menu.item>
                 </form>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->
        <aside id="sidebar" class="sidebar">

            <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link " href="/">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->

          @canany(['view_charts', 'view_any_charts'])
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-bar-chart"></i>
                <span>Données</span>
                </a>
            </li><!-- End Charts Nav -->
          @endcanany

            <li class="nav-heading">Pages</li>

             @canany(['view_users', 'view_any_users'])
            <li class="nav-item">
                <a class="nav-link collapsed" href="/etablissements">
                <i class="bi bi-house-door"></i>
                <span>Etablissements</span>
                </a>
            </li><!-- End Profile Page Nav -->
            @endcanany

            @canany(['view_users', 'view_any_users'])
            <li class="nav-item">
                <a class="nav-link collapsed" href="/users">
                <i class="bi bi-person"></i>
                <span>Utilisateurs</span>
                </a>
            </li><!-- End Profile Page Nav -->
            @endcanany

            @canany(['view_permissions', 'view_any_permissions'])
            <li class="nav-item">
                <a class="nav-link collapsed" href="/permissions">
                <i class="bi bi-clipboard-check"></i>
                <span>Permissions</span>
                </a>
            </li><!-- End F.A.Q Page Nav -->
            @endcanany

            @canany(['view_roles', 'view_any_roles', 'view_permissions', 'view_any_permissions'])
            <li class="nav-item">
                <a class="nav-link collapsed" href="/roles">
                <i class="bi bi-columns-gap"></i>
                <span>roles</span>
                </a>
            </li><!-- End Contact Page Nav -->
            @endcanany

            @canany(['view_annee_scolaire', 'view_any_annee_scolaire'])
            <li class="nav-item">
                <a class="nav-link collapsed" href="/anneescolaire">
                <i class="bi bi-calendar-date"></i>
                <span>Année Scolaire</span>
                </a>
            </li><!-- End Error 404 Page Nav -->
            @endcanany

            @canany(['view_niveaux', 'view_any_niveaux'])
             <li class="nav-item">
                <a class="nav-link collapsed" href="/niveaux">
                <i class="bi bi-door-open"></i>
                <span>Niveaux</span>
                </a>
            </li><!-- End Error 404 Page Nav -->
            @endcanany

            @canany(['view_classes', 'view_any_classes'])
            <li class="nav-item">
                <a class="nav-link collapsed" href="/classes">
                <i class="bi bi-shop"></i>
                <span>Classes</span>
                </a>
            </li><!-- End Error 404 Page Nav -->
            @endcanany

              @canany(['view_inscriptions', 'view_any_inscriptions'])
            <li class="nav-item">
                <a class="nav-link collapsed" href="/inscriptions">
                <i class="bi bi-people"></i>
                <span>Inscriptions</span>
                </a>
            </li><!-- End Blank Page Nav -->
            @endcanany

            @canany(['view_paiements', 'view_any_paiements'])
              <li class="nav-item">
                <a class="nav-link collapsed" href="/paiements">
                <i class="bi bi-cash"></i>
                <span>Paiement</span>
                </a>
              </li><!-- End Blank Page Nav -->
            @endcanany

            @canany(['view_matieres', 'view_any_matieres'])
            <li class="nav-item">
                <a class="nav-link collapsed" href="/matieres">
                <i class="bi bi-book"></i>
                <span>Matières</span>
                </a>
            </li><!-- End Login Page Nav -->
            @endcanany

            @canany(['view_notes', 'view_any_notes'])
            <li class="nav-item">
                <a class="nav-link collapsed" href="/notes">
                <i class="bi bi-card-list"></i>
                <span>Notes</span>
                </a>
            </li><!-- End Register Page Nav -->
            @endcanany

             @canany(['view_contacts', 'view_any_contacts'])
            <li class="nav-item">
                <a class="nav-link collapsed" href="/contacts/create">
                <i class="bi bi-telephone"></i>
                <span>Revendication</span>
                </a>
            </li><!-- End Error 404 Page Nav -->
            @endcanany

            </ul>

        </aside><!-- End Sidebar-->

        {{ $slot }}

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
        </main>
    </body>
</html>
