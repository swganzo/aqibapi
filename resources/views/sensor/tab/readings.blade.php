@php
  dump(env('GMAP_API'));
  $items = $item->readings()->where('created_at','>=',new \Carbon\Carbon('yesterday'));
@endphp
<div class="panel-body">
  {{__('Today\'s Readings')}}
  <table>
    <tr>
      <td>
        PM2.5
      </td>
      <td>
        <canvas id="myChart" height="200"></canvas>
      </td>
    </tr>
  </table>

</div>
