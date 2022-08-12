@extends('school.layouts.base_auth')
<?php
$page = 'login';
$title = __('site.Login');
?>
@section('title_page')
{{ $title }}
@endsection
@section('content')

<div class="card">
  <div class="card-body login-card-body">
    <p class="login-box-msg">@lang('site.Sign in to start your session')</p>
    <form action="{{ route('school.login-post') }}" method="post">
      @csrf
      @method('post')
      @include('school.partials._errors')
      <div class="input-group mb-3">
        <input type="email" name='email' class="form-control" placeholder="@lang('site.E-mail')" required>
        <div class="input-group-append">
          <div class="input-group-text">
            <span class="fas fa-envelope"></span>
          </div>
        </div>
      </div>
      <div class="input-group mb-3">
        <input type="password" name="password" class="form-control" placeholder="@lang('site.Password')" required>
        <div class="input-group-append">
          <div class="input-group-text">
            <span class="fas fa-lock"></span>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-8">
          <div class="icheck-primary">
            <input type="checkbox" id="remember" name="remember">
            <label  abel for="remember">
              @lang('site.Remember Me')
            </label>
          </div>
        </div>

        <div class="col-4">
          <button type="submit" class="btn btn-primary btn-block">@lang('site.Sign In')</button>
        </div>

      </div>
    </form>
    <p class="mb-1">
      <a href="{{ route('school.forget.password.post') }}">@lang('site.I forgot my password')</a>
    </p>
    {{--
    <p class="mb-0">
      <a href="register.html" class="text-center">Register a new membership</a>
    </p> --}}
  </div>

</div>
@endsection
