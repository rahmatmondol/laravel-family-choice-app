@extends('admin.layouts.master')
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
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('site.Home')</a></li>
            <li class="breadcrumb-item active">{{ $title }}</li>
          </ol>
        </div>
        <div class="col-sm-12">

          <form action="{{ route('admin.reservations.index') }}" method="get">

            <div class="row">

              <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="@lang('site.search')"
                  value="{{ request()->search }}">
              </div>

              <div class="col-md-4">
                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i>
                  @lang('site.Search')</button>
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
                @lang('site.Payment Status')
              </th>
              <th style="width: 20%" class="text-center">
                @lang('site.School')
              </th>
              <th style="width: 20%" class="text-center">
                @lang('site.Customer')
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

                <a href="{{ route('admin.schools.show', ['school'=>$reservation->school_id]) }}"
                  class="btn btn-primary btn-sm" target="_blank">{{ $reservation->school?->title }}</a>
              </td>
              <td class="text-center">

                <a href="{{ route('admin.customers.show', ['customer'=>$reservation->customer_id]) }}"
                  class="btn btn-primary btn-sm" target="_blank">{{ $reservation->customer?->full_name }}</a>
              </td>

              <td class="text-center">

                @include('admin.partials._view_btn',[
                'txt'=>__('site.View'),
                'route'=>route('admin.reservations.show', ['reservation'=>$reservation->id]),
                ])

                @include('admin.partials._edit_btn',[
                'txt'=>__('site.Edit'),
                'route'=>route('admin.reservations.edit', ['reservation'=>$reservation->id]),
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
