@extends('admin.layouts.master')
<?php
$page = 'admins';
$title = __('site.Show Admin');
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
            <li class="breadcrumb-item"><a href="{{ route('admin.admins.index') }}">@lang('site.Admins')</a>
            </li>
            <li class="breadcrumb-item active">{{ $title }}</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Content -->
  <div class="card mt-4 content-table">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <tbody>
            <tr>
              <td>@lang('site.Name')</td>
              <td>{{ $admin->full_name }}</td>
            </tr>
            <tr>
              <td>@lang('site.Status')</td>
              <td>@include('admin.partials._render_status',['status'=>$admin->status])</td>
            </tr>
            <tr>
              <td>@lang('site.Permissions')</td>
              <td>
                @foreach ($admin->permissions as $permission)
                <span class="btn btn-primary btn-customs py-1 px-2">{{ $permission->name }}</span>
                @endforeach
              </td>
            </tr>
            <tr>
              <td>@lang('site.Image')</td>
              <td><img src="{{ $admin->image_path }}" style="width: 100px" class="img-thumbnail image-preview1"
                  alt=""></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <!-- //Content -->
</div>
<!-- /.content-wrapper -->
@endsection
