@extends($masterLayout)
<?php
$page = 'payments';
$title = __('site.Payments');
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
              ( {{ $payments->total() }} )
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

          <form action="{{ route($mainRoutePrefix.'.payments.index') }}" method="get">

            <div class="row">

              <div class="col-md-4">
                <div class="form-group">
                  <input type="text" name="search" class="form-control" placeholder="@lang('site.Search By Reservation Id')"
                  value="{{ request()->search }}">
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
                  <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i>
                    @lang('site.Search')</button>
                    <a href="{{ route($mainRoutePrefix.'.payments.export',request()->all() ) }}" class="btn btn-sm btn-primary"><i class="fa fa-search"></i>
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
                @lang('site.Reservation Number')
              </th>
              <th style="width: 20%" class="text-center">
                @lang('site.Customer')
              </th>
              <th style="width: 20%" class="text-center">
                @lang('site.payment_status.Status')
              </th>
              <th style="width: 20%" class="text-center">
                @lang('site.Amount')
              </th>
              <th style="width: 20%" class="text-center">
                @lang('site.Created At')
              </th>
            </tr>
          </thead>
          <tbody>
            @forelse ($payments as $payment )
            <tr>
              <td class="text-center">
                {{ $loop->iteration }}
              </td>
              <td class="text-center">
                {{ $payment->reservation_id }}
              </td>
              <td class="text-center">
                @php $customer = $payment->reservation->customer @endphp
                @if(isset($customer))
                  <a href="{{ route($mainRoutePrefix.'.customers.show', ['customer'=>$customer?->id]) }}"
                    class="btn btn-primary btn-sm" target="_blank">{{ $customer?->full_name }}</a>
                @endif
              </td>
              <td class="text-center">
                @include($mainRoutePrefix.'.partials._render_payment_status',['status'=>$payment->payment_status])
              </td>
              <td class="text-center">
                {{ $payment->total_fees }} @lang('site.app.Currency')
              </td>

              <td class="text-center">
                {{ $payment->created_at }}
              </td>
            </tr>
            @empty
            <tr>
              <td class="text-center">
                @include($mainRoutePrefix.'.partials.no_data_found')
              </td>
            </tr>
            @endforelse

          </tbody>
        </table>
        {{ $payments->appends(request()->query())->links() }}

      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
