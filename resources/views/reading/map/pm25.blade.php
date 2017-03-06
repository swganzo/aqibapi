@php
// $style = 'width:'.$sensor->lastreading->pm25.'px;height:'.$sensor->lastreading->pm25.'px;';
// $style = 'width:500px;height:500px;';
$style = '';
if ($sensor->lastreading->pm25 < 50){
  $class='aqi good';
} elseif ($sensor->lastreading->pm25 < 100){
  $class='aqi moderate';
} elseif ($sensor->lastreading->pm25 < 150){
  $class='aqi group_unhealty';
} elseif ($sensor->lastreading->pm25 < 200){
  $class='aqi unhealty';
} elseif ($sensor->lastreading->pm25 < 300){
  $class='aqi very_unhealty';
} elseif ($sensor->lastreading->pm25 > 300){
  $class='aqi hazardous';
}
@endphp
  <a id="sensor-btn-{{$sensor->id}}" href="#" style="{{$style}}" class="{{$class}} ">{{$sensor->lastreading->pm25}}</a>
