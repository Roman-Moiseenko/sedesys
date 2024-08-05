<!--template:Специалисты компании (версия 1.)-->
<div>
    <img src="{{ photo(15, 'card') }}">
    <br>
    Шаблон показа карточек сотрудников
    <div class="row">
        @foreach($items as $item)
            <div class="col-4">
                <img src="{{ $item->getimage() }}" width="100">
                <a href="{{ $item->getUrl() }}">{{ $item->getCaption() }}</a>
            </div>
        @endforeach
    </div>
  <p>1</p>
  
  
  
  
  <p>2</p>
</div>