@if(isset($item['submenu']))
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle {{ ($key == $active_menu['first']) ? 'active' : '' }}"
           href="{{ $item['url'] ?? '#' }}"
           id="navbarDropdown" role="button" aria-expanded="false">
            {{ $item['name'] }}
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            @foreach($item['submenu'] as $subkey => $subitem)
                @if(isset($subitem['submenu']))
                    <li class="dropdown-submenu">
                        @include('web.menu.item-sub', ['active' => ($subkey == $active_menu['second']), '_item' => $subitem ])
                        <ul class="dropdown-menu">
                            @foreach($subitem['submenu'] as $sub2key => $sub2item)
                                @include('web.menu.item', ['active' => ($sub2key == $active_menu['third']), '_item' => $sub2item ])
                            @endforeach
                        </ul>
                    </li>
                @else
                    @include('web.menu.item', ['active' => ($subkey == $active_menu['second']), '_item' => $subitem ])
                @endif
            @endforeach
        </ul>
    </li>
@else
    <li class="nav-item">
        <a class="nav-link dropdown-item {{ ($key == $active_menu['first']) ? 'active' : '' }}"
           href="{{ $item['url'] }}">
            {{ $item['name'] }}
        </a>
    </li>
@endif
