<div>
  <label for="" class="alert alert-danger col-xs-12 text-center">
    @if (isset($text))
    @lang('site.'.$text)
    @else
    @lang('site.No Data Found')
    @endif
  </label>
</div>
