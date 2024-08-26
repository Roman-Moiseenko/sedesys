<li class="nav-item">
    <a class="nav-link dropdown-item {{ $active ? 'active' : '' }}"
       href="{{ $_item['url'] }}">
        <!-- Вставляем иконку png -->
        @if(!empty($_item['image']))
            <img src="{{ $_item['image'] }}" style="width: 20px;">
        @elseif(!empty($_item['icon']))
            <i class="{{ $_item['icon'] }}"></i>
        @endif
        {{ $_item['name'] }}
    </a>
</li>
