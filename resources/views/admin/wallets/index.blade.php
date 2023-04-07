@extends($masterLayout)
<?php
$page = 'wallets';
$title = __('site.Wallets');
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
                                ( {{ $wallets->total() }} )
                            </small>
                        </h6>

                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a
                                    href="{{ route($mainRoutePrefix . '.dashboard') }}">@lang('site.Home')</a></li>
                            <li class="breadcrumb-item active">{{ $title }}</li>
                        </ol>
                    </div>
                    <div class="col-sm-12">

                        <form action="{{ route($mainRoutePrefix . '.wallets.index') }}" method="get">

                            <div class="row">

                                <div class="col-md-4">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="@lang('site.search')" value="{{ request()->search }}">
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
                                <th style="width: 20%">
                                    @lang('site.Customer')
                                </th>
                                <th style="width: 20%">
                                    @lang('site.Reservation')
                                </th>
                                <th style="width: 20%">
                                    @lang('site.Type')
                                </th>
                                <th style="width: 8%">
                                    @lang('site.Description')
                                </th>
                                <th style="width: 8%">
                                    @lang('site.Amount')
                                </th>
                                <th style="width: 8%">
                                    @lang('site.Current Wallet')
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($wallets as $wallet)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        @if ($wallet->customer_id)
                                            <a href="{{ route($mainRoutePrefix . '.customers.show', ['customer' => $wallet->customer_id]) }}"
                                                class="btn btn-primary btn-sm"
                                                target="_blank">{{ $wallet->customer?->full_name }}</a>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $wallet->reservation_id }}
                                    </td>
                                    <td>
                                        {{ $wallet->type }}
                                    </td>
                                    <td>
                                        {{ $wallet->description }}
                                    </td>
                                    <td>
                                        {{ $wallet->amount }} {{ appCurrency() }}
                                    </td>
                                    <td>
                                        {{ $wallet->current_wallet }} {{ appCurrency() }}
                                    </td>
                                    <td class="project-actions text-right">
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td>
                                        @include('admin.partials.no_data_found')
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                    {{ $wallets->appends(request()->query())->links() }}

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
