<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masjid Al-... App</title>

    @include('client.asset.css')

    <!--

TemplateMo 600 Prism Flux

https://templatemo.com/tm-600-prism-flux

-->
</head>

<body>
    <!-- Loading Screen -->
    {{-- <div class="loader" id="loader">
        <div class="loader-content">
            <div class="loader-prism">
                <div class="prism-face"></div>
                <div class="prism-face"></div>
                <div class="prism-face"></div>
            </div>
            <div style="color: var(--accent-purple); font-size: 18px; text-transform: uppercase; letter-spacing: 3px;">
                Selamat Datang...</div>
        </div>
    </div> --}}

    <!-- Navigation Header -->
    @include('client.partials.navbar')

    @yield('content')

    <!-- Footer -->
    @include('client.partials.footer')
    @include('client.asset.js')
</body>

</html>
