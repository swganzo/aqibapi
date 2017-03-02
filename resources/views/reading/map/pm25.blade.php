@php
if ($sensor->lastreading->pm25 < 50){
  $class='btn-success';
} elseif ($sensor->lastreading->pm25 < 100){
  $class='btn-primary';
}

@endphp
<a href="#" class="btn {{$class}} ">{{$sensor->lastreading->pm25}}</a>
