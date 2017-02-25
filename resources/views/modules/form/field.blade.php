@php
// Retrive value
if(empty($value)){
  if (empty($item)) {
    if(!empty($default)){
      $value = $default;
    } else {
      $value = old($id);
    }
  } else {
    if(is_object($item->$id)){
      $values = $item->$id;
      $value = [];
      foreach ($item->$id as $i) {
        $value[] = $i->id;
      }
    } else {
      $value = $item->$id;
    }
  }
}

// Turn into array
if(empty($type)){
  $type = 'input';
}
switch ($type) {
  case 'checkbox':
  case 'multiselect':
    if(!is_array($value)){
      $value = [$value];
    }
    break;

  default:
    # code...
    break;
}
// placeholder check
if (empty($placeholder)) {
  if(!empty($title)){
    $placeholder = 'placeholder="'.$title.'"';
  }
} elseif ($placeholder == false) {
  $placeholder = '';
} else {
  $placeholder = 'placeholder="'.$placeholder.'"';
}
// class check
if(empty($class)){
  $class = '';
}
// required check
if (!empty($required)) {
  $class = $class.' required';
}
// action check
if (!empty($action)) {
  $class = $class.' hasAction';
  $action = 'data-action="'.$action.'"';
} else {
  $action = '';
}
@endphp

<div class="form-group row">
  @if (!empty($title) && $title != false)
    <label for="{{$id}}" class="col-md-3 control-label">
      {{$title}}
      @if (!empty($required))
        <span class="required text-danger">*</span>
      @endif
    </label>
  @endif
    <div class="col-md-9">

      {{-- if Readonly just show data --}}
      @if (!empty($readonly))
        @if ($type == 'image')
          <img src="{{$value}}" alt="">
        @elseif ($type == 'radio')
          {{$options[$value]}}
        @elseif ($type == 'selectlist' && !empty($values))
          @include('modules.list', ['items'=>$values])
        @else
          @if(!empty($reveal) && $reveal == true)
            <div class="reveal">
            </div>
            <a href="#" class="btn btn-default btn-sm" data-show="{{$value}}" data-action="reveal"> <i class="fa fa-eye"></i> show</a>
          @else
            {{$value}}
          @endif
        @endif
      @else
        @if ($type == 'input')
          <input type="text" class="form-control {{$class}}" name="{{$id}}" id="{{$id}}" {!!$placeholder!!} value="{{ $value }}" {!!$action!!}>
        @elseif ($type == 'number')
          <input type="number" class="form-control {{$class}}" name="{{$id}}" id="{{$id}}" {!!$placeholder!!} value="{{ $value }}" {!!$action!!}>
        @elseif ($type == 'image')
          @if (!empty($value))
            <img src="{{Storage::url($value)}}" alt="" class="img-thumbnail">
          @endif
          <input type="file" class="form-control {{$class}}" name="{{$id}}" id="{{$id}}" {!!$placeholder!!} value="{{ $value }}" {!!$action!!}>
        @elseif ($type == 'password')
          <input type="password" class="form-control {{$class}}" name="{{$id}}" id="{{$id}}" {!!$placeholder!!} {!!$action!!}>
        @elseif ($type == 'textarea')
          <textarea type="text" class="form-control {{$class}}" name="{{$id}}" id="{{$id}}" {!!$placeholder!!} {!!$action!!}>{{ $value }}</textarea>
        @elseif ($type == 'radio')
          @foreach ($options as $v => $l)
            <div class="radio">
              <label><input type="radio" class="{{$class}}" name="{{$id}}" value="{{$v}}" @if ($v==$value) checked @endif {!!$action!!}>{{$l}}</label>
              </div>
            @endforeach
        @elseif ($type == 'checkbox')
          @foreach ($options as $v => $l)
            <div class="checkbox">
              <label><input type="checkbox" class="{{$class}}" name="{{$id}}[]" value="{{$v}}" @if (in_array($v,$value)) checked @endif {!!$action!!}>{{$l}}</label>
              </div>
            @endforeach
        @elseif ($type == 'select' || $type == 'multiselect')
          <select class="form-control {{$class}}" id="{{$id}}" name="{{$id}}" {!!$action!!} @if ($type == 'multiselect') multiple @endif>
            @foreach ($options as $v => $l)
              <option value="{{$v}}" @if ($v == $value) selected @endif>{{$l}}</option>
              @endforeach
            </select>
        @elseif ($type == 'selectlist')
          <div class="{{$id}}-list">
            @if (!empty($values))
              @foreach ($values as $k => $v)
                @include('modules.selectlist.item',
                [
                  'field'=>$id,
                  'id'=>$v->id,
                  'title' => $v->title,
                  'checked'=>true
                ])
              @endforeach
            @endif
          </div>
          @php
            $modaldata = '';
            if (isset($value)) {
              $modaldata = [
              'ignore' => $value
              ];
              $modaldata = json_encode($modaldata);
            }
          @endphp
          <a href="#" class="hasAction btn btn-primary" data-action="modal" data-modaldata="{{$modaldata}}" data-modalaction="add-{{$id}}" data-modalbody="modules.selectlist" data-modaltitle="Add {{$title}}">
            <i class="fa fa-plus"></i> Add {{$title}}
          </a>
        @else

        @endif
      @endif
      @if (!empty($help))
        <span class="help-block">{{$help}}</span>
      @endif
    </div>
</div>
