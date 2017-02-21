@php
  $class = '';
  if(!empty($item['children'])){
    $class = 'drowndown btn-group';
  }
@endphp
<li class="{{$class}}">
  <a class="btn" href="{{url($item['url'])}}">
    @if (!empty($item['icon']))
      <i class="fa fa-{{$item['icon']}}"></i>
    @endif
    {{$item['title']}}
  </a>
  @if(!empty($item['children']))
    <a class="btn dropdown-toggle" data-toggle="dropdown">
      <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
      @foreach ($item['children'] as $item)
        @include('modules.navigation.main.item', ['item' => $item])
      @endforeach
    </ul>
  @endif
</li>
