@extends($masterLayout)
<?php
$page = 'schools';
$title = __('site.Change Password');
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
            <li class="breadcrumb-item"><a href="{{ route($mainRoutePrefix.'.dashboard') }}">@lang('site.Home')</a></li>
            <li class="breadcrumb-item"><a href="{{ route($mainRoutePrefix.'.schools.index') }}">@lang('site.Schools')</a>
            </li>
            <li class="breadcrumb-item active">{{ $title }}</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <form method="post" action="{{ route($mainRoutePrefix.'.profile.change-password-post')}}" >
      @csrf
      @method('post')
      @include('admin.partials._errors')
      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-body">

              {{-- current_password --}}
              <div class="form-group">
                <label>@lang('site.Current Password')</label>
                <input type="password" name="current_password" class="form-control" required>
              </div>

              <div class="form-group">

              </div>

            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-body">

              {{-- passwrod --}}
              <div class="form-group">
                <label>@lang('site.Password')</label>
                <input type="password" name="password" class="form-control" required>
              </div>

              {{-- password_confirmation --}}
              <div class="form-group">
                <label>@lang('site.Password Confirmation')</label>
                <input type="password" name="password_confirmation" class="form-control" required>
              </div>

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
