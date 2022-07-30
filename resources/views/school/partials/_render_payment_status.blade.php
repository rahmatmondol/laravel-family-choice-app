@if (App\Enums\PaymentStatus::Pending->value == $status)
<span class="badge badge-info">@lang('site.payment_status.'.$status)</span>
@elseif (App\Enums\PaymentStatus::Succeeded->value == $status)
<span class="badge badge-success">@lang('site.payment_status.'.$status)</span>
@elseif (App\Enums\PaymentStatus::Failed->value == $status)
<span class="badge badge-danger">@lang('site.payment_status.'.$status)</span>
@else
@endif
