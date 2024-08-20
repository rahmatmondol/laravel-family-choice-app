@if (App\Enums\PaymentStatus::Pending->value == $status)
<span class="badge bg-info-500 text-white capitalize">@lang('site.payment_status.'.$status)</span>
@elseif (App\Enums\PaymentStatus::Succeeded->value == $status)
<span class="badge bg-success-500 text-white capitalize">@lang('site.payment_status.'.$status)</span>
@elseif (App\Enums\PaymentStatus::Failed->value == $status)
<span class="badge bg-danger-500 text-white capitalize">@lang('site.payment_status.'.$status)</span>
@else
@endif
