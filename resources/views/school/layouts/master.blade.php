<!DOCTYPE html>
<html lang="en" dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ appName() }} | @yield('title_page') </title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('admin/') }}/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet"
    href="{{ asset('admin/') }}/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('admin/') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  {{--
  <link rel="stylesheet" href="{{ asset('admin/') }}/plugins/jqvmap/jqvmap.min.css"> --}}

  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('admin/') }}/dist/css/adminlte.min.css">

  @if (LaravelLocalization::getCurrentLocaleDirection() == 'rtl')
    <!-- Bootstrap 4 RTL -->
    <link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.2.1/css/bootstrap.min.css">
    <!-- Custom style for RTL -->
    <link rel="stylesheet" href="dist/css/custom.css">
  @else
  @endif

  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('admin/') }}/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('admin/') }}/plugins/daterangepicker/daterangepicker.css">
  <!-- select2 -->
  <link rel="stylesheet" href="{{ asset('admin/') }}/plugins/select2//css/select2.css">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('admin/') }}/plugins/summernote/summernote-bs4.min.css">
  <!-- selectric -->
  <link rel="stylesheet" href="{{ asset('admin/') }}/plugins/selectric/selectric.css">
  <!-- fancybox -->
  <link rel="stylesheet" href="{{ asset('admin/') }}/plugins/fancybox/jquery.fancybox.min.css">
  {{--noty--}}
  <link rel="stylesheet" href="{{ asset('admin/plugins/noty/noty.css') }}">
  <script src="{{ asset('admin/plugins/noty/noty.min.js') }}"></script>
  <!-- fancybox -->
  <link rel="stylesheet" href="{{ asset('admin/') }}/css/admin.css">

  <script>
    let appUrl     = @json(config('myconfig.appUrl'));
    let appLocale  = @json(app()->getLocale());
  </script>
  @stack('header_css')
  @stack('header_js')

</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    @include('school.partials._navbar')

    @include('school.partials._sidebar')

    @yield('content')

    @include('school.partials._session')

    @include('school.partials._footer')

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="{{ asset('admin/') }}/plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="{{ asset('admin/') }}/plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="{{ asset('admin/') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- ChartJS -->
  <script src="{{ asset('admin/') }}/plugins/chart.js/Chart.min.js"></script>
  <!-- Sparkline -->
  <script src="{{ asset('admin/') }}/plugins/sparklines/sparkline.js"></script>
  <!-- JQVMap -->
  {{-- <script src="{{ asset('admin/') }}/plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="{{ asset('admin/') }}/plugins/jqvmap/maps/jquery.vmap.usa.js"></script> --}}
  <!-- jQuery Knob Chart -->
  <script src="{{ asset('admin/') }}/plugins/jquery-knob/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="{{ asset('admin/') }}/plugins/moment/moment.min.js"></script>
  <script src="{{ asset('admin/') }}/plugins/daterangepicker/daterangepicker.js"></script>
  {{-- select2 --}}
  <script src="{{ asset('admin/') }}/plugins/select2/js/select2.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="{{ asset('admin/') }}/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Summernote -->
  <script src="{{ asset('admin/') }}/plugins/summernote/summernote-bs4.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="{{ asset('admin/') }}/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('admin/') }}/dist/js/adminlte.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="{{ asset('admin/') }}/dist/js/demo.js"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  {{-- <script src="{{ asset('admin/') }}/dist/js/pages/dashboard.js"></script> --}}
  <script src="{{ asset('admin/') }}/plugins/selectric/jquery.selectric.min.js"></script>
  {{-- fancybox --}}
  <script src="{{ asset('admin/') }}/plugins/fancybox/jquery.fancybox.min.js"></script>
  {{-- admin --}}
  <script src="{{ asset('admin/') }}/js/admin.js"></script>
  <script>
    $('.selectric').selectric();
  </script>

  @if (LaravelLocalization::getCurrentLocaleDirection() == 'rtl')
  <!-- Bootstrap 4 rtl -->
  <script src="https://cdn.rtlcss.com/bootstrap/v4.2.1/js/bootstrap.min.js"></script>
  @endif
  <script>
    $(document).ready(function () {
      //delete modal
      $('.confirm-delete').click(function (e) {
          var that = $(this)
          e.preventDefault();
          var n = new Noty({
              text: "@lang('site.Confirm operation')",
              type: "warning",
              killer: true,

              buttons: [
                  Noty.button("  &nbsp;&nbsp;&nbsp;  @lang('site.yes')",
                      'btn btn-danger mr-2 fa fa-trash ui-button',
                      function () {

                          that.closest('form').submit();

                      }),
                  Noty.button(" &nbsp;&nbsp;&nbsp;  @lang('site.no')   ",
                      'btn btn-primary mr-2 fa fa-close',
                      function () {
                          n.close();
                      })
              ]
          });
          n.show();
      }); //end of delete
      // image preview
      for (let index = 0; index < 4; index++) {
        $(`.image${index}`).change(function () {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(`.image-preview${index}`).attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
      }
    })
  </script>

  @stack('footer_js')

</body>

</html>
