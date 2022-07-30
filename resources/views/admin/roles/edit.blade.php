@extends($masterLayout)
<?php
$page = 'roles';
$title = __('site.Edit Role');
?>
@section('title_page')
{{ $title }}
@endsection
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h6>{{ $title }}</h6>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('site.Home')</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">@lang('site.Roles')</a>
            </li>
            <li class="breadcrumb-item active">{{ $title }}</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <form method="post" action="{{ route('admin.roles.update',$role->id)}}">
      @csrf
      @method('put')
      @include('admin.partials._errors')
      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-body">
              {{-- name --}}
              <div class="form-group">
                <label for="inputName"> @lang('site.Name')</label>
                <input type="text" name="name" value="{{ old('name',$role->name) }}" required class="form-control">
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-body">
              {{-- status --}}
              <div class="form-group">
                <label for="inputStatus">@lang('site.Status')</label>
                <select id="inputStatus" name="status" required class="form-control custom-select">
                  <option value='' selected disabled>@lang('site.Status')</option>
                  <option value="1" @if(old('status',$role->status)==1) selected @endif >@lang('site.Active')</option>
                  <option value="0" @if(old('status',$role->status)==0) selected @endif >@lang('site.In-Active')
                  </option>
                </select>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <div class="col-md-12">
          <div class="card card-secondary">
            <div class="card-body">
              {{-- start permissions--}}
              <div class="form-group">
                <h4>@lang('site.Permissions')</h4>
                <div class="table-responsive">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th style="width: 5%;">#</th>
                        <th style="width: 15%;">@lang('site.Model')</th>
                        <th>@lang('site.Permissions')</th>
                      </tr>
                    </thead>

                    <tbody>

                      @foreach (getModules() as $index=>$model)
                      <tr>
                        <td>{{ $index+1 }}</td>
                        <td class="text-capitalize">{{ $model }}</td>
                        <td>
                          @php
                          $permission_maps = ['create', 'read', 'update', 'delete'];
                          @endphp

                          <div class="form-group clearfix">
                            @foreach ($permission_maps as $permission_map)
                            <div class="icheck-primary d-inline">
                              <label for="{{ $permission_map . '_' . $model }}">
                                {{ $permission_map }}
                                <input type="checkbox" name="permissions[]" value="{{ $permission_map . '_' . $model }}"
                                  {{ $role->hasPermission($permission_map .
                                '_' . $model) ? 'checked' : '' }}
                                id="{{ $permission_map . '_' . $model }}">
                              </label>
                            </div>
                            @endforeach
                          </div>

                        </td>
                      </tr>
                      @endforeach

                    </tbody>
                  </table>
                </div>
              </div>
              {{-- end permissions--}}
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <button class="btn btn-success" type="submit" name='continue' value='continue'><i class="fas fa-save"></i>
            @lang('site.Save & Continue')</button>
          <button class="btn btn-success" type="submit"><i class="fas fa-save"></i> @lang('site.Save')</button>
        </div>
      </div>
    </form>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
