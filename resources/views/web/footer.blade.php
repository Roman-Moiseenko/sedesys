<footer class="footer">
    <div class="container pb-4 ">
        <div class="row">
            @foreach($menu_footer as $column)
                <div class="col-lg-4 px-2">
                    <div class="menu-column">
                        <div class="">{{ $column['title'] }}</div>
                        <ul class="menu">
                            @foreach($column['items'] as $item)
                                <li><a href="{{ route($item['route']) }}">{{ $item['name'] }}</a></li>
                            @endforeach

                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="about pt-4 pb-3 text-center">
        <p>2022 - {{date('Y')}} | Разработано <a href="https://website39.site"
                                                 title="Разработка CRM и интернет-магазинов" target="_blank">Веб-студия
                Web39</a></p>
    </div>
</footer>

