@foreach ($styles as $style)
  @if (strpos($style,"//") !== false)
    <link href="{{$style}}" rel="stylesheet">
  @else
    <link href="{{asset('css/'.$style)}}" rel="stylesheet">
  @endif
@endforeach
