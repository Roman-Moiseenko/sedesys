<!--template:Специалисты компании (версия 1.)-->
<div>
    <img src="{{ photo(15, 'card') }}">
    <br>
    Шаблон показа карточек сотрудников
    @if(isset($items) && !is_null($items))
    <div class="row">
        @foreach($items as $item)
            <div class="col-4">
                <img src="{{ $item->getImage('card') }}" width="100">
                <a href="{{ $item->getUrl() }}">{{ $item->getCaption() }}</a>
            </div>
        @endforeach
    </div>
    @endif
  <p>1</p>




  <p>2</p>
</div>
