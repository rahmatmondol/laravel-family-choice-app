@extends($masterLayout)
<?php
$page = 'schools';
$title = __('site.Edit Subscription');
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
            <li class="breadcrumb-item"><a href="{{ route($mainRoutePrefix.'.dashboard') }}">@lang('site.Home')</a></li>
            <li class="breadcrumb-item"><a
                href="{{ route($mainRoutePrefix.'.schools.subscriptions.index',['school' => $school->id]) }}">@lang('site.Subscriptions')</a>
            </li>
            <li class="breadcrumb-item active">{{ $title }}</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <form method="post"
      action="{{ route($mainRoutePrefix.'.schools.subscriptions.update',['school'=>$nurserySubscription->school_id,'subscription'=>$nurserySubscription->subscription_id]) }}"
      enctype="multipart/form-data">
      @csrf
      @method('put')
      @include('admin.partials._errors')
      <input type="hidden" name="school_id" value="{{ $school->id }}">

      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-body">

              {{-- subscriptions --}}
              <div class="form-group">
                <label for="inputType">@lang('site.Subscriptions')</label>
                <select name="subscription_id" class="form-control" required disabled>
                  <option value="">@lang('site.Subscriptions') </option>
                  @foreach( $subscriptions as $value )
                  <option value="{{ $value->id}}" @if( old('subscription_id',$nurserySubscription->subscription_id)==$value->id ) selected
                    @endif>
                    {{ $value->title }}</option>
                  @endforeach
                </select>
              </div>


            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-body">

              {{-- status --}}
              <div class="form-group">
                <label for="inputStatus">@lang('site.Status')</label>
                <select id="inputStatus" name="status" required class="form-control custom-select">
                  <option value='' selected disabled>@lang('site.Status')</option>
                  <option value="1" @if(old('status',$nurserySubscription->status)==1) selected @endif>@lang('site.Active')
                  </option>
                  <option value="0" @if(old('status',$nurserySubscription->status)==0) selected @endif>@lang('site.In-Active')
                  </option>
                </select>
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
