@extends($masterLayout)
<?php
$page = 'customers';
$title = __('site.Edit Customer');
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
            <li class="breadcrumb-item"><a href="{{ route($mainRoutePrefix.'.customers.index') }}">@lang('site.Customers')</a>
            </li>
            <li class="breadcrumb-item active">{{ $title }}</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <form method="post" action="{{ route($mainRoutePrefix.'.customers.update',$customer->id)}}" enctype="multipart/form-data">
      @csrf
      @method('put')
      @include('admin.partials._errors')
      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-body">
              {{-- full_name --}}
              <div class="form-group">
                <label for="inputName"> @lang('site.Full Name')</label>
                <input type="text" name="full_name" value="{{ old('full_name',$customer->full_name) }}" required
                  class="form-control">
              </div>
              {{-- email --}}
              <div class="form-group">
                <label for="inputName"> @lang('site.E-mail')</label>
                <input type="email" name="email" value="{{ old('email',$customer->email) }}" required class="form-control">
              </div>
              {{-- phone --}}
              <div class="form-group">
                <label>@lang('site.Phone') (@lang('site.9 digits'))</label>
                <input required="required" type="phone" name="phone" class="form-control" maxlength="9"
                  value="{{old('phone',$customer->phone)}}"
                  oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
              </div>
              {{-- passwrod --}}
              {{-- <div class="form-group">
                <label>@lang('site.Password')</label>
                <input type="password" name="password" class="form-control" >
              </div> --}}
              {{-- password_confirmation --}}
              {{-- <div class="form-group">
                <label>@lang('site.Password Confirmation')</label>
                <input type="password" name="password_confirmation" class="form-control" >
              </div> --}}

            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-body">
              {{-- cities --}}
              {{-- <div class="form-group">
                <label>@lang('site.Cities')</label>
                <select name="cities[]" class="form-control selectric" multiple required>
                  @foreach ($cities as $role)
                  <option value="{{ $role->id }}" @if() @endif>{{
                    $role->name }}</option>
                  @endforeach
                </select>
                <a href="{{ route($mainRoutePrefix.'.cities.create') }}">@lang('site.Create new city')</a>
              </div> --}}
              {{-- date_of_birth --}}
              <div class="form-group">
                <label>@lang('site.Date of birth')</label>
                <input type="date" name="date_of_birth" value="{{ old('date_of_birth',$customer->date_of_birth) }}"
                  class="form-control" required>
              </div>
              {{-- gender --}}
              <div class="form-group">
                <label for="inputGender">@lang('site.Gender')</label>
                <select id="inputGender" name="gender" required class="form-control custom-select">
                  <option value='' selected disabled>@lang('site.Gender')</option>
                  <option value="male" @if(old('gender',$customer->gender)=='male' ) selected @endif>@lang('site.Male')
                  </option>
                  <option value="female" @if(old('gender',$customer->gender)=='female' ) selected @endif>@lang('site.Female')
                  </option>
                </select>
              </div>
              {{-- status --}}
              <div class="form-group">
                <label for="inputStatus">@lang('site.Status')</label>
                <select id="inputStatus" name="status" required class="form-control custom-select">
                  <option value='' selected disabled>@lang('site.Status')</option>
                  <option value="1" @if(old('status',$customer->status)==1) selected @endif>@lang('site.Active')</option>
                  <option value="0" @if(old('status',$customer->status)==0) selected @endif>@lang('site.In-Active')</option>
                </select>
              </div>
              {{-- verified --}}
              <div class="form-group">
                <label for="inputVerified">@lang('site.Verified')</label>
                <select id="inputVerified" name="verified" required class="form-control custom-select">
                  <option value='' selected disabled>@lang('site.Verified')</option>
                  <option value="1" @if(old('verified',$customer->verified)==1) selected @endif>@lang('site.Active')</option>
                  <option value="0" @if(old('verified',$customer->verified)==0) selected @endif>@lang('site.In-Active')</option>
                </select>
              </div>

              <div class="form-group">
                <label>@lang('site.Image')</label>
                <input type="file" id='image' name="image" class="form-control image1">
              </div>

              <div class="form-group">
                <img src="{{ $customer->image_path }}" style="width: 100px" class="img-thumbnail image-preview1" alt="">
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
