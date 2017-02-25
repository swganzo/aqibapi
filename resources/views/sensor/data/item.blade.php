<div class="form-group row">
  <div class="col-md-2">
    <input type="text" class="form-control" name="data[{{$data->id}}][title]" placeholder="Title" value="{{ $data->title }}">
  </div>
  <div class="col-md-2">
    <select class="form-control" name="data[{{$data->id}}][type]">
      <option value="website">Website</option>
    </select>
  </div>
  
  <div class="col-md-1">
    <button type="button" class="btn noform btn-default btn-warning" data-action="deleteDataField" >
      Delete
    </button>
  </div>
</div>
<hr>
