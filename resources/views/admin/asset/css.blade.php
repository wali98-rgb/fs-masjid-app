<!-- Favicon -->
<link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap" rel="stylesheet" />

<link rel="stylesheet" href="{{ asset('admin/template/assets/vendor/fonts/iconify-icons.css') }}" />

<!-- Core CSS -->
<!-- build:css assets/vendor/css/theme.css -->

<link rel="stylesheet" href="{{ asset('admin/template/assets/vendor/libs/node-waves/node-waves.css') }}" />

<link rel="stylesheet" href="{{ asset('admin/template/assets/vendor/css/core.css') }}" />
<link rel="stylesheet" href="{{ asset('admin/template/assets/css/demo.css') }}" />

<!-- Vendors CSS -->

<link rel="stylesheet"
    href="{{ asset('admin/template/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

<!-- endbuild -->

<link rel="stylesheet" href="{{ asset('admin/template/assets/vendor/libs/apex-charts/apex-charts.css') }}" />

<!-- Page CSS -->

<!-- Helpers -->
<script src="{{ asset('admin/template/assets/vendor/js/helpers.js') }}"></script>
<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

<!--? Config: Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file. -->

<script src="{{ asset('admin/template/assets/js/config.js') }}"></script>

@yield('css-plus')
