@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading clearfix">
            <h4 class="pull-left">
              {{$title}}
            </h4>
          </div>
          @if (!empty($item))
            <div class="panel-body">
              <ul class="nav nav-tabs" role="tablist">
                @foreach ($tabs as $key => $tab)
                  <li role="presentation" @if($key == 'sensor') class="active" @endif >
                    <a href="#{{$key}}" aria-controls="{{$key}}" role="tab" data-toggle="tab">{{$tab}}</a>
                  </li>
                @endforeach
              </ul>
              <div class="tab-content">
                @foreach ($tabs as $key => $tab)
                  <div role="tabpanel" class="tab-pane @if($key == 'sensor') active @endif" id="{{$key}}">
                    @includeIf('sensor.tab.'.$key, ['item' => $item])
                  </div>
                @endforeach
              </div>
            </div>
          @else
            <div class="panel-body" >
              @include('sensor.form', ['item' => null])
            </div>
          @endif
        </div>

      </div>
    </div>
  </div>
@endsection
