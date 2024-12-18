<ul id="sidebarnav">
    <li class="nav-small-cap">
      <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
      <span class="hide-menu">Menu</span>
    </li>
    <li class="sidebar-item">
      <a class="sidebar-link {{ Request::is('dashboard*') ? 'active' : '' }} " href="/dashboard" aria-expanded="false">
          <span>
            <i class="bi bi-speedometer2"></i>
          </span>
          <span class="hide-menu">Dashboard</span>
      </a>
  </li>
    <li class="sidebar-item">
      <a class="sidebar-link {{ Request::is('order*') ? 'active' : '' }}" href="/order" aria-expanded="false">
        <span>
          <i class="bi bi-calendar4"></i>
        </span>
        <span class="hide-menu">Booking</span>
      </a>
  </li>
    @can('IsAdmin')
    <li class="nav-small-cap">
      <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
      <span class="hide-menu">MANAGE DATA</span>
    </li>
    
    <li class="sidebar-item">
        <a class="sidebar-link {{ Request::is('vehicle*') ? 'active' : '' }}" href="/vehicle" aria-expanded="false">
          <span>
            <i class="bi bi-truck"></i>
          </span>
          <span class="hide-menu">Vehicle</span>
        </a>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link {{ Request::is('driver*') ? 'active' : '' }}" href="/driver" aria-expanded="false">
          <span>
            <i class="bi bi-person"></i>
          </span>
          <span class="hide-menu">Driver</span>
        </a>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link {{ Request::is('location*') ? 'active' : '' }}" href="/location" aria-expanded="false">
          <span>
            <i class="bi bi-geo-alt"></i>
          </span>
          <span class="hide-menu">Location</span>
        </a>
    </li>
    @endcan


    <li class="nav-small-cap">
      <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
      <span class="hide-menu">AKUN</span>
    </li>

    {{-- @if(Gate::allows('is-user')) --}}

    {{-- <li class="sidebar-item">
      <a class="sidebar-link" href="/update-profil" aria-expanded="false">
        <span class="icon-center">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-lines-fill" viewBox="0 0 16 16">
            <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM1 13s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm11-8.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2z"/>
          </svg>
        </span>
        <span class="hide-menu">Profil</span>
      </a>
  </li> --}}
  {{-- @endif --}}
    <li class="sidebar-item">
      {{-- <a class="sidebar-link" href="/logout" aria-expanded="false">
        <span>
          <i class="ti ti-login"></i>
        </span>
        <span class="hide-menu">Logout</span>
      </a> --}}
      <form action="/logout" method="POST">
        @csrf
        <button type="submit" class="sidebar-link" style="background: none; border: none; font: inherit; color: inherit; cursor: pointer;">
            <span>
              <i class="bi bi-box-arrow-left"></i>
            </span>
            <span class="hide-menu">Logout</span>
        </button>
    </form>

    </li>

  </ul>
