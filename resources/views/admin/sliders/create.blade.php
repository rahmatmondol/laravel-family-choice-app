@extends('admin.layouts.master')
<?php
$page = 'sliders';
$title = __('site.Create Slider');
?>
@section('title_page')
{{ $title }}
@endsection
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
            <li class="breadcrumb-item"><a href="{{ route('admin.sliders.index') }}">@lang('site.Sliders')</a>
            </li>
            <li class="breadcrumb-item active">{{ $title }}</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <form method="post" action="{{ route('admin.sliders.store')}}" enctype="multipart/form-data">
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
                <label>@lang('site.' . $locale . '.Description')</label>
                <input required="required" type="text" name="{{ $locale }}[description]" class="form-control"
                  value="{{ old($locale . '.description') }}">
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

              {{-- schools --}}
              <div class="form-group">
                <label>@lang('site.Schools')</label>
                <select name="school_id" class="form-control">
                  <option value='' selected>@lang('site.Schools')</option>
                  @foreach ($schools as $school)
                  <option value="{{ $school->id }}" @if(old('school_id')==$school->id) selected @endif>{{
                    $school->title }}</option>
                  @endforeach
                </select>
                <a href="{{ route('admin.schools.create') }}">@lang('site.Create new school')</a>
              </div>

              {{-- link --}}
              <div class="form-group">
                <label>@lang('site.Link')</label>
                <input type="text" name="link" value="{{ old('link') }}" class="form-control">
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
                <label>@lang('site.Image')</label>
                <input type="file" id='image' name="image" class="form-control image1" required>
              </div>

              <div class="form-group">
                <img src="{{ asset('uploads/default.png') }}" style="width: 100px" class="img-thumbnail image-preview1"
                  alt="">
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
