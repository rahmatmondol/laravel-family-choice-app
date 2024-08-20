@extends($masterLayout)
<?php
$page = 'reservations';
$title = __('site.Reservations');
?>
@section('title_page')
    {{ $title }}
@endsection
@section('content')
    <!-- BEGIN: Breadcrumb -->
    <div class="mb-5">
        <ul class="m-0 p-0 list-none">
            <li class="inline-block relative top-[3px] text-base text-primary-500 font-Inter ">
                <a href="{{ route('school.dashboard') }}">
                    <iconify-icon icon="heroicons-outline:home"></iconify-icon>
                    <iconify-icon icon="heroicons-outline:chevron-right"
                        class="relative text-slate-500 text-sm rtl:rotate-180"></iconify-icon>
                </a>
            </li>

            <li class="inline-block relative text-sm text-slate-500 font-Inter dark:text-white">
                {{ $title }}</li>
        </ul>
    </div>
    <!-- END: BreadCrumb -->
    <div class=" space-y-5">
        <div class="card">
            <div class="card-body px-6 pb-6">
                <form action="{{ route($mainRoutePrefix . '.reservations.index') }}" method="get">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 pt-4">
                        <div class="input-area">
                            <input type="text" name="search" class="form-control" placeholder="@lang('site.search by reservation number or parent name')"
                                value="{{ request()->search }}">
                        </div>
                        <div class="input-area">
                            <select id="inputStatus" name="status" class="form-control">
                                <option value='' selected>@lang('site.reservation_status.Status')</option>
                                @foreach (App\Enums\ReservationStatus::values() as $status)
                                    <option value="{{ $status }}" @selected(request('status') == $status)>
                                        @lang('site.reservation_status.' . $status)</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-area">
                            <select name="payment_status" class="form-control">
                                <option value='' selected>@lang('site.payment_status.Status')</option>
                                @foreach (App\Enums\PaymentStatus::values() as $payment_status)
                                    <option value="{{ $payment_status }}" @selected(request('payment_status') == $payment_status)>
                                        @lang('site.payment_status.' . $payment_status)</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 pt-4">
                        <div class="input-area">
                            <div class="relative group">
                                <input type="date" class="form-control !pl-12" name="from_date"
                                    value="{{ request('from_date') }}">
                                <span style="font-size: 10px;"
                                    class="absolute left-0 top-1/2 -translate-y-1/2 w-9 h-full border-r border-r-slate-200 dark:border-r-slate-700 flex items-center justify-center">
                                    @lang('site.From')
                                </span>
                            </div>
                        </div>
                        <div class="input-area">
                            <div class="relative group">
                                <input type="date" class="form-control !pl-12" name="to_date"
                                    value="{{ request('to_date') }}">
                                <span style="font-size: 10px;"
                                    class="absolute left-0 top-1/2 -translate-y-1/2 w-9 h-full border-r border-r-slate-200 dark:border-r-slate-700 flex items-center justify-center">
                                    @lang('site.To')
                                </span>
                            </div>
                        </div>
                        <div class="input-area">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i>
                                @lang('site.Search')</button>
                            <a href="{{ route($mainRoutePrefix . '.reservations.export', request()->all()) }}"
                                class="btn btn-sm btn-primary"><i class="fa fa-search"></i>
                                @lang('site.Export')</a>
                        </div>
                    </div>
                </form><!-- end of form -->
            </div>
        </div>
    </div>
    {{-- table --}}
    <div class="card mt-4">
        <div class="card-body px-6 pb-6">
            <div class="overflow-x-auto -mx-6 dashcode-data-table">

                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden ">
                        <table class="min-w-full divide-y divide-slate-100 table-fixed dark:divide-slate-700 data-table">
                            <thead class=" bg-slate-200 dark:bg-slate-700">
                                <tr>
                                    <th scope="col" class=" table-th " style="width: 1%">
                                        #
                                    </th>
                                    <th scope="col" class=" table-th " style="width: 20%">
                                        @lang('site.Status')
                                    </th>
                                    <th scope="col" class=" table-th " style="width: 20%">
                                        @lang('site.payment_status.Status')
                                    </th>
                                    <th scope="col" class=" table-th " style="width: 20%">
                                        @lang('site.Customer')
                                    </th>
                                    <th scope="col" class=" table-th " style="width: 20%">
                                        @lang('site.Total Fees')
                                    </th>
                                    <th scope="col" class=" table-th " style="width: 20%">
                                        @lang('site.Created At')
                                    </th>
                                    <th scope="col" class=" table-th " style="width: 20%">
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">
                                @forelse ($reservations as $reservation)
                                    <tr>
                                        <td class="table-td text-center">{{ $loop->iteration }}</td>
                                        <td class="table-td text-center">{{ $reservation->parent_name }}</td>
                                        <td class="table-td text-center">
                                            @include('admin.partials._render_reservation_status', [
                                                'status' => $reservation->status,
                                            ])
                                        </td>
                                        <td class="table-td text-center">
                                            @include('admin.partials._render_payment_status', [
                                                'status' => $reservation->payment_status,
                                            ])
                                        </td>
                                        <td class="table-td text-center">
                                            @if ($reservation->customer_id)
                                                <a href="{{ route($mainRoutePrefix . '.customers.show', ['customer' => $reservation->customer_id]) }}"
                                                    class="btn btn-primary btn-sm"
                                                    target="_blank">{{ $reservation->customer?->full_name }}</a>
                                            @endif
                                        </td>

                                        <td class="table-td ">{{ $reservation->total_fees }} @lang('site.app.Currency')</td>
                                        <td class="table-td ">{{ $reservation->created_at }}</td>
                                        <td class="table-td ">
                                            <div class="flex space-x-3 rtl:space-x-reverse">
                                                <a href="{{ route($mainRoutePrefix . '.reservations.show', ['reservation' => $reservation->id]) }}"
                                                    class="action-btn">
                                                    <iconify-icon icon="heroicons:eye"></iconify-icon>
                                                </a>
                                                <a href="{{ route($mainRoutePrefix . '.reservations.edit', ['reservation' => $reservation->id]) }}"
                                                    class="action-btn">
                                                    <iconify-icon icon="heroicons:pencil-square"></iconify-icon>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>

                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            @include('school.partials.no_data_found')
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
