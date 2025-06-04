<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <!-- Brand -->
  <div class="app-brand demo">
    <a href="{{ url('/') }}" class="app-brand-link">
      <span class="app-brand-logo demo">
        <img src="{{ asset('assets/logo mainup.png') }}" alt="Logo" height="50">
      </span>
    </a>
    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm d-flex align-items-center justify-content-center"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    @foreach ($menuData[0]->menu as $menu)
      @php
        $currentRoute = Route::currentRouteName();
        $activeClass = '';
        $hasSubmenu = isset($menu->submenu);

        if (isset($menu->slug)) {
          if (is_array($menu->slug)) {
            foreach ($menu->slug as $slug) {
              if (str_starts_with($currentRoute, $slug)) {
                $activeClass = $hasSubmenu ? 'active open' : 'active';
                break;
              }
            }
          } else {
            if (str_starts_with($currentRoute, $menu->slug)) {
              $activeClass = $hasSubmenu ? 'active open' : 'active';
            }
          }
        }

        // Periksa apakah item menu harus ditampilkan berdasarkan peran pengguna
        $showMenuItem = true; // Default tampilkan semua
        if (auth()->check() && auth()->user()->role->name === 'teknisi') {
            // Jika peran adalah teknisi, hanya tampilkan Dashboard dan Maintenance
            if (!in_array($menu->slug, ['dashboard', 'maintenance'])) {
                $showMenuItem = false;
            }
        }
      @endphp

      @if ($showMenuItem)
        @if (isset($menu->menuHeader))
          <li class="menu-header small text-uppercase">
            <span class="menu-header-text">{{ __($menu->menuHeader) }}</span>
          </li>
        @else
          <li class="menu-item {{ $activeClass }}">
            <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}"
               class="{{ $hasSubmenu ? 'menu-link menu-toggle' : 'menu-link' }}"
               @if (isset($menu->target) && !empty($menu->target)) target="_blank" @endif>
              @isset($menu->icon)
                <i class="{{ $menu->icon }}"></i>
              @endisset
              <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
              @isset($menu->badge)
                <div class="badge rounded-pill bg-{{ $menu->badge[0] }} text-uppercase ms-auto">
                  {{ $menu->badge[1] }}
                </div>
              @endisset
            </a>

            @if ($hasSubmenu)
              @include('layouts.sections.menu.submenu', ['menu' => $menu->submenu])
            @endif
          </li>
        @endif
      @endif
    @endforeach
  </ul>
</aside>
