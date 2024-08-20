@if (App\Enums\ReservationStatus::Pending->value == $status)
    <span class="badge bg-info-500 text-white capitalize">@lang('site.reservation_status.' . $status)</span>
@elseif (App\Enums\ReservationStatus::Accepted->value == $status)
    <span class="badge bg-success-500 text-white capitalize">@lang('site.reservation_status.' . $status)</span>
@elseif (App\Enums\ReservationStatus::Rejected->value == $status)
    <span class="badge bg-danger-500 text-white capitalize">@lang('site.reservation_status.' . $status)</span>
@else
@endif
