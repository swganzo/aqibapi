@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      @include('includes.projects_sidebar')
      <div class="col-md-10">
        <div class="panel panel-default">
          <div class="panel-heading">
            View Project
            &nbsp;&nbsp;
            <div class="btn-group btn-group-xs" role="group" aria-label="...">
              <a href="{{ url('/projects/'.$project->id.'/edit') }}" role="button" class="btn btn-default">
                Edit
              </a>
            </div>
          </div>
          <div class="panel-body">
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active"><a href="#edit-basic" aria-controls="edit-basic" role="tab" data-toggle="tab">Basic Info</a></li>
              <li role="presentation"><a href="#edit-data" aria-controls="edit-data" role="tab" data-toggle="tab">Data</a></li>
              <li role="presentation"><a href="#edit-servers" aria-controls="edit-servers" role="tab" data-toggle="tab">Servers</a></li>
              <li role="presentation"><a href="#repositories" aria-controls="repositories" role="tab" data-toggle="tab">Repositories</a></li>
            </ul>
            <br />
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="edit-basic">
                <table class="table table-bordered" style="margin-bottom:0px;">
                  <tbody>
                    <tr>
                      <td class="text-right"><strong>Project Title</strong>
                      </td>
                      <td>{{ $project->title }}
                      </td>
                    </tr>
                    <tr>
                      <td class="text-right"><strong>Users With Access</strong>
                      </td>
                      <td>
                        <ul>
                          @each('modules.user.list.item', $project->users, 'user')
                        </ul>
                      </td>
                    </tr>
                    @if ($project->companies->count()>0)
                      @include('modules.company.list',['companies'=>$project->companies])
                    @endif
                  </tbody>
                </table>
                @if($jira)
                  <br>Access project on Jira <a href="{{ $jira }}" target="_BLANK">here</a>.
                @endif
              </div>
              <div role="tabpanel" class="tab-pane" id="edit-data">
                @if ($project->datas->count()>0)
                  <table class="table table-bordered" style="margin-bottom:0px;">
                    <tbody>
                      @foreach($project->datas as $data)
                        <tr>
                          <td class="text-right">
                            <strong>
                              {{ $data->title }}
                            </strong>
                          </td>
                          <td>
                            {{ $data->content }}
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                @else
                  <div class="alert alert-warning">
                    No Data Added. Click Edit button above to add Data. You can add various type of data in this section.
                  </div>
                @endif
              </div>
              <div role="tabpanel" class="tab-pane" id="edit-servers">
                @if ($project->servers->count() > 0)
                  <table class="table table-bordered" style="margin-bottom:0px;">
                    <tbody>
                      <tr>
                        <td class="text-right"><strong>
                          Attached Servers
                        </strong></td>
                        <td>
                          @foreach($project->servers as $s)
                            <a href="{{ url('/servers/'.$s->id) }}">{{ $s->title }}</a><br />
                          @endforeach
                          <div style="height:0px;margin:0px;overflow:hidden;">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                @else
                  <div class="alert alert-warning">
                    No Server attached. Click Edit button above to attach Server.
                  </div>
                @endif
              </div>
              <div role="tabpanel" class="tab-pane" id="repositories">
                @if ($project->bitbuckets->count() > 0)
                  <ul>
                    @foreach($project->bitbuckets as $repo)
                      <?php $content = json_decode($repo->content); ?>
                      <li>
                        @if (!empty($content->info))
                          <a href="{{ $content->info->links->html->href }}" target="_blank"><p class="form-control-static">{{ $content->info->full_name }}</p></a>
                        @endif
                      </li>
                    @endforeach
                  </ul>
                @endif
                <div class="alert alert-warning">
                  You can clone or pull from a repo from a server's page.
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
