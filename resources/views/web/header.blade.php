<header>
    <div class="header-mobile">
        <div>
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="логотип" alt="альт" class="img-fluid img-logo">
            </a>
        </div>
        <div>
            <i class="fa-light fa-location-dot"></i>&nbsp;????
        </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-light bg-light hide-mobile">

        <div class="container">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    @foreach($menu_top as $item)
                        @if(isset($item['submenu']))
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ $item['name'] }}
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    @foreach($item['submenu'] as $subitem)
                                    <li><a class="dropdown-item" href="{{ $subitem['url'] }}">{{ $subitem['name'] }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{ $item['url'] }}">{{ $item['name'] }}</a>
                        </li>
                        @endif
                    @endforeach
                </ul>

                <div class="flex">
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
