<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 "
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0">
            <img src="{{ asset('assets/img/assalaam.png') }}" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold">Perpustakaan</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    {{-- <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main"> --}}
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ url('profil/dashboard') }}">
                <div
                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="bi bi-columns-gap text-sm" style="color: blue"></i>
                </div>
                <span class="nav-link-text ms-1">Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="{{ url('profil/anda')}}">
                <div
                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    {{-- <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10" style="color: black"></i> --}}
                    <i class="bi bi-person-circle text-sm" style="color: black"></i>
                </div>
                <span class="nav-link-text ms-1">Profile</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('profil/daftarbuku') }}">
                <div
                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    {{-- <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10" style="color: black"></i> --}}
                    <i class="bi bi-book-half text-sm" style="color: yellow;"></i>
                </div>
                <span class="nav-link-text ms-1">Daftar Buku</span>
            </a>
        </li>
        <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Tables</h6>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="{{ url('profil/pinjambuku') }}">
                <div
                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    {{-- <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10" style="color: black"></i> --}}
                    <i class="bi bi-box text-sm" style="color: green;"></i>
                </div>
                <span class="nav-link-text ms-1">Data Peminjaman</span>
            </a>
        <li class="nav-item">
            <a class="nav-link " href="{{ url('profil/riwayat') }}">
                <div
                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    {{-- <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10" style="color: black"></i> --}}
                    <i class="bi bi-hourglass-split text-sm" style="color: black;"></i>
                </div>
                <span class="nav-link-text ms-1">Riwayat</span>
            </a>
        </li>
    </ul>
</aside>
