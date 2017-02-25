@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      @include('includes.projects_sidebar')
      @include('modules.search',[
        'url'=>'projects',
        'field'=>'title-filter',
        'placeholder'=>'Title'
      ])
      <div class="col-md-8">
        <div class="panel panel-default">
          <div class="panel-heading">
            Projects
          </div>
          <div class="panel-body">
            @include('modules.table',[
              'head'=>[
                'title'=>'Title',
                'owner_name'=>'Owner',
                'created_at'=>'Created',
              ],
              'module'=>'projects',
              'items'=>$projects
            ])
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
