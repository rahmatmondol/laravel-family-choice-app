@extends($masterLayout)
<?php
$page = 'reservations';
$title = __('site.Show Reservation');
?>
@section('title_page')
    {{ $title }}
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <!-- BEGIN: Breadcrumb -->
    <div class="mb-5">
        <ul class="m-0 p-0 list-none">
            <li class="inline-block relative top-[3px] text-base text-primary-500 font-Inter ">
                <a href="index.html">
                    <iconify-icon icon="heroicons-outline:home"></iconify-icon>
                    <iconify-icon icon="heroicons-outline:chevron-right"
                        class="relative text-slate-500 text-sm rtl:rotate-180"></iconify-icon>
                </a>
            </li>
            <li class="inline-block relative text-sm text-slate-500 font-Inter dark:text-white">
                <a href="{{ route($mainRoutePrefix . '.reservations.index') }}">
                    @lang('site.Reservations')
                    <iconify-icon icon="heroicons-outline:chevron-right"
                        class="relative text-slate-500 text-sm rtl:rotate-180"></iconify-icon>
                </a>
            </li>
            <li class="inline-block relative text-sm text-slate-500 font-Inter dark:text-white">
                {{ $title }}</li>
        </ul>
    </div>
    <!-- END: BreadCrumb -->


    <div class="grid xl:grid-cols-1 grid-cols-1 gap-5">

        {{-- partial_payment_info --}}
        @if ($reservation->partial_payment_info)
            <div class="card">
                <header class=" card-header noborder">
                    <h4 class="card-title">
                        @lang('site.Partial Payment')
                    </h4>
                </header>
                <div class="card-body px-6 pb-6">
                    <div class="overflow-x-auto ">
                        <div class="inline-block min-w-full align-middle">
                            <div class="overflow-hidden ">
                                <table class="min-w-full divide-y divide-slate-100 table-fixed dark:divide-slate-700">
                                    <tbody
                                        class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">

                                        <tr>
                                            <td style="width: 40%;"
                                                class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                @lang('site.Status')</td>
                                            <td
                                                class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                @lang('site.' . $reservation->partial_payment_info['status']) </td>
                                        </tr>

                                        <tr>
                                            <td
                                                class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                @lang('site.Type')</td>
                                            <td
                                                class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                @lang('site.' . $reservation->partial_payment_info['type'])</td>
                                        </tr>
                                        @if ($reservation->partial_payment_info['type'] == 'card_and_wallet')
                                            <tr>
                                                <td
                                                    class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                    @lang('site.Wallet amount')[@lang('site.' . $reservation->partial_payment_info['wallet']['status'])]</td>
                                                <td
                                                    class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                    {{ $reservation->partial_payment_info['wallet']['amount'] }}
                                                    {{ appCurrency() }}</td>
                                            </tr>
                                            <tr>
                                                <td
                                                    class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                    @lang('site.Card amount')[@lang('site.' . $reservation->partial_payment_info['wallet']['status'])]</td>
                                                <td
                                                    class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                    {{ $reservation->partial_payment_info['card']['amount'] }}
                                                    {{ appCurrency() }}</td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td
                                                    class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                    @lang('site.Amount')</td>
                                                <td
                                                    class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                    {{ $reservation->partial_payment_info['amount'] }}</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- refund_partial_payment_info --}}
        @if ($reservation->refund_partial_payment_info)
            <div class="card">
                <header class=" card-header noborder">
                    <h4 class="card-title">
                        @lang('site.Refund Partial Payment')
                    </h4>
                </header>
                <div class="card-body px-6 pb-6">
                    <div class="overflow-x-auto ">
                        <div class="inline-block min-w-full align-middle">
                            <div class="overflow-hidden ">
                                <table class="min-w-full divide-y divide-slate-100 table-fixed dark:divide-slate-700">
                                    <tbody
                                        class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">

                                        <tr>
                                            <td style="width: 40%;"
                                                class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                @lang('site.Status')
                                            </td>
                                            <td
                                                class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                @lang('site.' . $reservation->refund_partial_payment_info['status']) </td>
                                        </tr>

                                        <tr>
                                            <td
                                                class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                @lang('site.Type')</td>
                                            <td
                                                class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                @lang('site.' . $reservation->refund_partial_payment_info['type'])</td>
                                        </tr>
                                        @if ($reservation->refund_partial_payment_info['type'] == 'card_and_wallet')
                                            <tr>
                                                <td
                                                    class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                    @lang('site.Wallet amount') [@lang('site.' . $reservation->refund_partial_payment_info['wallet']['status'])]</td>
                                                <td
                                                    class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                    {{ $reservation->refund_partial_payment_info['wallet']['amount'] }}
                                                    {{ appCurrency() }}</td>
                                            </tr>
                                            <tr>
                                                <td
                                                    class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                    @lang('site.Card amount')[@lang('site.' . $reservation->refund_partial_payment_info['card']['status'])]</td>
                                                <td
                                                    class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                    {{ $reservation->refund_partial_payment_info['card']['amount'] }}
                                                    {{ appCurrency() }}</td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td
                                                    class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                    @lang('site.Amount')</td>
                                                <td
                                                    class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                    {{ $reservation->refund_partial_payment_info['amount'] }}</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- remaining_payment_info --}}
        @if ($reservation->remaining_payment_info)
            <div class="card">
                <header class=" card-header noborder">
                    <h4 class="card-title">
                        @lang('site.Remaining Payment')
                    </h4>
                </header>
                <div class="card-body px-6 pb-6">
                    <div class="overflow-x-auto ">
                        <div class="inline-block min-w-full align-middle">
                            <div class="overflow-hidden ">
                                <table class="min-w-full divide-y divide-slate-100 table-fixed dark:divide-slate-700">
                                    <tbody
                                        class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">

                                        <tr>
                                            <td style="width: 40%;"
                                                class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                @lang('site.Status')
                                            </td>
                                            <td
                                                class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                @lang('site.' . $reservation->remaining_payment_info['status']) </td>
                                        </tr>

                                        <tr>
                                            <td
                                                class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                @lang('site.Type')</td>
                                            <td
                                                class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                @lang('site.' . $reservation->remaining_payment_info['type'])</td>
                                        </tr>
                                        @if ($reservation->remaining_payment_info['type'] == 'card_and_wallet')
                                            <tr>
                                                <td
                                                    class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                    @lang('site.Wallet amount') [@lang('site.' . $reservation->remaining_payment_info['wallet']['status'])]
                                                </td>
                                                <td
                                                    class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                    {{ $reservation->remaining_payment_info['wallet']['amount'] }}
                                                    {{ appCurrency() }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td
                                                    class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                    @lang('site.Card amount')[@lang('site.' . $reservation->remaining_payment_info['card']['status'])]
                                                </td>
                                                <td
                                                    class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                    {{ $reservation->remaining_payment_info['card']['amount'] }}
                                                    {{ appCurrency() }}</td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td
                                                    class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                    @lang('site.Amount')</td>
                                                <td
                                                    class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                    {{ $reservation->remaining_payment_info['amount'] }}</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Reservation --}}
        <div class="card">
            <header class=" card-header noborder">
                <h4 class="card-title">
                    @lang('site.Reservation Details')
                </h4>
            </header>
            <div class="card-body px-6 pb-6">
                <div class="overflow-x-auto ">
                    <div class="inline-block min-w-full align-middle">
                        <div class="overflow-hidden ">
                            <table class="min-w-full divide-y divide-slate-100 table-fixed dark:divide-slate-700">
                                <tbody class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">

                                    <tr>
                                        <td style="width: 40%;"
                                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                            @lang('site.Parent Name')
                                        </td>
                                        <td
                                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                            {{ $reservation->parent_name }} </td>
                                    </tr>

                                    <tr>
                                        <td
                                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                            @lang('site.Parent Phone')</td>
                                        <td
                                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                            {{ $reservation->parent_phone }}</td>
                                    </tr>

                                    <tr>
                                        <td
                                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                            @lang('site.Parent Date Of Birth')</td>
                                        <td
                                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                            {{ $reservation->parent_date_of_birth }}</td>
                                    </tr>

                                    <tr>
                                        <td
                                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                            @lang('site.Total Fees')</td>
                                        <td
                                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                            {{ $reservation->total_fees }} {{ appCurrency() }}</td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                            @lang('site.Address')</td>
                                        <td
                                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                            {{ $reservation->address }}</td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                            @lang('site.Identification Number')</td>
                                        <td
                                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                            {{ $reservation->identification_number }}</td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                            @lang('site.School')</td>
                                        <td
                                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                            {{ $reservation->school?->title }}</td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                            @lang('site.Customer')</td>
                                        <td
                                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                            @if ($reservation->customer_id)
                                                <a href="{{ route($mainRoutePrefix . '.customers.show', ['customer' => $reservation->customer_id]) }}"
                                                    class="btn btn-primary btn-sm"
                                                    target="_blank">{{ $reservation->customer?->full_name }}</a>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                            @lang('site.Status')</td>
                                        <td
                                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                            @include('admin.partials._render_reservation_status', [
                                                'status' => $reservation->status,
                                            ])
                                        </td>
                                    </tr>

                                    @if ($reservation->status == App\Enums\ReservationStatus::Rejected->value)
                                        <tr>
                                            <td
                                                class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                @lang('site.Reason of refuse')</td>
                                            <td
                                                class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                {{ $reservation->reason_of_refuse }}</td>
                                        </tr>
                                    @endif

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Student Details --}}
        @if ($child = $reservation->child)
            <div class="card">
                <header class=" card-header noborder">
                    <h4 class="card-title">
                        @lang('site.Student Details')
                    </h4>
                </header>
                <div class="card-body px-6 pb-6">
                    <div class="overflow-x-auto ">
                        <div class="inline-block min-w-full align-middle">
                            <div class="overflow-hidden ">
                                <table class="min-w-full divide-y divide-slate-100 table-fixed dark:divide-slate-700">
                                    <tbody
                                        class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">

                                        <tr>
                                            <td style="width: 40%;"
                                                class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                @lang('site.Child Name')
                                            </td>
                                            <td
                                                class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                {{ $child->child_name }} </td>
                                        </tr>

                                        <tr>
                                            <td
                                                class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                @lang('site.Date of birth')</td>
                                            <td
                                                class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                {{ $child->date_of_birth }}</td>
                                        </tr>
                                        <tr>
                                            <td
                                                class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                @lang('site.Gender')</td>
                                            <td
                                                class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                @lang('site.' . ucfirst($child->gender))</td>
                                        </tr>

                                        @if ($reservation->school?->is_school_type)
                                            <tr>
                                                <td
                                                    class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                    @lang('site.Grade')
                                                </td>
                                                <td
                                                    class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                    {{ $child->grade?->title }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td
                                                    class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                    @lang('site.Fees')
                                                </td>
                                                <td></td>
                                            </tr>
                                            @foreach ($reservation->gradeFees as $gradeFees)
                                                <tr>
                                                    <td
                                                        class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                        {{ $gradeFees->title }}
                                                    </td>
                                                    <td>{{ $gradeFees->pivot->price }} {{ appCurrency() }}</td>
                                                </tr>
                                            @endforeach
                                        @endif

                                        @if ($reservation->school?->is_nursery_type)
                                            <tr>
                                                <td
                                                    class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                    @lang('site.Subscription Type')
                                                </td>
                                                <td
                                                    class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                    {{ $child->subscription_type?->title }} -
                                                    ({{ $child->subscription_type_price }})
                                                </td>
                                            </tr>
                                            <tr>
                                                <td
                                                    class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                    @lang('site.Course')
                                                </td>
                                                <td>{{ $child->course?->title }} </td>
                                            </tr>
                                            <tr>
                                                <td
                                                    class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                    @lang('site.Fees')
                                                </td>
                                                <td></td>
                                            </tr>
                                            @foreach ($reservation->nurseryFees as $nurseryFees)
                                                <tr>
                                                    <td
                                                        class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                        {{ $nurseryFees->title }}
                                                    </td>
                                                    <td>{{ $nurseryFees->pivot->price }} {{ appCurrency() }}</td>
                                                </tr>
                                            @endforeach
                                        @endif

                                        @if (isset($reservation->paidServices))
                                            <tr>
                                                <td
                                                    class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                    @lang('site.Paid Services')
                                                </td>
                                                <td></td>
                                            </tr>

                                            @foreach ($reservation->paidServices as $paidService)
                                                <tr>
                                                    <td
                                                        class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                        {{ $paidService->title }}
                                                    </td>
                                                    <td>{{ $paidService->pivot->price }} {{ appCurrency() }}</td>
                                                </tr>
                                            @endforeach
                                        @endif

                                        <tr>
                                            <td
                                                class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                @lang('site.Transportation')</td>
                                            <td
                                                class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                {{ $child->transportation?->title }} -
                                                ({{ $child->transportation_price }})
                                                {{ appCurrency() }}</td>
                                        </tr>
                                        <tr>
                                            <td
                                                class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                @lang('site.Status')</td>
                                            <td
                                                class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                @lang('site.reservation_status.' . $reservation->status)</td>
                                        </tr>

                                        @if (isset($child->attachments))
                                            <tr>
                                                <td
                                                    class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                    @lang('site.Attachments')
                                                </td>
                                                <td></td>
                                            </tr>

                                            @foreach ($child->attachments as $attachment)
                                                <tr>
                                                    <td
                                                        class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                                        {{ $attachment->attachment?->title }}
                                                    </td>
                                                    <td><a href="{{ $attachment->attachment_file_path }}"
                                                            class="btn btn-primary btn-sm"
                                                            target="_blank">@lang('site.Download')</a></td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
    <!-- /.content-wrapper -->
@endsection
