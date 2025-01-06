<!DOCTYPE html>
<html lang="en" dir="ltr" class="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <title>@lang('School Login')</title>
    <link rel="icon" type="image/png" href="{{ asset('school/') }}/assets/images/logo/favicon.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('school/') }}/assets/css/rt-plugins.css">
    <link href="https://unpkg.com/aos@2.3.0/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
        integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="">
    <link rel="stylesheet" href="{{ asset('school/') }}/assets/css/app.css">
    <!-- START : Theme Config js-->
    <script src="{{ asset('school/') }}/assets/js/settings.js" sync></script>
    <!-- END : Theme Config js-->
</head>

<body class=" font-inter skin-default">
    <!-- [if IE]> <p class="browserupgrade">
            You are using an <strong>outdated</strong> browser. Please
            <a href="https://browsehappy.com/">upgrade your browser</a> to improve
            your experience and security.
        </p> <![endif] -->

    <div class="loginwrapper">
        <div class="lg-inner-column">
            <div class="left-column relative z-[1]">
                <div class="max-w-[520px] pt-20 ltr:pl-20 rtl:pr-20">
                    <h4>
                        @lang('Welcome to') {{ appName() }}
                    </h4>
                </div>
                <div class="absolute left-0 2xl:bottom-[-160px] bottom-[-130px] h-full w-full z-[-1]">
                    <img src="{{ asset('school/') }}/assets/images/auth/ils1.svg" alt=""
                        class=" h-full w-full object-contain">
                </div>
            </div>
            <div class="right-column  relative">
                <div class="inner-content h-full flex flex-col bg-white dark:bg-slate-800">
                    <div class="auth-box h-full flex flex-col justify-center">
                        <div class="mobile-logo text-center mb-6 lg:hidden block">
                            <a href="index.html">
                                <img src="{{ asset('school/') }}/assets/images/logo/logo.svg" alt=""
                                    class="mb-10 dark_logo">
                                <img src="{{ asset('school/') }}/assets/images/logo/logo-white.svg" alt=""
                                    class="mb-10 white_logo">
                            </a>
                        </div>
                        <div class="text-center 2xl:mb-10 mb-4">
                            <h4 class="font-medium">@lang('School Login') </h4>
                            <div class="text-slate-500 text-base">
                                @lang('Enter your email & password to login')
                            </div>
                        </div>
                        <!-- BEGIN: Login Form -->
                        <form action="{{ route('school.login-post') }}" method="post">
                            @csrf
                            @method('post')
                            @include('school.partials._errors')

                            <div class="fromGroup">
                                <label class="block capitalize form-label">@lang('Email')</label>
                                <div class="relative ">
                                    <input type="email" name="email" class="form-control py-2"
                                        placeholder="@lang('site.E-mail')">
                                </div>
                            </div>
                            <div class="fromGroup mt-4">
                                <label class="block capitalize form-label">@lang('Password')</label>
                                <div class="relative ">
                                    <input type="password" name="password"
                                        class="form-control py-1" placeholder="@lang('site.Password')" >
                                </div>
                            </div>
                            <div class="flex justify-between pt-4">
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" class="hiddens" name="remember">
                                    <span
                                        class="text-slate-500 dark:text-slate-400 text-sm leading-6 capitalize">@lang('Remember me')</span>
                                </label>
                                <a class="text-sm text-slate-800 dark:text-slate-400 leading-6 font-medium"
                                    href="{{ route('school.forget.password.post') }}">@lang('Forgot password?')
                                </a>
                            </div>
                            <button type="submit"
                                class="btn btn-dark block w-full text-center mt-5">@lang('Login')</button>
                        </form>
                        <!-- END: Login Form -->
                    </div>
                    <div class="auth-footer text-center">
                        @lang('Copyright 2024, famelychoice All Rights Reserved.')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- scripts -->
    <script src="{{ asset('school/') }}/assets/js/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('school/') }}/assets/js/rt-plugins.js"></script>
    <script src="{{ asset('school/') }}/assets/js/app.js"></script>
</body>

</html>
