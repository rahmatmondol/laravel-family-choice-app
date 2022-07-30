<div class="form-group">
  <label for="{{ $input_id }}"> {{ $input_label }}</label>
  <input type="{{ $input_type??'text' }}" name="{{ $input_name }}" id="{{ $input_id }}"
    required="{{ $is_required??false }}" class="form-control {{ $input_classes??'' }}" {{ $validation??''}}>
</div>
