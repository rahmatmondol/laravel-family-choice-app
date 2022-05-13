@extends('admin.layouts.master')
<?php
$page = 'reservations';
$title = __('site.Show Reservation');
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

  <!-- Content -->
  <div class="card mt-4 content-table">
    <div class="card-body">
      <h4>@lang('site.Reservation Details')</h4>
      <div class="table-res ponsive">
        <table class="table table-striped table-bordered">
          <tbody>
            <tr>
              <td>@lang('site.Parent Name')</td>
              <td>{{ $reservation->parent_name }}</td>
            </tr>
            <tr>
              <td>@lang('site.Total Fees')</td>
              <td>{{ $reservation->total_fees }} </td>
            </tr>
            <tr>
              <td>@lang('site.Address')</td>
              <td>{{ $reservation->address }}</td>
            </tr>
            <tr>
              <td>@lang('site.Identification Number')</td>
              <td>{{ $reservation->identification_number }}</td>
            </tr>
            <tr>
              <td>@lang('site.School')</td>
              <td>
                <a href="{{ route('admin.schools.show', ['school'=>$reservation->school_id]) }}"
                  class="btn btn-primary btn-sm" target="_blank">{{ $reservation->school?->title }}</a>
              </td>
            </tr>
            <tr>
              <td>@lang('site.Customer')</td>
              <td>
                <a href="{{ route('admin.customers.show', ['customer'=>$reservation->customer_id]) }}"
                  class="btn btn-primary btn-sm" target="_blank">{{ $reservation->customer?->full_name }}</a>
              </td>
            </tr>
            <tr>
              <td>@lang('site.Status')</td>
              <td>@lang("site.reservation_status.{$reservation->status}")</td>
              {{-- <td>@include('admin.partials._render_status',['status'=>$reservation->status])</td> --}}
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    @foreach($reservation->children as $key => $child)
    <div class="card-body">
      <h4>@lang('site.Student Details')</h4>
      <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <tbody>
            <tr>
              <td>@lang('site.Child Name')</td>
              <td>{{ $child->child_name }}</td>
            </tr>
            <tr>
              <td>@lang('site.Date of birth')</td>
              <td>{{ $child->date_of_birth }} </td>
            </tr>
            <tr>
              <td>@lang('site.Gender')</td>
              <td>@lang('site.'.$child->gender)</td>
            </tr>
            <tr>
              <td>@lang('site.Grade')</td>
              <td>{{ $child->grade?->title }}</td>
            </tr>
            <tr>
              <td>@lang('site.Fees')</td>
              <td>{{ $child->fees }}</td>
            </tr>
            <tr>
              <td>@lang('site.Administrative Expenses')</td>
              <td> {{ $child->administrative_expenses}}</td>
            </tr>
            <tr>
              <td>@lang('site.Status')</td>
              <td>@lang("site.reservation_status.".$reservation->status)</td>
              {{-- <td>@include('admin.partials._render_status',['status'=>$reservation->status])</td> --}}
            </tr>
            @foreach ($child->attachments as $attachment)
            <tr>
              <td>{{ $attachment->attachment?->title }}</td>
              <td><a href="{{ $attachment->attachment_file_path }}" class="btn btn-primary btn-sm"
                  target="_blank">@lang('site.Download')</a></td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    @endforeach

  </div>
  <!-- //Content -->
</div>
<!-- /.content-wrapper -->
@endsection
