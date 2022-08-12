@extends('school.layouts.base_auth')
<?php
$page = 'forget-password';
$title = __('site.Forget Password Request');
?>
@section('title_page')
{{ $title }}
@endsection
@section('content')
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">@lang('site.You forgot your password? Here you can easily retrieve a new password.')</p>

      <form action="{{ route('school.forget.password.post') }}" method="post">
        @csrf
        @method('post')
        <div class="input-group mb-3">

          <input type="email" name="email" required class="form-control" placeholder="@lang('site.E-mail')">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        @if ($errors->has('email'))
            <span class="text-danger">{{ $errors->first('email') }}</span>
        @endif
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">@lang('site.Request new password')</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mt-3 mb-1">
        <a href="{{ route('school.login') }}">@lang('site.Login')</a>
      </p>

    </div>
    <!-- /.login-card-body -->
  </div>
@endsection
