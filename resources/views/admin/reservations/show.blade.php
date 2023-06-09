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
                            <li class="breadcrumb-item"><a
                                    href="{{ route($mainRoutePrefix . '.dashboard') }}">@lang('site.Home')</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route($mainRoutePrefix . '.reservations.index') }}">@lang('site.Reservations')</a>
                            </li>
                            <li class="breadcrumb-item active">{{ $title }}</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Content -->
        <div class="card mt-4 content-table">
            {{-- partial_payment_info --}}
            @if (isset($reservation->partial_payment_info))
                <div class="card-body">
                    <h4>@lang('site.Partial Payment')</h4>
                    <div class="table-res ponsive">
                        <table class="table table-striped table-bordered">
                            <tbody>
                                <tr>
                                    <td>@lang('site.Status')</td>
                                    <td>@lang('site.' . $reservation->partial_payment_info['status']) </td>
                                </tr>
                                <tr>
                                    <td>@lang('site.Type')</td>
                                    <td>@lang('site.' . $reservation->partial_payment_info['type'])</td>
                                </tr>
                                @if ($reservation->partial_payment_info['type'] == 'card_and_wallet')
                                    <tr>
                                        <td>@lang('site.Wallet amount')[@lang('site.' . $reservation->partial_payment_info['wallet']['status'])]</td>
                                        <td>{{ $reservation->partial_payment_info['wallet']['amount'] }} {{ appCurrency() }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>@lang('site.Card amount')[@lang('site.' . $reservation->partial_payment_info['wallet']['status'])]</td>
                                        <td>{{ $reservation->partial_payment_info['card']['amount'] }} {{ appCurrency() }}
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td>@lang('site.Amount')</td>
                                        <td>{{ $reservation->partial_payment_info['amount'] }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
            {{-- refund_partial_payment_info --}}
            @if (isset($reservation->refund_partial_payment_info))
                <div class="card-body">
                    <h4>@lang('site.Refund Partial Payment')</h4>
                    <div class="table-res ponsive">
                        <table class="table table-striped table-bordered">
                            <tbody>
                                <tr>
                                    <td>@lang('site.Status')</td>
                                    <td>@lang('site.' . $reservation->refund_partial_payment_info['status']) </td>
                                </tr>
                                <tr>
                                    <td>@lang('site.Type')</td>
                                    <td>@lang('site.' . $reservation->refund_partial_payment_info['type'])</td>
                                </tr>
                                @if ($reservation->refund_partial_payment_info['type'] == 'card_and_wallet')
                                    <tr>
                                        <td>@lang('site.Wallet amount') [@lang('site.' . $reservation->refund_partial_payment_info['wallet']['status'])]</td>
                                        <td>{{ $reservation->refund_partial_payment_info['wallet']['amount'] }}
                                            {{ appCurrency() }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>@lang('site.Card amount')[@lang('site.' . $reservation->refund_partial_payment_info['card']['status'])]</td>
                                        <td>{{ $reservation->refund_partial_payment_info['card']['amount'] }}
                                            {{ appCurrency() }}
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td>@lang('site.Amount')</td>
                                        <td>{{ $reservation->refund_partial_payment_info['amount'] }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
            {{-- remaining_payment_info --}}
            @if (isset($reservation->remaining_payment_info))
                <div class="card-body">
                    <h4>@lang('site.Remaining Payment')</h4>
                    <div class="table-res ponsive">
                        <table class="table table-striped table-bordered">
                            <tbody>
                                <tr>
                                    <td>@lang('site.Status')</td>
                                    <td>@lang('site.' . $reservation->remaining_payment_info['status']) </td>
                                </tr>
                                <tr>
                                    <td>@lang('site.Type')</td>
                                    <td>@lang('site.' . $reservation->remaining_payment_info['type'])</td>
                                </tr>
                                @if ($reservation->remaining_payment_info['type'] == 'card_and_wallet')
                                    <tr>
                                        <td>@lang('site.Wallet amount') [@lang('site.' . $reservation->remaining_payment_info['wallet']['status'])]</td>
                                        <td>{{ $reservation->remaining_payment_info['wallet']['amount'] }}
                                            {{ appCurrency() }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>@lang('site.Card amount')[@lang('site.' . $reservation->remaining_payment_info['card']['status'])]</td>
                                        <td>{{ $reservation->remaining_payment_info['card']['amount'] }}
                                            {{ appCurrency() }}
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td>@lang('site.Amount')</td>
                                        <td>{{ $reservation->remaining_payment_info['amount']?? "" }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

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
                                <td>@lang('site.Parent Phone')</td>
                                <td>{{ $reservation->parent_phone }}</td>
                            </tr>
                            <tr>
                                <td>@lang('site.Parent Date Of Birth')</td>
                                <td>{{ $reservation->parent_date_of_birth }}</td>
                            </tr>
                            <tr>
                                <td>@lang('site.Total Fees')</td>
                                <td>{{ $reservation->total_fees }} {{ appCurrency() }} </td>
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
                                @if ($reservation->school_id)
                                    <td>
                                        <a href="{{ route($mainRoutePrefix . '.schools.show', ['school' => $reservation->school_id]) }}"
                                            class="btn btn-primary btn-sm"
                                            target="_blank">{{ $reservation->school?->title }}</a>
                                    </td>
                                @endif
                            </tr>
                            <tr>
                                <td>@lang('site.Customer')</td>
                                <td>

                                    @if ($reservation->customer_id)
                                        <a href="{{ route($mainRoutePrefix . '.customers.show', ['customer' => $reservation->customer_id]) }}"
                                            class="btn btn-primary btn-sm"
                                            target="_blank">{{ $reservation->customer?->full_name }}</a>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>@lang('site.Status')</td>
                                <td>@include('admin.partials._render_reservation_status', [
                                    'status' => $reservation->status,
                                ])</td>
                            </tr>
                            @if ($reservation->status == App\Enums\ReservationStatus::Rejected->value)
                                <tr>
                                    <td>@lang('site.Reason of refuse')</td>
                                    <td>{{ $reservation->reason_of_refuse }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            @if ($child = $reservation->child)
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
                                    <td>@lang('site.' . ucfirst($child->gender))</td>
                                </tr>

                                @if ($reservation->school?->is_school_type)
                                    <tr>
                                        <td>@lang('site.Grade')</td>
                                        <td>{{ $child->grade?->title }} </td>
                                    </tr>
                                    <tr>
                                        <td>@lang('site.Fees')</td>
                                        <td></td>
                                    </tr>
                                    @foreach ($reservation->gradeFees as $gradeFees)
                                        <tr>
                                            <td>{{ $gradeFees->title }}</td>
                                            <td>{{ $gradeFees->pivot->price }} {{ appCurrency() }}</td>
                                        </tr>
                                    @endforeach
                                @endif

                                @if ($reservation->school?->is_nursery_type)
                                    <tr>
                                        <td>@lang('site.Subscription Type')</td>
                                        <td>{{ $child->subscription_type?->title }} -
                                            ({{ $child->subscription_type_price }}) </td>
                                    </tr>
                                    <tr>
                                        <td>@lang('site.Course')</td>
                                        <td>{{ $child->course?->title }} </td>
                                    </tr>
                                    <tr>
                                        <td>@lang('site.Fees')</td>
                                        <td></td>
                                    </tr>
                                    @foreach ($reservation->nurseryFees as $nurseryFees)
                                        <tr>
                                            <td>{{ $nurseryFees->title }}</td>
                                            <td>{{ $nurseryFees->pivot->price }} {{ appCurrency() }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                                @if (isset($reservation->paidServices))
                                    <tr>
                                        <td>@lang('site.Paid Services')</td>
                                        <td></td>
                                    </tr>
                                    @foreach ($reservation->paidServices as $paidService)
                                        <tr>
                                            <td>{{ $paidService->title }}</td>
                                            <td>{{ $paidService->pivot->price }} {{ appCurrency() }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                                <tr>
                                    <td>@lang('site.Transportation')</td>
                                    <td>{{ $child->transportation?->title }} - ({{ $child->transportation_price }})
                                        {{ appCurrency() }}</td>
                                </tr>
                                <tr>
                                    <td>@lang('site.Status')</td>
                                    <td>@lang('site.reservation_status.' . $reservation->status)</td>
                                </tr>
                                @if (isset($child->attachments))
                                    <tr>
                                        <td>@lang('site.Attachments')</td>
                                        <td></td>
                                    </tr>
                                    @foreach ($child->attachments as $attachment)
                                        <tr>
                                            <td>{{ $attachment->attachment?->title }}</td>
                                            <td><a href="{{ $attachment->attachment_file_path }}"
                                                    class="btn btn-primary btn-sm" target="_blank">@lang('site.Download')</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

        </div>
        <!-- //Content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
