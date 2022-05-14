@extends('admin.layouts.master')
<?php
$page = 'cities';
$title = __('site.Create City');
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
            <li class="breadcrumb-item"><a href="{{ route('admin.cities.index') }}">@lang('site.Cities')</a>
            </li>
            <li class="breadcrumb-item active">{{ $title }}</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <form method="post" action="{{ route('admin.cities.store')}}" enctype="multipart/form-data">
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
              <div class="  with-border"></div><br>
              @endforeach

            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-body">

              {{-- order_column --}}
              <div class="form-group">
                <label>@lang('site.Order Item')</label>
                <input type="text" name="order_column" value="{{ old('order_column') }}" class="form-control"
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
