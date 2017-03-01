<tr data-id="{{$item->id}}">
  @foreach ($table as $k => $t)
    <td>
      {{-- If date --}}
      @if ($k=='created_at' || $k=='updated_at')
        @if (!empty($item->$k))
          {{$item->$k->toDayDateTimeString()}}
        @endif
      @else
        {{-- If realational multiple values --}}
        @if (is_object($item->$k))
          @php
          $values = [];
          if(!empty($item->$k->title)){
            $values[] = $item->$k->title;
          } else {
            foreach ($item->$k as $key => $value) {
              if(!empty($value->title)){
                $values[] = $value->title;
              }
            }
          }
          @endphp
          {{implode(', ',$values)}}
        @else
          {{$item->$k}}
        @endif
      @endif
      {{-- If It's Title Add Actions Under --}}
      @if ($k=='title' || $k=='name')
        @php
          $modaldata = [
            'id'=>$item->id,
            'table'=>$item->getTable(),
          ];
          $modaldata = json_encode($modaldata);
          // url('/servers/'.$server->id.'/edit')
        @endphp
        @if (!empty($module))
          <div class="small">
            <div class="btn-group">
              <a href="{{$item->url}}" class="btn-xs btn-primary btn" title="View"><i class="fa fa-eye"></i></a>
              <a href="#" data-action="modal" data-modalaction="remove-{{$item->getTable()}}" data-modaldata="{{$modaldata}}" data-modalbody="modules.confirm" data-modaltitle="Remove Item" class="btn-xs btn-danger btn"><i class="fa fa-remove"></i></a>
            </div>
          </div>
        @endif
      @endif

    </td>
  @endforeach
</tr>
