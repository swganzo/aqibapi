<div >
  <h4>{{$sensor->title}}</h4>
  <ul>
    @foreach ($sensor->header as $k=>$v)
      @if (!empty($sensor->lastreading->$k))
        <li>
          {{$v}}: {{$sensor->lastreading->$k}}
        </li>
      @endif
    @endforeach
  </ul>
  <div class="">
    {{__('Last Updated:')}} {{$sensor->lastreading->created_at->format('Y-m-d H:i:s')}}
  </div>
</div>
