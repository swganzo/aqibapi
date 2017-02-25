@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      @include('includes.projects_sidebar')
      <div class="col-md-10">
        <div class="panel panel-default">
          <div class="panel-heading">
            Edit Project
            &nbsp;&nbsp;
            <div class="btn-group btn-group-xs" role="group" aria-label="...">
              <a href="{{ url('/projects/'.$project->id) }}" role="button" class="btn btn-default">
                Show
              </a>
            </div>
          </div>
          <div class="panel-body">
            @include('modules.errors')
            @include('modules.message')
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active"><a href="#edit-basic" aria-controls="edit-basic" role="tab" data-toggle="tab">Basic Info</a></li>
              <li role="presentation"><a href="#edit-data" aria-controls="edit-data" role="tab" data-toggle="tab">Data</a></li>
              <li role="presentation"><a href="#edit-servers" aria-controls="edit-servers" role="tab" data-toggle="tab">Servers</a></li>
              <li role="presentation"><a href="#repositories" aria-controls="repositories" role="tab" data-toggle="tab">Repositories</a></li>
              <li role="presentation"><a href="#platforms" aria-controls="plat" role="tab" data-toggle="tab">Platforms</a></li>
              <li role="presentation"><a href="#delete" aria-controls="delete" role="tab" data-toggle="tab">Delete</a></li>
            </ul>
            <br />
            <div class="tab-content">

              <div role="tabpanel" class="tab-pane" id="edit-data">
                
              </div>
              <div role="tabpanel" class="tab-pane" id="edit-servers">
                <form class="form-horizontal" action="{{ url('/projects/'.$project->id) }}" method="POST">
                  {{ method_field('PUT') }}
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <input type="hidden" name="_mode" value="attach-server">
                  <div class="form-group">
                    <label for="serverid" class="col-sm-2 control-label">Attach a server</label>
                    <div class="col-sm-8">
                      <select id="serverid" name="serverid" class="form-control">
                        <option value="0">--</option>
                        @foreach($servers as $server)
                          <option value="{{ $server->id }}">{{ $server->title }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-sm-2">
                      <button type="submit" class="btn btn-default">Attach</button>
                    </div>
                  </div>
                </form>
                <hr />
                @foreach($project->servers as $s)
                  <form class="form-horizontal" action="{{ url('/projects/'.$project->id) }}" method="POST">
                    {{ method_field('PUT') }}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_mode" value="detach-server">
                    <input type="hidden" name="_server" value="{{ $s->id }}">
                    <div class="form-group">
                      <strong><span class="col-sm-2 control-label">Detach server</span></strong>
                      <div class="col-sm-8">
                        <a href="{{ url('/servers/'.$s->id) }}" target="_blank"><p class="form-control-static">{{ $s->title }}</p></a>
                      </div>
                      <div class="col-sm-2">
                        <button type="submit" class="btn btn-default">Detach</button>
                      </div>
                    </div>
                  </form>
                @endforeach
              </div>
              <div role="tabpanel" class="tab-pane" id="repositories">
                <form class="form-horizontal" action="{{ url('/projects/'.$project->id.'/create_bitbucket_repo') }}" method="POST">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Create Repository</label>
                    <div class="col-sm-8">
                      <select id="repo_create_mode" name="repo_create_mode" class="form-control">
                        <option value="0" selected="true">--</option>
                        <option value="under_arcane">Create under Arcane Strategies</option>
                        <option value="under_account">Create under your account</option>
                        <option value="existing">Add existing repository</option>
                      </select>
                      <br />
                      <div style="display:none;" id="add_existing_repository">
                        <label for="existing_bitbucket_username" class="control-label">Bitbucket Username</label>
                        <input type="text" class="form-control" name="existing_bitbucket_username" id="existing_bitbucket_username" placeholder="Bitbucket Username" value="{{ old('existing_bitbucket_username') }}">
                        <label for="existing_bitbucket_password" class="control-label">Bitbucket Password</label>
                        <input type="password" class="form-control" name="existing_bitbucket_password" id="existing_bitbucket_password" placeholder="Bitbucket Password"  value="{{ old('existing_bitbucket_password') }}">
                        <label for="repo_slug" class="control-label">Full Name</label>
                        <input type="text" class="form-control" name="existing_repo_name" id="existing_repo_name" placeholder="example/example"  value="{{ old('existing_repo_name') }}">
                      </div>
                      <div style="display:none;" id="create_repository">
                        <div style="display:none;" id="create_repository_under_arcane">
                        </div>
                        <div style="display:none;" id="create_repository_under_account">
                          <label for="bitbucket_username" class="control-label">Bitbucket Username</label>
                          <input type="text" class="form-control" name="bitbucket_username" id="bitbucket_username" placeholder="Bitbucket Username" value="{{ old('bitbucket_username') }}">
                          <label for="bitbucket_password" class="control-label">Bitbucket Password</label>
                          <input type="password" class="form-control" name="bitbucket_password" id="bitbucket_password" placeholder="Bitbucket Password"  value="{{ old('bitbucket_password') }}">
                        </div>
                        <label for="repo_slug" class="control-label">Slug</label>
                        <input type="text" class="form-control" name="repo_slug" id="repo_slug" placeholder="Slug"  value="{{ old('repo_slug') }}">
                        <label for="repo_description" class="control-label">Description</label>
                        <textarea class="form-control" id="repo_description" name="repo_description">{{ old('repo_description') }}</textarea>
                        <div class="checkbox">
                          <label>
                            <input name="repo_private" id="repo_private" value="true" type="checkbox"> Private Repository
                          </label>
                        </div>
                        <div style="display:none;" id="repo_is_private">
                          <label for="repo_forking" class="control-label">Forking Policy</label>
                          <select id="repo_forking" name="repo_forking" class="form-control">
                            <option value="no_public_forks">Allow Only Private Forks</option>
                            <option value="allow_forks">Allow Forks</option>
                            <option value="no_forks">No Forks</option>
                          </select>
                        </div>
                        <label for="repo_language" class="control-label">Language</label>
                        <input type="text" class="form-control" name="repo_language" id="repo_language" placeholder="Language"  value="{{ old('repo_language') }}">
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <button style="display:none;" id="create_repository_button" type="submit" class="btn btn-default">Create</button>
                    </div>
                  </div>
                </form>
                <hr />
                @foreach($project->bitbuckets as $repo)
                  <?php $content = json_decode($repo->content); ?>
                  <form class="form-horizontal" action="{{ url('/projects/'.$project->id) }}" method="POST">
                    {{ method_field('PUT') }}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_mode" value="remove_repo">
                    <input type="hidden" name="_repo" value="{{ $repo->id }}">
                    <div class="form-group">
                      <strong><span class="col-sm-2 control-label">Repositories</span></strong>
                      <div class="col-sm-8">
                        <a href="{{ $content->info->links->html->href }}" target="_blank"><p class="form-control-static">{{ $content->info->full_name }}</p></a>
                      </div>
                      <div class="col-sm-2">
                        <button type="submit" class="btn btn-default">Remove</button>
                      </div>
                    </div>
                  </form>
                @endforeach
                <p class="help-block">
                  <br />
                  Removing a repository does not delete it,
                  <br />
                  neither on Bitbucket nor on servers where it has been cloned.
                  <br />
                  It merely removes the record from DOSA.
                </p>
              </div>
              <div role="tabpanel" class="tab-pane" id="platforms">

              </div>
              <div role="tabpanel" class="tab-pane" id="delete">
                <button data-action="revealDelete" class="btn btn-danger">Delete</button>
                <br />
                <br />
                <form id="final-delete" style="display:none; float:left; margin-right:20px; margin-left:13px;" role="form" class="form-horizontal" action="{{ url('/projects/'.$project->id) }}" method="POST">
                  <input type="hidden" name="_method" value="DELETE">
                  {{ csrf_field() }}
                  <div class="form-group">
                    <input type="submit" class="btn btn-danger" value="Yes, delete.">
                  </div>
                </form>
                <button style="display:none; float:left;" data-action="revealDelete" class="btn btn-success">No, don't delete.</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
