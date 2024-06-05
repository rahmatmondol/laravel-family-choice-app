@extends($masterLayout)
<?php
$page = 'courses';
$title = __('site.Create Course');
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
            <li class="breadcrumb-item"><a href="{{ route('school.dashboard') }}">@lang('site.Home')</a></li>
            <li class="breadcrumb-item"><a href="{{ route('school.courses.index') }}">@lang('site.Courses')</a>
            </li>
            <li class="breadcrumb-item active">{{ $title }}</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <form method="post" action="{{ route('school.courses.store')}}" enctype="multipart/form-data">
      @csrf
      @method('post')
      @include('school.partials._errors')
      <input type="hidden" name="school_id" value="{{ $globalSchool->id }}">
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
                <label>@lang('site.' . $locale . '.Short Description')</label>
                <input required="required" type="text" name="{{ $locale }}[short_description]" class="form-control"
                  value="{{ old($locale . '.short_description') }}">
              </div>
              <div class="form-group">
                <label>@lang('site.' . $locale . '.Description')</label>
                <textarea required="required" type="text" name="{{ $locale }}[description]"
                  class="form-control">{{ old($locale . '.description') }}</textarea>
              </div>
              <div class="  with-border"></div><br>
              @endforeach

              {{-- from_date --}}
              <div class="form-group">
                <label>@lang('site.From Date')</label>
                <input type="date" name="from_date" value="{{ old('from_date') }}" class="form-control">
              </div>

              {{-- to_date --}}
              <div class="form-group">
                <label>@lang('site.To Date')</label>
                <input type="date" name="to_date" value="{{ old('to_date') }}" class="form-control">
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-body">
              {{-- subscriptions --}}
              <div class="form-group">
                <label>@lang('site.Subscriptions')</label>
                <select name="subscription_id" class="form-control" required>
                  <option value='' selected disabled>@lang('site.Subscriptions')</option>
                  @foreach ($subscriptions as $subscription)
                  <option value="{{ $subscription->id }}" @if(old('subscription_id')==$subscription->id) selected @endif>{{
                    $subscription->title }}</option>
                  @endforeach
                </select>
              </div>

              {{-- type --}}
              <div class="form-group">
                <label for="inputType">@lang('site.Type')</label>
                <select id="inputType" name="type" required class="form-control custom-select">
                  <option value='' selected disabled>@lang('site.Type')</option>
                  <option value="summery" @if(old('type')=='summery' ) selected @endif>@lang('site.Summery')</option>
                  <option value="wintry" @if(old('type')=='wintry' ) selected @endif>@lang('site.Wintry')</option>
                </select>
              </div>

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
