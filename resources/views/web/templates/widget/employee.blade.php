<div>
    Шаблон показа карточек сотрудников
    <div class="row">
        @foreach($items as $item)
            <div class="col-4">
                <img src="{{ $item->getimage() }}" width="100">
                <a href="{{ $item->getUrl() }}">{{ $item->getCaption() }}</a>
            </div>
        @endforeach
    </div>
</div>
