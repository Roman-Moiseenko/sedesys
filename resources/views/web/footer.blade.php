<footer class="">
    <div class="container-xl pb-4">
        <div class="row">
            <div class="col-lg-6">
                <div class="heading">SeDeSys</div>
                <div class="description">

                </div>
            </div>
            <div class="col-lg-1"></div>
            <div class="col-lg-5">
                <div class="row">
                    @foreach($menu_footer as $column)
                        <div class="col-lg-6 px-2">
                            <div class="menu-column">
                                <div class="">{{ $column['title'] }}</div>
                                <ul class="menu">
                                    @foreach($column['items'] as $item)
                                        <li><a href="{{ $item['url'] }}">{{ $item['name'] }}</a></li>
                                    @endforeach

                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="about pt-4 pb-3 text-center">
        <p>2022 - {{date('Y')}} | Разработано <a href="https://website39.site" title="Разработка CRM и интернет-магазинов" target="_blank">Веб-студия Web39</a></p>
    </div>
</footer>

