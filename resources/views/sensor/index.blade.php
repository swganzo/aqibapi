@extends('layouts.app')
@section('title')
  {{$title}}
@endsection
@section('content')
  <div class="container">
    <div class="row">
        <div class="col-md-12">
          <div class="panel panel-default ">
            <div class="panel-heading clearfix">
              <h4 class="pull-left">
                {{$title}}
              </h4>
              <div class=" pull-right ">
                <a class="btn btn-primary pull-left btn-block-xs" href="{{url('sensor/create')}}"><i class="fa fa-plus"></i> {{__('Add Sensor')}}</a>
                <div class="btn hidden-xs">
                  |
                </div>
                <div class="pull-right">
                  @include('modules.search.inline')
                </div>
              </div>
            </div>
            <div class="panel-body">
              @include('modules.table',[
                'head'=>$table,
                'module'=>'sensor',
                'items'=>$items
              ])
            </div>
          </div>
        </div>
      </div>
    </div>

  @endsection
