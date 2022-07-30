@extends($masterLayout)
<?php
$page = 'user_manuals';
$title = __('site.Edit User Manual');
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
            <li class="breadcrumb-item"><a href="{{ route('admin.user_manuals.index') }}">@lang('site.User Manuals')</a>
            </li>
            <li class="breadcrumb-item active">{{ $title }}</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <form method="post" action="{{ route('admin.user_manuals.update',$user_manual->id)}}" enctype="multipart/form-data">
      @csrf
      @method('put')
      @include('admin.partials._errors')
      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-body">

              @foreach (config('translatable.locales') as $key => $locale)
              <div class="form-group">
                <label>@lang('site.' . $locale . '.Title')</label>
                <input required="required" type="text" name="{{ $locale }}[title]" class="form-control"
                  value="{{ old($locale . '.title',$user_manual->translate($locale)->title) }}">
              </div>
              <div class="form-group">
                <label>@lang('site.' . $locale . '.Description')</label>
                <textarea name="{{ $locale }}[description]" id="" class="form-control" cols="30" rows="5"
                  required>{{ old($locale . '.description',$user_manual->translate($locale)->description) }}</textarea>
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
                <input type="text" name="order_column" value="{{ old('order_column',$user_manual->order_column) }}"
                  class="form-control"
                  oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
              </div>

              {{-- status --}}
              <div class="form-group">
                <label for="inputStatus">@lang('site.Status')</label>
                <select id="inputStatus" name="status" required class="form-control custom-select">
                  <option value='' selected disabled>@lang('site.Status')</option>
                  <option value="1" @if(old('status',$user_manual->status)==1) selected @endif>@lang('site.Active')
                  </option>
                  <option value="0" @if(old('status',$user_manual->status)==0) selected @endif>@lang('site.In-Active')
                  </option>
                </select>
              </div>
              {{-- <div class="form-group">
                <label>@lang('site.Image')</label>
                <input type="file" id='image' name="image" class="form-control image1">
              </div>

              <div class="form-group">
                <img src="{{ $user_manual->image_path }}" style="width: 100px" class="img-thumbnail image-preview1"
                  alt="">
              </div> --}}

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
