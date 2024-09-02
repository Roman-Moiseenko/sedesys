<!--template:Специалист 3 в ряд.-->
<div>
    Новый Шаблон показа карточек сотрудников
  @if(isset($items) && !is_null($items))
    <div class="">
        @foreach($items as $item)
            <div class="card">
                <img src="{{ $item->getImage('card') }}" width="100">
                <a href="{{ $item->getUrl() }}">{{ $item->getCaption() }}</a>
            </div>
     
        @endforeach
    </div>
  @endif
  <p>1</p>
  
  <p>2</p>
</div>