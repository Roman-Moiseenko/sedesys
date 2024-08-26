<li class="nav-item">
    <a class="nav-link dropdown-item {{ $active ? 'active' : '' }}"
       href="{{ $_item['url'] }}">
        <!-- Вставляем иконку png -->
        @if(!empty($_item['icon']))
            <img src="{{ $_item['icon'] }}" style="width: 20px;">
        @endif
        {{ $_item['name'] }}
    </a>
</li>
