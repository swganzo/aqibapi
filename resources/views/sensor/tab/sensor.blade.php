<hr>
<div class=" clearfix">
  <div class="pull-right">
    <div class="btn-group">
      <a href="#" class="btn btn-sm btn-primary" data-action="toggleDiv" data-div="editForm" data-hide="viewForm"><i class="fa fa-edit"></i> Edit</a>
      <a href="#" class="btn btn-sm btn-default" data-action="toggleDiv" data-div="viewForm" data-hide="editForm"><i class="fa fa-eye"></i> View</a>
    </div>
  </div>
</div>
<hr>
<div class="panel-body viewForm" style="display:block">
  @include('sensor.form', ['item' => $item,'readonly'=>'true'])
</div>
<div class="panel-body editForm" style="display:none">
  @include('sensor.form', ['item' => $item])
</div>
