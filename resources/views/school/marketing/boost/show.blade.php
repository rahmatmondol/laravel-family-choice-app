@extends($masterLayout)
<?php
$page = 'boost view';
$title = 'boost';
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
            <li class="breadcrumb-item"><a href="{{ route($mainRoutePrefix.'.boost.list') }}">boost list</a>
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
              <td>City</td>
              <td>{{ $boost->citys->title }}</td>
            </tr>
            <tr>
              <td>Monthly Budget</td>
              <td>{{ $boost->monthly_budget ?? 0 }}</td>
            </tr>
            <tr>
              <td>Cost per click</td>
              <td>{{ $boost->cost_per_click ?? 0 }}</td>
            </tr>
            <tr>
              <td>Starting Date</td>
              <td>{{ Carbon\Carbon::parse($boost->starting_date)->format('F j, Y') }}</td>
            </tr>
            <tr>
              <td>Ending Date</td>
              <td>{{ Carbon\Carbon::parse($boost->ending_date)->format('F j, Y') }}</td>
            </tr>
{{--            <tr>--}}
{{--              <td>@lang('site.Order Item')</td>--}}
{{--              <td>{{ $boost->order_column }}</td>--}}
{{--            </tr>--}}
{{--            <tr>--}}
{{--              <td>@lang('site.Status') {{$boost['status']}}</td>--}}
{{--              <td>@include('school.partials._render_status',['status'=>$boost['status']])</td>--}}
{{--            </tr>--}}

          </tbody>
        </table>
      </div>
    </div>
  </div>
  <!-- //Content -->
</div>
<!-- /.content-wrapper -->
@endsection
