@php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
$containerNav = $containerNav ?? 'container-fluid';
$navbarDetached = ($navbarDetached ?? '');
@endphp

<style>
.navbar-dropdown .dropdown-toggle::after {
    display: none;
}
.dropdown-user .dropdown-toggle {
    padding: 0.5rem 0.5rem !important;
}
.user-avatar {
    width: 40px;
    height: 40px;
    object-fit: cover;
    border: 2px solid #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
.user-info {
    max-width: 150px;
    overflow: hidden;
}
.user-info h6 {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.user-info small {
    font-size: 0.75rem;
}
.dropdown-toggle:focus {
    outline: none;
}
</style>

<!-- Navbar -->
@if(isset($navbarDetached) && $navbarDetached == 'navbar-detached')
<nav class="layout-navbar {{$containerNav}} navbar navbar-expand-xl {{$navbarDetached}} align-items-center bg-navbar-theme" id="layout-navbar">
@endif
@if(isset($navbarDetached) && $navbarDetached == '')
<nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
  <div class="{{$containerNav}}">
@endif

    <!--  Brand demo (display only for navbar-full and hide on below xl) -->
    @if(isset($navbarFull))
    <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
      <a href="{{url('/')}}" class="app-brand-link gap-2">
        <span class="app-brand-logo demo">@include('_partials.macros',["width"=>25,"withbg"=>'var(--bs-primary)'])</span>
        <span class="app-brand-text demo menu-text fw-bold text-heading">{{config('variables.templateName')}}</span>
      </a>
    </div>
    @endif

    <!-- ! Not required for layout-without-menu -->
    @if(!isset($navbarHideToggle))
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0{{ isset($menuHorizontal) ? ' d-xl-none ' : '' }} {{ isset($contentNavbar) ?' d-xl-none ' : '' }}">
      <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
        <i class="bx bx-menu bx-md"></i>
      </a>
    </div>
    @endif

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
      <ul class="navbar-nav flex-row align-items-center ms-auto">

        <!-- Notification -->
        <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3">
          <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
            <i class="bx bx-bell bx-sm"></i>
            <span class="badge bg-danger rounded-pill badge-notifications">
              {{ isset($notifMaint) ? count($notifMaint) : 0 }}
            </span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li class="dropdown-header">Notifikasi Maintenance</li>
            @forelse($notifMaint->take(4) as $item)
              <li>
                <a class="dropdown-item" href="{{ route('maintenance.edit', $item->id_jadwal) }}">
                  <div class="d-flex">
                    <div class="flex-shrink-0 me-3">
                      <i class="bx bx-wrench bx-sm text-warning"></i>
                    </div>
                    <div class="flex-grow-1">
                      <span>
                        {{ $item->asset->nama_barang ?? '-' }} perlu maintenance pada 
                        {{ \Carbon\Carbon::parse($item->next_maintenance_date)->format('d-m-Y') }}
                      </span>
                    </div>
                  </div>
                </a>
              </li>
            @empty
              <li>
                <span class="dropdown-item">Tidak ada notifikasi</span>
              </li>
            @endforelse
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a href="{{ route('pages-account-settings-notifications') }}" class="dropdown-item d-flex justify-content-center p-3">Lihat semua notifikasi</a>
            </li>
          </ul>
        </li>

        <!-- User -->
        <li class="nav-item navbar-dropdown dropdown-user dropdown">
          <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
            <div class="d-flex align-items-center">
              @if(Auth::user()->profile_photo)
                <img src="{{ asset('assets/profile-photos/' . Auth::user()->profile_photo) }}" 
                     alt="{{ Auth::user()->name }}" 
                     class="user-avatar rounded-circle" />
              @else
                <img src="{{ asset('assets/img/avatars/default.jpg') }}" 
                     alt="Default Avatar" 
                     class="user-avatar rounded-circle" />
              @endif
              <div class="user-info ms-2 d-none d-md-block">
                <h6 class="mb-0 text-body">{{ Auth::user()->name }}</h6>
                <small class="text-muted">{{ Auth::user()->username }}</small>
              </div>
            </div>
          </a>
          <ul class="dropdown-menu dropdown-menu-end shadow">
            <li>
              <a class="dropdown-item" href="{{ route('profile.index') }}">
                <i class="bx bx-user me-2"></i>
                <span class="align-middle">My Profile</span>
              </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <a class="dropdown-item text-danger" href="{{ route('logout') }}" 
                 onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bx bx-power-off me-2"></i>
                <span class="align-middle">Log Out</span>
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
              </form>
            </li>
          </ul>
        </li>
      </ul>
    </div>

    @if(!isset($navbarDetached))
  </div>
  @endif
</nav>
<!-- / Navbar -->
