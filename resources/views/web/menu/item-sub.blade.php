<a class="dropdown-item" href="#">
    @if(!empty($_item['icon']))
        <img src="{{ $_item['icon'] }}" style="width: 20px;">
    @endif
    {{ $_item['name'] }}
    <i class="fa-light fa-chevron-right"></i>
</a>
