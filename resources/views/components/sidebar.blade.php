<nav class="nxl-navigation">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="/" class="b-brand">
                <img src="{{ asset('frontendpartials/assets/img/spjlogo.png') }}" alt="Logo" class="logo logo-lg" style="width: 80px; height: auto;">
            </a>
        </div>

        <div class="navbar-content">
            <ul class="nxl-navbar">

                {{-- Caption, kalau ingin --}}
                <li class="nxl-item nxl-caption">
                    <label>Navigation</label>
                </li>

                {{-- Loop menu dinamis --}}
               @foreach ($menu as $menu)
                    @php
                        // Untuk menu parent
                        $menuUrl = $menu->subMenu->count() > 0
                                    ? 'javascript:void(0);'
                                    : (str_contains($menu->url, '.') ? route($menu->url) : url($menu->url));
                    @endphp

                    <li class="nxl-item {{ $menu->subMenu->count() > 0 ? 'nxl-hasmenu' : '' }}">
                        <a href="{{ $menuUrl }}" class="nxl-link">
                            <span class="nxl-micon"><i class="{{ $menu->icon }}"></i></span>
                            <span class="nxl-mtext">{{ $menu->name }}</span>
                            @if ($menu->subMenu->count() > 0)
                                <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                            @endif
                        </a>

                        @if ($menu->subMenu->count() > 0)
                            <ul class="nxl-submenu">
                                @foreach ($menu->subMenu as $sub)
                                    @php
                                        // untuk submenu
                                        $subUrl = str_contains($sub->url, '.')
                                                    ? route($sub->url)
                                                    : url($sub->url);
                                    @endphp

                                    <li class="nxl-item">
                                        <a class="nxl-link" href="{{ $subUrl }}">{{ $sub->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach

            </ul>
        </div>
    </div>
</nav>
