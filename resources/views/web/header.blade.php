<header>
    <div class="header-mobile">
        <div>
            <a class="navbar-brand" href="{{ route('web.home') }}">
                <img src="{{Vite::asset('resources/images/logo.png')}}" alt="{{ 'SeDeSys' }}" class="img-fluid img-logo">
            </a>
        </div>
        <div>
            <i class="fa-light fa-location-dot"></i>&nbsp;????
        </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-light bg-light hide-mobile ">

        <div class="container">
            <a class="navbar-brand" href="{{ route('web.home') }}"><img src="{{Vite::asset('resources/images/logo.png')}}" alt="{{ 'SeDeSys' }}" class="img-fluid img-logo"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @foreach($menu_top as $key => $item)
                        @if(isset($item['submenu']))
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle {{ ($key == $active_menu['first']) ? 'active' : '' }}"
                                   href="{{ isset($item['route']) ? route($item['route'], $item['item'] ?? '') : '#' }}"
                                   id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ $item['name'] }}
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    @foreach($item['submenu'] as $subkey => $subitem)
                                        @if(isset($subitem['submenu']))
                                            <li class="dropdown-submenu">
                                                <a class="dropdown-item" href="#">{{ $subitem['name'] }} <i class="fa-light fa-chevron-right"></i></a>
                                                <ul class="dropdown-menu">
                                                @foreach($subitem['submenu'] as $sub2key => $sub2item)
                                                        <li><a class="dropdown-item" href="{{ $sub2item['url'] }}">{{ $sub2item['name'] }}</a></li>
                                                @endforeach
                                                </ul>
                                            </li>
                                            @else
                                            <li>
                                                <a class="dropdown-item {{ ($subkey == $active_menu['second']) ? 'active' : '' }}"
                                                   href="{{ $subitem['url'] }}">
                                                    <!-- Вставляем иконку png -->
                                                    {{ $subitem['name'] }}
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        @else
                        <li class="nav-item">
                            <a class="nav-link {{ ($key == $active_menu['first']) ? 'active' : '' }}" aria-current="page" href="{{ route($item['route'], $item['item'] ?? '') }}">{{ $item['name'] }}</a>
                        </li>
                        @endif
                    @endforeach
                </ul>
                @if($web->auth)
                    <!-- Если в настройках разрешена аутентификация -->
                    <div>
                        @guest
                            @if (Route::has('web.login'))
                                <a id="login" class="nav-link d-flex flex-column text-center" href="#" data-bs-toggle="modal" data-bs-target="#login-popup">
                                    <i class="fa-light fa-user-vneck fs-4"></i>
                                    <span class="fs-7">Войти</span>
                                </a>
                            @endif
                        @else
                            <a class="nav-link d-flex flex-column text-center" href="/">
                                <i class="fa-light fa-user-vneck fs-4"></i>
                                <span class="fs-7">Кабинет</span>
                            </a>
                        @endguest
                    </div>
                @endif
                <div class="d-flex">
                    @foreach($menu_contact as $item)
                        <div class="ms-2">
                            <a href="{{ $item['url'] }}" target="_blank" title="{{ $item['name'] }}">
                                <i class="{{ $item['icon'] }} fs-3" style="color: {{ $item['color'] }}"></i>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </nav>

    <nav class="menu-mobile">
        <ul class="menu-list">
            @foreach($menu_mobile as $item)
                <li class="menu-item">
                    <a href="{{ $item['url'] }}" class="nav-link d-flex flex-column text-center"
                       @if($item['url'] == '#')
                       data-bs-toggle="modal" data-bs-target="#login-popup"
                        @endif
                    >
                        <i class="{{ $item['icon'] }}fs-3"></i>
                        <span class="fs-8">{{ $item['name'] }}</span>
                    </a>
                </li>
            @endforeach

        </ul>
    </nav>
</header>
