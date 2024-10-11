<!--
=========================================================
* Argon Dashboard 2 - v2.0.4
=========================================================

* Product Page: https://www.creative-tim.com/product/argon-dashboard
* Copyright 2022 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/assalaam2.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/assalaam2.png') }}">
    <title>Perpustakaan - @yield('title', 'Perpustakaan SMK Assalaam')</title>


    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.js"></script>

    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js')}}" crossorigin="anonymous"></script>
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assets/css/argon-dashboard.css') }}?v=2.0.4" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">



    <style>
        .crisp-client {
            max-width: 400px !important;
            /* Ganti dengan lebar yang diinginkan */
            width: auto !important;
            height: auto !important;
        }
    </style>

    <script type="text/javascript">
        window.$crisp = [];
        window.CRISP_WEBSITE_ID = "dbde1bfd-4933-4bf3-a803-3d1807a6faa9";
        (function() {
            d = document;
            s = d.createElement("script");
            s.src = "https://client.crisp.chat/l.js";
            s.async = 1;
            d.getElementsByTagName("head")[0].appendChild(s);
        })();

        window.addEventListener('load', function() {
            const interval = setInterval(function() {
                const chatBox = document.querySelector('.crisp-client'); // Pastikan ini selector yang benar
                if (chatBox) {
                    chatBox.style.maxWidth = '400px'; // Ganti dengan lebar yang diinginkan
                    chatBox.style.width = 'auto'; // Sesuaikan lebar
                    clearInterval(interval);
                }
            }, 100); // Cek setiap 100ms sampai elemen tersedia
        });
    </script>


    @yield('styles')
</head>

<body class="g-sidenav-show   bg-gray-100" style="overflow-x: hidden">
    <div class="min-height-300 bg-primary position-absolute w-100"></div>
    {{-- start sidebar --}}
    @include('layouts.profil.sidebar')
    {{-- end sidebar --}}
    <main class="main-content position-relative border-radius-lg ">
        <!-- start Navbar -->
        @include('layouts.profil.nav')
        <!-- End Navbar -->

        {{-- start content --}}
        @yield('content')
        {{-- end content --}}

        <div class="container-fluid py-4">
            {{-- start footer --}}
            @include('layouts.profil.footer')
            {{-- end footer --}}
        </div>
    </main>
    <!--   Core JS Files   -->
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js')}}"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('assets/js/argon-dashboard.min.js') }}?v=2.0.4"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>\
    <script>
        @import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css");
    </script>
    @include('sweetalert::alert')
    @stack('scripts')

</body>

</html>
