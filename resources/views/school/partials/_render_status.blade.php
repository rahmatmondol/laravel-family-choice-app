@if ($status ==1 || $status == 'active')
<span class="badge badge-success">@lang('site.Active')</span>
@else
<span class="badge badge-danger">@lang('site.In-Active')</span>
@endif
