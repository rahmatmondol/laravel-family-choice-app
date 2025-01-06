<!DOCTYPE html>
<html lang="en" dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ appName() }} | @yield('title_page') </title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Theme style -->
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('school/') }}/assets/css/rt-plugins.css">
    <link rel="stylesheet" href="{{ asset('school/') }}/assets/css/app.css">


    <script>
        let appUrl = @json(config('myconfig.appUrl'));
        let appLocale = @json(app()->getLocale());
    </script>
    @stack('header_css')
    @stack('header_js')

</head>

<body class="">

    <main class="app-wrapper">
        @include('school/partials/_sidebar')
        @include('school/partials/_navbar')
        <div class="content-wrapper transition-all duration-150 ltr:ml-[248px] rtl:mr-[248px]" id="content_wrapper">
            <div class="page-content" style="background: #f1f5f9;">
                <div class="transition-all duration-150 container-fluid" id="page_layout">
                    <div id="content_layout">
                        @yield('content')
                    </div>
                </div>
            </div>
            @include('school/partials/_footer')
    </main>


    <!-- jQuery -->
    <script src="{{ asset('school/') }}/assets/js/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('school/') }}/assets/js/rt-plugins.js"></script>
    <script src="{{ asset('school/') }}/assets/js/app.js"></script>

    @stack('footer_js')
</body>

</html>
