<a class="dropdown-item {{ $active ? 'active' : '' }}" href="{{ $_item['url'] ?? '#' }}">
    {!! $_item['icon'] !!} {{ $_item['name'] }}
    <i class="fa-light fa-chevron-right"></i>
</a>
