@extends($masterLayout)
<?php
$page = 'reservations';
$title = __('site.Reservations');
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
          <h6>{{ $title }}
            <small>
              ( {{ $reservations->total() }} )
            </small>
          </h6>

        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-center">
            <li class="breadcrumb-item"><a href="{{ route($mainRoutePrefix.'.dashboard') }}">@lang('site.Home')</a></li>
            <li class="breadcrumb-item active">{{ $title }}</li>
          </ol>
        </div>
        <div class="col-sm-12">

          <form action="{{ route($mainRoutePrefix.'.reservations.index') }}" method="get">

            <div class="row">

              <div class="col-md-4">
                <div class="form-group">
                  <input type="text" name="search" class="form-control" placeholder="@lang('site.search')"
                  value="{{ request()->search }}">
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <select name="school_id" class="form-control"  data-live-search="true">
                    <option value="">@lang('site.Schools') </option>
                    @foreach( $schools as $value )
                    <option value="{{ $value->id}}" @selected(request('school_id')==$value->id) >
                      {{ $value->title }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              {{-- <div class="col-md-4">
                <div class="form-group">
                  <select name="course_id" class="form-control"  data-live-search="true">
                    <option value="">@lang('site.Courses') </option>
                    @foreach( $courses as $value )
                    <option value="{{ $value->id}}" @selected(request('course_id')==$value->id) >
                      {{ $value->title }}</option>
                    @endforeach
                  </select>
                </div>
              </div> --}}

              <div class="col-md-4">
                <div class="form-group">
                  <select id="inputStatus" name="status" class="form-control custom-select">
                    <option value='' selected >@lang('site.reservation_status.Status')</option>
                    @foreach(App\Enums\ReservationStatus::values() as $status)
                      <option value="{{ $status }}" @selected(request('status')==$status)>@lang('site.reservation_status.'.$status)</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <select  name="payment_status" class="form-control custom-select">
                    <option value='' selected >@lang('site.payment_status.Status')</option>
                    @foreach(App\Enums\PaymentStatus::values() as $payment_status)
                      <option value="{{ $payment_status }}" @selected(request('payment_status')==$payment_status)>@lang('site.payment_status.'.$payment_status)</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                      </span>
                    </div>
                    <input type="text" name="date_range" class="form-control float-right" id="reservation_date_range" value="{{ request('date_range') }}">
                  </div>
                  <!-- /.input group -->
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i>
                    @lang('site.Search')</button>
                    <a href="{{ route($mainRoutePrefix.'.reservations.export',request()->all() ) }}" class="btn btn-sm btn-primary"><i class="fa fa-search"></i>
                      @lang('site.Export')</a>
                </div>
              </div>

            </div>
          </form><!-- end of form -->
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">{{ $title }}</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body p-0">
        <table class="table table-striped projects">
          <thead>
            <tr>
              <th style="width: 1%">
                #
              </th>
              <th style="width: 20%" class="text-center">
                @lang('site.Parent Name')
              </th>
              <th style="width: 20%" class="text-center">
                @lang('site.Status')
              </th>
              <th style="width: 20%" class="text-center">
                @lang('site.payment_status.Status')
              </th>
              <th style="width: 20%" class="text-center">
                @lang('site.School')
              </th>
              <th style="width: 20%" class="text-center">
                @lang('site.Course')
              </th>
              <th style="width: 20%" class="text-center">
                @lang('site.Customer')
              </th>
              <th style="width: 20%" class="text-center">
                @lang('site.Created At')
              </th>
              <th style="width: 20%" class="text-center">
              </th>
            </tr>
          </thead>
          <tbody>
            @forelse ($reservations as $reservation )
            <tr>
              <td class="text-center">
                {{ $loop->iteration }}
              </td>
              <td class="text-center">
                {{ $reservation->parent_name }}
              </td>
              <td class="text-center">
                @include('admin.partials._render_reservation_status',['status'=>$reservation->status])
              </td>
              <td class="text-center">

                @include('admin.partials._render_payment_status',['status'=>$reservation->payment_status])
              </td>
              <td class="text-center">
                <a href="{{ route($mainRoutePrefix.'.schools.show', ['school'=>$reservation->school_id]) }}"
                  class="btn btn-primary btn-sm" target="_blank">{{ $reservation->school?->title }}</a>
              </td>
              <td class="text-center">
                @if($reservation->course_id)
                <a href="{{ route($mainRoutePrefix.'.courses.show', ['course'=>$reservation->course_id]) }}"
                  class="btn btn-primary btn-sm" target="_blank">{{ $reservation->course?->title }}</a>
                @endif
              </td>

              <td class="text-center">
                <a href="{{ route($mainRoutePrefix.'.customers.show', ['customer'=>$reservation->customer_id]) }}"
                  class="btn btn-primary btn-sm" target="_blank">{{ $reservation->customer?->full_name }}</a>
              </td>

              <td class="text-center">
                {{ $reservation->created_at }}
              </td>

              <td class="text-center">

                @include('admin.partials._view_btn',[
                'txt'=>__('site.View'),
                'route'=>route($mainRoutePrefix.'.reservations.show', ['reservation'=>$reservation->id]),
                ])

                @include('admin.partials._edit_btn',[
                'txt'=>__('site.Edit'),
                'route'=>route($mainRoutePrefix.'.reservations.edit', ['reservation'=>$reservation->id]),
                ])

              </td>
            </tr>
            @empty
            <tr>
              <td class="text-center">
                @include('admin.partials.no_data_found')
              </td>
            </tr>
            @endforelse

          </tbody>
        </table>
        {{ $reservations->appends(request()->query())->links() }}

      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
