@extends($masterLayout)
<?php
$page = 'discount view';
$title = 'discount';
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
            <li class="breadcrumb-item"><a href="{{ route($mainRoutePrefix.'.discount.view') }}">discount list</a>
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
              <td>{{ $discount->title }}</td>
            </tr>
            <tr>
              <td>@lang('site.Type')</td>
              <td>{{ ucfirst($discount->discount_type) }}</td>
            </tr>
            <tr>
              <td>Discount Amount</td>
              <td>{{ $discount->discount_amount ?? 0 }}</td>
            </tr>
            <tr>
              <td>Discount Percentage</td>
              <td>{{ $discount->percentage_discount ?? 0}}</td>
            </tr>
            <tr>
              <td>Minimum Amount for discount </td>
              <td>{{ $discount->minimum_amount }}</td>
            </tr>

            <tr>
              <td>@lang('site.From Date')</td>
              <td>{{ $discount->starting_date->format('F j, Y') }}</td>
            </tr>
            <tr>
              <td>@lang('site.To Date')</td>
              <td>{{ $discount->ending_date->format('F j, Y') }}</td>
            </tr>

{{--            <tr>--}}
{{--              <td>@lang('site.Order Item')</td>--}}
{{--              <td>{{ $discount->order_column }}</td>--}}
{{--            </tr>--}}
            <tr>
              <td>@lang('site.Status')</td>
              <td>@include('school.partials._render_status',['status'=>$discount->status])</td>
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
