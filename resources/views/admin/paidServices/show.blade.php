@extends($masterLayout)
<?php
$page = 'paidServices';
$title = __('site.Show Paid Service');
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
            <li class="breadcrumb-item"><a href="{{ route($mainRoutePrefix.'.paidServices.index') }}">@lang('site.PaidServices')</a>
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
              <td>@lang('site.Title')</td>
              <td>{{ $paidService->title }}</td>
            </tr>
            <tr>
              <td>@lang('site.School')</td>
              <td>{{ $paidService->school->title }}</td>
            </tr>
            <tr>
              <td>@lang('site.Price')</td>
              <td>{{ $paidService->price }} @lang('site.app.Currency')</td>
            </tr>
            <tr>
              <td>@lang('site.Order Item')</td>
              <td>{{ $paidService->order_column }}</td>
            </tr>
            <tr>
              <td>@lang('site.Status')</td>
              <td>@include('admin.partials._render_status',['status'=>$paidService->status])</td>
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
