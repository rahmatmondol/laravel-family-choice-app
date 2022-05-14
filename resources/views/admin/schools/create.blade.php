@extends('admin.layouts.master')
<?php
$page = 'schools';
$title = __('site.Create School');
?>
@section('title_page')
{{ $title }}
@endsection

@push('footer_js')

<script type="text/javascript" src="{!! asset('admin/js/initMap.js') !!}"></script>

<!-- en  get states and regoins and streests  -->
<script>
  // Initialize the map.
  @php
    $lat = !empty(old('lat')) ? old('lat') : 24.713552;
    $lng = !empty(old('lng')) ? old('lng') : 46.675297;
  @endphp
  setCoordinates({{ $lat }},{{ $lng }})
</script>

<script src="https://maps.googleapis.com/maps/api/js?key={{env('MAP_KEY')}}&callback&callback=initMap&libraries=places"
  async defer>
</script>
<script type="text/javascript" src="{!! asset('admin/js/locationpicker.jquery.js') !!}"></script>
@endpush

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
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('site.Home')</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.schools.index') }}">@lang('site.Schools')</a>
            </li>
            <li class="breadcrumb-item active">{{ $title }}</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <form method="post" action="{{ route('admin.schools.store')}}" enctype="multipart/form-data">
      @csrf
      @method('post')
      @include('admin.partials._errors')
      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-body">

              @foreach (config('translatable.locales') as $key => $locale)
              <div class="form-group">
                <label>@lang('site.' . $locale . '.Title')</label>
                <input required="required" type="text" name="{{ $locale }}[title]" class="form-control"
                  value="{{ old($locale . '.title') }}">
              </div>
              <div class="form-group">
                <label>@lang('site.' . $locale . '.Address')</label>
                <input required="required" type="text" name="{{ $locale }}[address]" class="form-control"
                  value="{{ old($locale . '.address') }}">
              </div>
              <div class="form-group">
                <label>@lang('site.' . $locale . '.Description')</label>
                <textarea name="{{ $locale }}[description]" id="" class="form-control" cols="30" rows="5"
                  required>{{ old($locale . '.description') }}</textarea>
              </div>
              <div class="  with-border"></div><br>
              @endforeach
              {{-- email --}}
              <div class="form-group">
                <label for="inputName"> @lang('site.E-mail')</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="form-control">
              </div>
              {{-- phone --}}
              <div class="form-group">
                <label>@lang('site.Phone')</label>
                <input required="required" type="text" name="phone" class="form-control" value="{{old('phone')}}"
                  oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
              </div>
              {{-- whatsapp --}}
              <div class="form-group">
                <label>@lang('site.Whatsapp')</label>
                <input required="required" type="text" name="whatsapp" class="form-control" value="{{old('whatsapp')}}"
                  oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
              </div>

              <div class="form-group">
                <label>@lang('site.address')</label>
                <input type="text" name='address' class="form-control" id="address" required>
              </div>

              <div class="form-group">
                <div id="map" style="height:300px !important"></div>
              </div>

              <input type="hidden" class="form-control" id="lat" name="lat" value="{!! $lat !!}">

              <input type="hidden" class="form-control" id="lng" name="lng" value="{!! $lng !!}">


            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-body">


              {{-- types --}}
              <div class="form-group">
                <label for="inputType">@lang('site.types')</label>
                <select name="types[]" class="form-control selectric" multiple data-live-search="true" required>
                  <option value="">@lang('site.types') </option>
                  @foreach( $types as $value )
                  <option value="{{ $value->id}}" @if( in_array($value->id,(array)old('types'))) selected
                    @endif >
                    {{ $value->title }}</option>
                  @endforeach
                </select>
              </div>

              {{-- educationalSubjects --}}
              <div class="form-group">
                <label for="inputType">@lang('site.educationalSubjects')</label>
                <select name="educationalSubjects[]" class="form-control selectric" multiple data-live-search="true"
                  required>
                  <option value="">@lang('site.educationalSubjects') </option>
                  @foreach( $educationalSubjects as $value )
                  <option value="{{ $value->id}}" @if( in_array($value->id,(array)old('educationalSubjects'))) selected
                    @endif >
                    {{ $value->title }}</option>
                  @endforeach
                </select>
              </div>

              {{-- educationTypes --}}
              <div class="form-group">
                <label for="inputType">@lang('site.educationTypes')</label>
                <select name="educationTypes[]" class="form-control selectric" multiple data-live-search="true"
                  required>
                  <option value="">@lang('site.educationTypes') </option>
                  @foreach( $educationTypes as $value )
                  <option value="{{ $value->id}}" @if( in_array($value->id,(array)old('educationTypes'))) selected
                    @endif >
                    {{ $value->title }}</option>
                  @endforeach
                </select>
              </div>

              {{-- schoolTypes --}}
              <div class="form-group">
                <label for="inputType">@lang('site.schoolTypes')</label>
                <select name="schoolTypes[]" class="form-control selectric" multiple data-live-search="true" required>
                  <option value="">@lang('site.schoolTypes') </option>
                  @foreach( $schoolTypes as $value )
                  <option value="{{ $value->id}}" @if( in_array($value->id,(array)old('schoolTypes'))) selected
                    @endif >
                    {{ $value->title }}</option>
                  @endforeach
                </select>
              </div>

              {{-- services --}}
              <div class="form-group">
                <label for="inputType">@lang('site.services')</label>
                <select name="services[]" class="form-control selectric" multiple data-live-search="true" required>
                  <option value="">@lang('site.services') </option>
                  @foreach( $services as $value )
                  <option value="{{ $value->id}}" @if( in_array($value->id,(array)old('services'))) selected
                    @endif >
                    {{ $value->title }}</option>
                  @endforeach
                </select>
              </div>


              {{-- order_column --}}
              <div class="form-group">
                <label>@lang('site.Order It ')</label>
                <input type="text" name="order_column" value="{{ old('order_column') }}" class="form-control"
                  oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
              </div>

              {{-- available_seats --}}
              <div class="form-group">
                <label>@lang('site.Available seats')</label>
                <input required="required" type="text" name="available_seats" class="form-control"
                  value="{{old('available_seats')}}"
                  oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
              </div>


              {{-- fees --}}
              <div class="form-group">
                <label>@lang('site.Fees')</label>
                <input required="required" type="text" name="fees" class="form-control" value="{{old('fees')}}"
                  oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
              </div>


              {{-- status --}}
              <div class="form-group">
                <label for="inputStatus">@lang('site.Status')</label>
                <select id="inputStatus" name="status" required class="form-control custom-select">
                  <option value='' selected disabled>@lang('site.Status')</option>
                  <option value="1" @if(old('status')==1) selected @endif>@lang('site.Active')</option>
                  <option value="0" @if(old('status')==0) selected @endif>@lang('site.In-Active')</option>
                </select>
              </div>

              {{-- passwrod --}}
              <div class="form-group">
                <label>@lang('site.password')</label>
                <input type="password" name="password" class="form-control" required>
              </div>

              {{-- password_confirmation --}}
              <div class="form-group">
                <label>@lang('site.Password Confirmation')</label>
                <input type="password" name="password_confirmation" class="form-control" required>
              </div>

              {{-- image --}}
              <div class="form-group">
                <label>@lang('site.image')</label>
                <input required="required" type="file" id='image' name="image" class="form-control image2">
              </div>

              <div class="form-group">
                <img src="{{ asset('uploads/default.png') }}" style="width: 100px" class="img-thumbnail image-preview2"
                  alt="">
              </div>

              {{-- cover --}}
              <div class="form-group">
                <label>@lang('site.Cover')</label>
                <input required="required" type="file" id='cover' name="cover" class="form-control image3">
              </div>

              <div class="form-group">
                <img src="{{ asset('uploads/default.png') }}" style="width: 100px" class="img-thumbnail image-preview3"
                  alt="">
              </div>

              {{-- attachments --}}
              <div class="form-group">
                <label>@lang('site.attachments')</label>
                <input required="required" type="file" id="gallery-photo-attachments" name="attachments[]" multiple
                  class="form-control image">
              </div>

              <div class="form-group gallery gallery_attachments">

              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <button class="btn btn-success" type="submit" name='continue' value='continue'><i class="fas fa-save"></i>
            @lang('site.Save & Continue')</button>
          <button class="btn btn-success" type="submit"><i class="fas fa-save"></i> @lang('site.Save')</button>
        </div>
      </div>
    </form>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
