@if (App\Enums\ReservationStatus::Pending->value == $status)
<span class="badge badge-info">@lang('site.reservation_status.'.$status)</span>
@elseif (App\Enums\ReservationStatus::Accepted->value == $status)
<span class="badge badge-success">@lang('site.reservation_status.'.$status)</span>
@elseif (App\Enums\ReservationStatus::Rejected->value == $status)
<span class="badge badge-danger">@lang('site.reservation_status.'.$status)</span>
@else
@endif
