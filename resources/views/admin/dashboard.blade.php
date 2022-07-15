@extends('admin.layouts.master')
<?php
$page = 'dashboard';
$title = __('site.Dashboard');
?>
@section('title_page')
{{ $title }}
@endsection
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">@lang('site.Dashboard')</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">@lang('site.Home')</a></li>
            <li class="breadcrumb-item active">@lang('site.Dashboard')</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3>{{ $countAllReservation }}</h3>

              <p>@lang('site.Count All Reservations')</p>
            </div>
            <div class="icon">
              {{-- <i class="ion ion-bag"></i> --}}
            </div>
            <a href="{{ route('admin.reservations.index') }}" class="small-box-footer">@lang('site.More info') <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3>{{ $countPendingReservations }}</h3>

              <p>@lang('site.Count Pending Reservations')</p>
            </div>
            <div class="icon">
              {{-- <i class="ion ion-stats-bars"></i> --}}
            </div>
            <a href="{{ route('admin.reservations.index',['status'=>'pending']) }}" class="small-box-footer">@lang('site.More info') <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>{{ $countOfCities }}</h3>

              <p>@lang('Count Of Cities')</p>
            </div>
            <div class="icon">
              {{-- <i class="ion ion-person-add"></i> --}}
            </div>
            <a href="{{ route('admin.cities.index') }}" class="small-box-footer">@lang('site.More info') <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>{{ $countOfSchools }}</h3>

              <p>@lang('site.Count Of Schools')</p>
            </div>
            <div class="icon">
              {{-- <i class="ion ion-pie-graph"></i> --}}
            </div>
            <a href="{{ route('admin.schools.index') }}" class="small-box-footer">@lang('site.More info') <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3>{{ $countOfCourses }}</h3>

              <p>@lang('site.Count All courses')</p>
            </div>
            <div class="icon">
              {{-- <i class="ion ion-bag"></i> --}}
            </div>
            <a href="{{ route('admin.courses.index') }}" class="small-box-footer">@lang('site.More info') <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3>{{ $countOfGrades }}</h3>

              <p>@lang('site.Count Grades')</p>
            </div>
            <div class="icon">
              {{-- <i class="ion ion-stats-bars"></i> --}}
            </div>
            <a href="{{ route('admin.grades.index') }}" class="small-box-footer">@lang('site.More info') <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>{{ $countOfServices }}</h3>

              <p>@lang('Count Of Services')</p>
            </div>
            <div class="icon">
              {{-- <i class="ion ion-person-add"></i> --}}
            </div>
            <a href="{{ route('admin.services.index') }}" class="small-box-footer">@lang('site.More info') <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>{{ $countCustomers }}</h3>

              <p>@lang('site.Count Of Customers')</p>
            </div>
            <div class="icon">
              {{-- <i class="ion ion-pie-graph"></i> --}}
            </div>
            <a href="{{ route('admin.customers.index') }}" class="small-box-footer">@lang('site.More info') <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <div class="col-md-8">
          <div class="box box-solid">
            <div class="box-header">
              <h3 class="box-title">@lang('site.Sales Graph')</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body border-radius-none">
              <div class="chart" id="line-chart" style="height: 250px;"></div>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
        <div class="col-md-4">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">@lang('site.Latest Members')</h3>

              <div class="box-tools pull-right">
                <span class="label label-danger">@lang('site.8 New Members')</span>
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <ul class="users-list clearfix">
                @foreach ( $newCustomers as $customer )
                <li>
                  <img src="{{ $customer->image_path }}" alt="User Image">
                  <a class="users-list-name" href="#">{{ $customer->full_name }}</a>
                  <span class="users-list-date">{{ $customer->created_at }}</span>
                </li>
                @endforeach
              </ul>
              <!-- /.users-list -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer text-center">
              <a href="{{ route('admin.customers.index') }}" class="uppercase">@lang('site.List Customers')</a>
            </div>
            <!-- /.box-footer -->
          </div>
        </div>
      </div>


    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@push('footer_js')
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
{{-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script> --}}
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>


<script>
  //line chart
  var line = new Morris.Line({
      element: 'line-chart',
      resize: true,
      data: [
          @foreach ($reservationData as $data)
          {
              ym: "{{ $data->year }}-{{ $data->month }}", sum: "{{ $data->sum }}"
          },
          @endforeach
      ],
      xkey: 'ym',
      ykeys: ['sum'],
      labels: ['@lang('site.Total')'],
      lineWidth: 2,
      hideHover: 'auto',
      gridStrokeWidth: 0.4,
      pointSize: 4,
      gridTextFamily: 'Open Sans',
      gridTextSize: 10
  });
</script>

@endpush


