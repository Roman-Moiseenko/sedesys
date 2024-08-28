<li class="nav-item">
    <a class="dropdown-item {{ $active ? 'active' : '' }}"
       href="{{ $_item['url'] }}">
        {!! $_item['icon'] !!} {{ $_item['name'] }}
    </a>
</li>
