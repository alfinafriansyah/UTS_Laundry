
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>{{ config('app.name', 'Laundry') }}</title>
    
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicons -->
    <link href="{{ asset('niceadmin/img/apple-touch-icon.png')}}" rel="icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('niceadmin/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('niceadmin/vendor/bootstrap/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{ asset('niceadmin/vendor/bootstrap/css/select2theme.min.css')}}" rel="stylesheet">
    <link href="{{ asset('niceadmin/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
    <link href="{{ asset('niceadmin/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
    <link href="{{ asset('niceadmin/vendor/quill/quill.snow.css')}}" rel="stylesheet">
    <link href="{{ asset('niceadmin/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
    <link href="{{ asset('niceadmin/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
    <link href="{{ asset('niceadmin/vendor/datatables/dataTables.bootstrap5.css')}}" rel="stylesheet">
      {{-- SweetAlert2 --}}
    <link rel="stylesheet" href="{{ asset('niceadmin/vendor/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">


    <!-- Template Main CSS File -->
    <link href="{{ asset('niceadmin/css/style.css')}}" rel="stylesheet">

    @stack('css')
</head>
<body>
    <!-- ======= Header ======= -->
    @include('admin.layouts.header')

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        @include('admin.layouts.sidebar')

    </aside><!-- End Sidebar-->  

    <!-- Main Content -->
    <main id="main" class="main">

        @yield('content')

    </main><!-- End #main -->
    <!-- ======= Footer ======= -->

    @include('admin.layouts.footer')

    <!-- Vendor JS Files -->
    <script src="{{ asset('niceadmin/js/jquery.min.js')}}"></script>
    <script src="{{ asset('niceadmin/vendor/apexcharts/apexcharts.min.js')}}"></script>
    <script src="{{ asset('niceadmin/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('niceadmin/vendor/bootstrap/js/select2.min.js')}}"></script>
    <script src="{{ asset('niceadmin/vendor/chart.js/chart.umd.js')}}"></script>
    <script src="{{ asset('niceadmin/vendor/echarts/echarts.min.js')}}"></script>
    <script src="{{ asset('niceadmin/vendor/quill/quill.min.js')}}"></script>
    <script src="{{ asset('niceadmin/vendor/datatables/dataTables.js')}}"></script>
    <script src="{{ asset('niceadmin/vendor/datatables/dataTables.bootstrap5.js')}}"></script>
    <script src="{{ asset('niceadmin/vendor/tinymce/tinymce.min.js')}}"></script>
    <script src="{{ asset('niceadmin/vendor/php-email-form/validate.js')}}"></script>
    {{-- jQuery Validation --}}
    <script src="{{ asset('niceadmin/vendor/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('niceadmin/vendor/jquery-validation/additional-methods.in.js') }}"></script>
    {{-- SweetAlert2 --}}
    <script src="{{ asset('niceadmin/vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    


    <!-- Template Main JS File -->
    <script src="{{ asset('niceadmin/js/main.js')}}"></script>
    <script>
        // Untuk mengirimkan token Laravel CSRF pada setiap request ajax
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
    </script>
    @stack('js')
</body>

</html>