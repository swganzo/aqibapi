@php
if ($sensor->lastreading->pm25 < 50){
  $class='btn-success';
} elseif ($sensor->lastreading->pm25 < 100){
  $class='btn-primary';
} elseif ($sensor->lastreading->pm25 < 200){
  $class='btn-warning';
} elseif ($sensor->lastreading->pm25 > 200){
  $class='btn-danger';
}
@endphp
<a href="#" class="btn {{$class}} ">{{$sensor->lastreading->pm25}}</a>
