@extends('admin.layouts.master')
<?php
$page = 'reservations';
$title = __('site.Edit Reservation');
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
            <li class="breadcrumb-item"><a href="{{ route('admin.reservations.index') }}">@lang('site.Reservations')</a>
            </li>
            <li class="breadcrumb-item active">{{ $title }}</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <form method="post" action="{{ route('admin.reservations.update',$admin->id)}}" enctype="multipart/form-data">
      @csrf
      @method('put')
      @include('admin.partials._errors')
      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-body">

              {{-- first_name --}}
              <div class="form-group">
                <label for="inputName"> @lang('site.First Name')</label>
                <input type="text" name="first_name" value="{{ old('first_name',$admin->first_name) }}" required
                  class="form-control">
              </div>
              {{-- last_name --}}
              <div class="form-group">
                <label for="inputName"> @lang('site.Last Name')</label>
                <input type="text" name="last_name" value="{{ old('last_name',$admin->last_name) }}" required
                  class="form-control">
              </div>
              {{-- email --}}
              <div class="form-group">
                <label for="inputName"> @lang('site.E-mail')</label>
                <input type="email" name="email" value="{{ old('email',$admin->email) }}" required class="form-control">
              </div>
              {{-- passwrod --}}
              <div class="form-group">
                <label>@lang('site.password')</label>
                <input type="password" name="password" class="form-control">
              </div>
              {{-- password_confirmation --}}
              <div class="form-group">
                <label>@lang('site.password_confirmation')</label>
                <input type="password" name="password_confirmation" class="form-control">
              </div>

            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-body">
              {{-- roles --}}
              <div class="form-group">
                <label>@lang('site.Roles')</label>
                <select name="roles[]" class="form-control selectric" multiple required>
                  @foreach ($roles as $role)
                  <option value="{{ $role->id }}" @if( in_array($role->id,$admin->roles->pluck('id')->toArray()) ||
                    in_array($role->id,(array)old('roles'))) selected @endif>{{
                    $role->name }}</option>
                  @endforeach
                </select>
                <a href="{{ route('admin.roles.create') }}">@lang('site.Create new role')</a>
              </div>
              {{-- status --}}
              <div class="form-group">
                <label for="inputStatus">@lang('site.Status')</label>
                <select id="inputStatus" name="status" required class="form-control custom-select">
                  <option value='' selected disabled>@lang('site.Status')</option>
                  <option value="1" @if(old('status',$admin->status)==1) selected @endif>@lang('site.Active')</option>
                  <option value="0" @if(old('status',$admin->status)==0) selected @endif>@lang('site.In-Active')
                  </option>
                </select>
              </div>

              <div class="form-group">
                <label>@lang('site.image')</label>
                <input type="file" id='image' name="image" class="form-control image1">
              </div>

              <div class="form-group">
                <img src="{{ $admin->image_path }}" style="width: 100px" class="img-thumbnail image-preview1" alt="">
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
