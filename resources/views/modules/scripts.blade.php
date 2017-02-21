@foreach ($scripts as $script)
  @if (strpos($script,"//") !== false)
    <script src="{{$script}}" ></script>
  @else
    <script src="{{asset('js/'.$script)}}" ></script>
  @endif
@endforeach
