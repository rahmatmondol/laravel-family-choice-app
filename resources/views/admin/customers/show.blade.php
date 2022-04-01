@extends('admin.layouts.master')
<?php
$page = 'customers';
$title = __('site.Show Customer');
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
            <li class="breadcrumb-item"><a href="{{ route('admin.customers.index') }}">@lang('site.Customers')</a>
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
              <td>{{ $customer->full_name }}</td>
            </tr>
            <tr>
              <td>@lang('site.E-mail')</td>
              <td>{{ $customer->email }}</td>
            </tr>
            <tr>
              <td>@lang('site.Phone')</td>
              <td>{{ $customer->phone }}</td>
            </tr>
            <tr>
              <td>@lang('site.Date of birth')</td>
              <td>{{ $customer->date_of_birth }}</td>
            </tr>
            <tr>
              <td>@lang('site.Gender')</td>
              <td>@lang('site.'.$customer->gender)</td>
            </tr>
            <tr>
              <td>@lang('site.Status')</td>
              <td>@include('admin.partials._render_status',['status'=>$customer->status])</td>
            </tr>
            <tr>
              <td>@lang('site.Verified')</td>
              <td>@include('admin.partials._render_status',['status'=>$customer->verified])</td>
            </tr>
            <tr>
              <td>@lang('site.Image')</td>
              <td><img src="{{ $customer->image_path }}" style="width: 100px" class="img-thumbnail image-preview1"
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
