<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 "
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0"
            target="_blank">
            <img src="{{ asset('assets/img/assalaam.png') }}" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold">Perpustakaan</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    {{-- <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main"> --}}
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ url('admin/dashboard') }}">
                <div
                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="bi bi-columns-gap text-primary text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            {{-- @if(Auth::check() && Auth::user()->role === 'admin') --}}
                <a class="nav-link" href="{{ url('admin/user') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-world-2 text-sm" style="color: black;"></i>
                    </div>
                    <span class="nav-link-text ms-1">User</span>
                </a>
            {{-- @endif --}}
        </li>        
        {{-- <li class="nav-item">
            <a class="nav-link " href="{{ url('admin/kontak') }}">
                <div
                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
                    <i class="bi bi-person-lines-fill" style="color: black;"></i>
                </div>
                <span class="nav-link-text ms-1">Kontak</span>
            </a>
        </li> --}}
        <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Tables</h6>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="{{ url('admin/kategori') }}">
                <div
                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    {{-- <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10" style="color: black"></i> --}}
                    <i class="bi bi-list text-sm" style="color: blue;"></i>
                </div>
                <span class="nav-link-text ms-1">kategori</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="{{ url('admin/penulis') }}">
                <div
                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    {{-- <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i> --}}
                    <i class="bi bi-pencil-square text-sm" style="color: yellow"></i>
                </div>
                <span class="nav-link-text ms-1">Penulis</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="{{ url('admin/penerbit') }}">
                <div
                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    {{-- <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i> --}}
                    <i class=" bi-file-earmark-text text-sm" style="color: red;"></i>
                </div>
                <span class="nav-link-text ms-1">Penerbit</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="{{ url('admin/buku') }}">
                <div
                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    {{-- <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i> --}}
                    <i class="bi bi-book-half text-sm" style="color: green;"></i>
                </div>
                <span class="nav-link-text ms-1">Buku</span>
            </a>
        </li>
        <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Data Peminjaman</h6>
        </li>
        
        <li class="nav-item">
            <a class="nav-link" href="{{ url('admin/pinjambuku') }}">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center position-relative">
                    <i class="bi bi-envelope text-sm" style="color: pink"></i>
                    @if($notifymenunggu > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge bg-danger" style="font-size: 0.6rem; padding: 0.2em 0.4em;">
                            {{ $notifymenunggu }}
                        </span>
                    @endif
                </div>
                <span class="nav-link-text ms-1">Pengajuan</span>
            </a>
        </li>
        
        {{-- <li class="nav-item">
            <a class="nav-link" href="{{ url('admin/pengajuankembali') }}">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center position-relative">
                    <i class="bi bi-book-half text-sm" style="color: yellow"></i>
                    @if($notifpengajuankembali > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge bg-danger" style="font-size: 0.6rem; padding: 0.2em 0.4em;">
                            {{ $notifpengajuankembali }}
                        </span>
                    @endif
                </div>
                <span class="nav-link-text ms-1">Permintaan Pengembalian</span>
            </a>
        </li> --}}
        
        <li class="nav-item">
            <a class="nav-link" href="{{ url('admin/dipinjam') }}">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center position-relative">
                    <i class="bi bi-archive-fill text-sm" style="color: blue"></i>
                </div>
                <span class="nav-link-text ms-1">Buku Yang dipinjam</span>
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link" href="{{ url('admin/pengembalian') }}">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center position-relative">
                    <i class="bi bi-hourglass-split text-sm" style="color: black"></i>
                </div>
                <span class="nav-link-text ms-1">Riwayat</span>
            </a>
        </li>

        {{-- <li class="nav-item">
            <a class="nav-link" href="{{ url('admin/ditolak') }}">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center position-relative">
                    <i class="bi bi-book-half text-sm" style="color: red"></i>
                </div>
                <span class="nav-link-text ms-1">Tidak Disetujui</span>
            </a>
        </li> --}}
        
        
    </ul>
</aside>
