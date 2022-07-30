<div class="form-group">
  <label for="{{ $input_id??$input_name }}">{{ $input_label }}</label>
  <select id="{{ $input_id??$input_name }}" name="{{ $input_name }}" required="{{ $is_required??true }}"
    class="form-control custom-select {{ $calasses??'' }}">
    <option value='' selected disabled>@lang('site.Status')</option>
    <option value="1" @if(old($input_name,isset($_model)$model->$input_name)==1 ) selected @endif >@lang('site.Active')</option>
    <option value="0" @if(old($input_name,$_model?->$input_name)==0 ) selected @endif >@lang('site.In-Active')</option>
  </select>
</div>
