<form class="form-horizontal validate" method="POST">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <table class="table table-bordered table-hover" >
    <thead>
      @foreach ($head as $k => $t)
        <th data-id="{{$k}}">
          {{$t}}
        </th>
      @endforeach
    </thead>
    <tbody>
      @if ($items->count())
        @foreach ($items as $item)
          @include('modules.table.item', [
            'item' => $item,
            'table' => $head,
            'module' => $module
          ])
        @endforeach
      @else
        @include('modules.table.empty', [
          'table'=>$head,
          'module'=>$module
        ])
      @endif
    </tbody>
    @if (!empty($items->links()))
      <tfoot>
        <tr>
          <td colspan="{{count($head)}}">
            {{$items->links()}}
          </td>
        </tr>
      </tfoot>
    @endif
  </table>
</form>
