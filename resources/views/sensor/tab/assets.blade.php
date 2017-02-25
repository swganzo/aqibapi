{!!Form::open()!!}
<input type="hidden" name="id" value="{{$item->id}}">
<input type="hidden" name="_mode" value="data">
@if (!empty($item->datas->count()>0))
  @foreach(json_decode($item->datas) as $data)
    @include('projects.data.item', ['data' => $data])
  @endforeach
@endif
<hr>
<div id="data-container"></div>
<div class="text-center">
  <button type="button" class="btn btn-default btn-sm" data-action="addDataField" data-type="project">
    <i class="fa fa-plus"></i> Add Asset
  </button>
</div>
<hr>
<div class="text-center">
  <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
</div>
<div class="">
  <div class="asset-options">
    <div class="asset-website">
      <div class="col-md-2">
        <select class="form-control" name="data[][server]">
          @foreach ($item->servers as $server)
            <option value="{{$server->id}}">{{$server->title}}</option>
          @endforeach
        </select>
      </div>
    </div>
  </div>
</div>
{!!Form::close()!!}
