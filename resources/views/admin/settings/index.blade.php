@extends($masterLayout)
<?php
  $page = 'settings';
  $title = __('site.Edit Settings');
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
            {{-- <li class="breadcrumb-item"><a href="{{ route($mainRoutePrefix.'.settings.index') }}">@lang('site.settings')</a> --}}
            </li>
            <li class="breadcrumb-item active">{{ $title }}</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <form method="post" action="{{ route($mainRoutePrefix.'.settings-update')}}" enctype="multipart/form-data">
      @csrf
      @method('put')
      @include('admin.partials._errors')
      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-body">
              <div class="form-group">
                <label>@lang('site.terms and conditions')</label>
                <textarea class="form-control ckeditor" required name="terms_conditions">{{ setting('terms_conditions') }}</textarea>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>

        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-body">
              <div class="form-group">
                <label>@lang('site.policy and privacy')</label>
                <textarea class="form-control ckeditor" required name="privacy_policy">{{ setting('privacy_policy') }}</textarea>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>

        <div class="col-md-6">
          {{-- email --}}
          <div class="form-group">
            <label for="inputName"> @lang('site.E-mail')</label>
            <input type="email" name="email" value="{{ setting('email') }}" required class="form-control">
          </div>
          {{-- phone --}}
          <div class="form-group">
            <label>@lang('site.Phone')</label>
            <input required="required" type="text" name="phone"  class="form-control" value="{{ setting('phone') }}"
              oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
          </div>
        </div>

        <div class="col-md-6">
          {{-- partial_payment_percent --}}
          <div class="form-group">
            <label>@lang('site.partial_payment_percent')</label>
            <input required="required" type="number" name="partial_payment_percent" min="1" max="90"  class="form-control" value="{{ setting('partial_payment_percent') }}"
              oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
          </div>
        </div>

        <div class="col-md-6">
          {{-- refund_fees_percent --}}
          <div class="form-group">
            <label>@lang('site.refund_fees_percent')</label>
            <input required="required" type="number" name="refund_fees_percent" min="1" max="90"  class="form-control" value="{{ setting('refund_fees_percent') }}"
              oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
          </div>
        </div>

      </div>

      <div class="col-12">
        <button class="btn btn-success" type="submit"><i class="fas fa-save"></i> @lang('site.Save')</button>
      </div>
    </form>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
