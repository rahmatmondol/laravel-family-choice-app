@extends('admin.layouts.base_auth')
<?php
$page = 'forget-password';
$title = __('site.Reset Password');
?>
@section('title_page')
{{ $title }}
@endsection
@section('content')
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">@lang('site.You are only one step a way from your new password, recover your password now.')</p>

      <form action="{{ route('admin.reset.password.post') }}" method="post">
        @csrf
        @method('post')
        @include('admin.partials._errors')
        <input type="hidden" name="token" value="{{ $passwordReset->token  }}">
        <input type="hidden" name="email" value="{{ $passwordReset->email  }}">
        <div class="input-group mb-3">
          <input type="password" name="password" required class="form-control"  placeholder="@lang('site.Password')">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        @if ($errors->has('password'))
            <span class="text-danger">{{ $errors->first('password') }}</span>
        @endif
        <div class="input-group mb-3">
          <input type="password" name='password_confirmation' required class="form-control" placeholder="@lang('site.Password Confirmation')">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        @if ($errors->has('password_confirmation'))
            <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
        @endif
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">@lang('site.Change Password')</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mt-3 mb-1">
        <a href="{{ route('admin.login') }}">@lang('site.Login')</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
@endsection
