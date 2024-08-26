<a class="dropdown-item {{ $active ? 'active' : '' }}" href="{{ $_item['url'] ?? '#' }}">
    @if(!empty($_item['image']))
        <img src="{{ $_item['image'] }}" style="width: 20px;">
    @elseif(!empty($_item['icon']))
        <i class="{{ $_item['icon'] }}"></i>
    @endif
    {{ $_item['name'] }}
    <i class="fa-light fa-chevron-right"></i>
</a>
