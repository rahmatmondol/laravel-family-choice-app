@extends($masterLayout)
<?php
$page = 'schools';
$title = __('site.Show Subscription');
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
            <li class="breadcrumb-item"><a
              href="{{ route($mainRoutePrefix.'.schools.subscriptions.index',['school' => $schoolSubscription->school_id]) }}">@lang('site.Subscriptions')</a>
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
              <td>@lang('site.School')</td>
              <td>{{ $schoolSubscription->school->title }}</td>
            </tr>
            <tr>
              <td>@lang('site.Subscription')</td>
              <td>{{ $schoolSubscription->subscription->title }}</td>
            </tr>
            <tr>
              <td>@lang('site.Order Item')</td>
              <td>{{ $schoolSubscription->order_column }}</td>
            </tr>
            <tr>
              <td>@lang('site.Status')</td>
              <td>@include('admin.partials._render_status',['status'=>$schoolSubscription->status])</td>
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
