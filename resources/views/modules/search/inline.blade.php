<form class="form-inline validate" method="GET">
  <div class="form-group">
    <div class="input-group">
      <input type="text" class="form-control  required" name="search" id="search" placeholder="Search" value="{{request('search')}}">
      <span class="input-group-btn">
        <button type="submit input-group-btn" class="btn btn-default"><i class="fa fa-search"></i> Search</button>
      </span>
    </div>
  </div>
</form>
