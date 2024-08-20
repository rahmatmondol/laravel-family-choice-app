@extends($masterLayout)
<?php
$page = 'payments';
$title = __('site.Payments');
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
                <form action="{{ route($mainRoutePrefix . '.payments.index') }}" method="get">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 pt-4">
                        <div class="input-area">
                            <input type="text" name="search" class="form-control" placeholder="@lang('site.Search By Reservation Id')"
                                value="{{ request()->search }}">
                        </div>
                        <div class="input-area">
                            <select name="payment_status" class="form-control custom-select">
                                <option value='' selected>@lang('site.payment_status.Status')</option>
                                @foreach (App\Enums\PaymentStatus::values() as $payment_status)
                                    <option value="{{ $payment_status }}" @selected(request('payment_status') == $payment_status)>@lang('site.payment_status.' . $payment_status)
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-area">
                            <button type="submit" class="btn btn-sm btn-primary"><iconify-icon
                                    icon="heroicons-outline:search"></iconify-icon>
                                @lang('site.Search')</button>
                            <a href="{{ route($mainRoutePrefix . '.payments.export', request()->all()) }}"
                                class="btn btn-sm btn-primary"><iconify-icon icon="heroicons-outline:search"></iconify-icon>
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
                                        @lang('site.Reservation Number')
                                    </th>
                                    <th scope="col" class=" table-th " style="width: 20%">
                                        @lang('site.Customer')
                                    </th>
                                    <th scope="col" class=" table-th " style="width: 20%">
                                        @lang('site.payment_status.Status')
                                    </th>
                                    <th scope="col" class=" table-th " style="width: 20%">
                                        @lang('site.Amount')
                                    </th>
                                    <th scope="col" class=" table-th " style="width: 20%">
                                        @lang('site.Created At')
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">
                                @forelse ($payments as $payment)
                                    <tr>
                                        <td class="table-td text-center">{{ $loop->iteration }}</td>
                                        <td class="table-td text-center"> {{ $payment->reservation_id }}</td>
                                        <td class="table-td text-center">
                                            @php $customer = $payment->reservation->customer @endphp
                                            @if (isset($customer))
                                                <a href="{{ route($mainRoutePrefix . '.customers.show', ['customer' => $customer?->id]) }}"
                                                    class="btn btn-primary btn-sm"
                                                    target="_blank">{{ $customer?->full_name }}</a>
                                            @endif
                                        </td>
                                        <td class="table-td text-center">
                                            @include(
                                                $mainRoutePrefix . '.partials._render_payment_status',
                                                ['status' => $payment->payment_status]
                                            )
                                        </td>
                                        <td class="table-td text-center">
                                            {{ $payment->total_fees }} {{ appCurrency() }}
                                        </td>

                                        <td class="table-td ">{{ $payment->created_at }}</td>

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
