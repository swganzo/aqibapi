@php
if(empty($readonly)){
  $readonly = false;
}
@endphp

@include('modules.response')

{!!Form::open(['class'=>'preventSubmit validate'])!!}
<div class="panel-body">
  @if (!empty($item))
    <input type="hidden" name="id" value="{{$item->id}}">
  @endif

  @include('modules.form.field', [
    'item' => $item,
    'title'=> __('Sensor Title'),
    'id'=>'title',
    'required'=>true,
    'readonly'=>$readonly,
  ])
  @if ($readonly == true)
    @include('modules.form.field', [
      'item' => $item,
      'title'=> __('API Key'),
      'id'=>'api_key',
      'readonly'=>$readonly,
      'help'=>'Use this key for your sensor'
    ])
  @endif
  @if ($readonly == false)
    <div class="text-center">
      <button type="reset" name="button" class="btn btn-warning">Reset</button>
      <a data-action="store" data-type="sensor" href="#" class="btn btn-primary"><i class="fa fa-save"></i> Store</a>
    </div>
  @endif
</div>
{!!Form::close()!!}
