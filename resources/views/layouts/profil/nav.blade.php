<style>
    body {
        font-family: Arial, sans-serif;
    }

    .profile-menu {
        position: relative;
        display: inline-block;
    }

    .profile-button {
        background-color: #fff;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        padding: 10px;
        border-radius: 50%;
        outline: none;
    }

    .profile-button img {
        border-radius: 50%;
        width: 30px;
        height: 30px;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        right: 0;
        background-color: #fff;
        min-width: 200px;
        box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
        z-index: 1;
        border-radius: 10px;
    }

    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    .dropdown-content a:hover {
        background-color: #f1f1f1;
    }

    .profile-menu:hover .dropdown-content {
        display: block;
    }

    .dropdown-content hr {
        margin: 0;
        border: none;
        border-top: 1px solid #f1f1f1;
    }

    .notification-icon {
        position: relative;
        cursor: pointer;
        display: inline-block;
        margin-right: 20px;
        z-index: 1000;
    }

    .notification-icon .badge {
        position: absolute;
        top: -5px;
        right: -5px;
        background-color: red;
        color: white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        z-index: 1010;
    }

    .notification-dropdown {
        display: none;
        position: absolute;
        top: 100%;
        right: 0;
        background-color: #f9f9f9;
        /* Warna latar belakang yang lebih cerah */
        min-width: 300px;
        /* Lebar minimum lebih besar */
        width: 350px;
        /* Lebar tetap untuk dropdown */
        max-height: 300px;
        overflow-y: auto;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        border-radius: 8px;
        z-index: 1000;
        padding: 15px;
        /* Tambahkan padding untuk ruang di sekitar konten */
    }

    .notification-icon:hover .notification-dropdown {
        display: block;
    }

    .notification-dropdown a {
        color: #333;
        text-decoration: none;
        display: block;
        padding: 10px 15px;
        /* Padding yang lebih besar untuk area klik yang lebih nyaman */
        border-radius: 4px;
        /* Rounded corners untuk setiap item */
        margin-bottom: 8px;
        /* Spacing antar notifikasi */
        transition: background-color 0.3s;
        /* Transisi halus untuk hover */
    }

    .notification-dropdown a:last-child {
        border-bottom: none;
    }

    .notification-dropdown a:hover {
        background-color: #f8f9fa;
    }

    .notification-dropdown .d-flex {
        margin-bottom: 2px;
    }

    .notification-dropdown p {
        font-size: 12px;
        /* Ukuran font untuk teks tambahan */
        margin: 0;
        /* Menghapus margin default */
    }

    .notification-dropdown small {
        font-size: 10px;
        /* Ukuran font untuk waktu */
        color: #888;
        /* Warna lebih terang untuk waktu */
    }
</style>

<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
    data-scroll="false">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm text-white active" aria-current="page">Perpustakaan</li>
            </ol>
            <h6 class="font-weight-bolder text-white mb-0">SMK ASSALAAM BANDUNG</h6>
        </nav>

        <div class="d-flex align-items-center">
            <!-- notification -->
            <div class="notification-icon mx-3">
                <i class="bi bi-bell" style="font-size: 24px; color: white;"></i>
                @if ($notification->count() > 0)
                    <span class="badge">{{ $notification->count() }}</span>
                @endif
                <div class="notification-dropdown">
                    @if ($notification->count() > 0)
                        @foreach ($notification as $item)
                            <a href="#">
                                <strong>{{ $item->type }}</strong>
                                <p>{{ $item->pesan }}</p>
                                <small>{{ $item->created_at->diffForHumans() }}</small>
                            </a>
                        @endforeach
                    @else
                        <p class="text-center p-3">Tidak ada notifikasi</p>
                    @endif
                </div>
            </div>

            <!-- Profile Menu -->
            <div class="profile-menu">
                <button class="profile-button">
                    <img src="{{ Auth::user()->image_user ? asset('images/user/' . Auth::user()->image_user) : asset('assets/img/user.jpg') }}"
                        alt="User Image">
                </button>

                <div class="dropdown-content">
                    <div style="padding: 20px; text-align: center;">
                        <div
                            style="width: 110px; height: 110px; background-color: #f1f1f1; border-radius: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center;">
                            <img src="{{ Auth::user()->image_user ? asset('images/user/' . Auth::user()->image_user) : asset('assets/img/user.jpg') }}"
                                alt="Profile Image"
                                style="border-radius: 50%; width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <p
                            style="margin: 15px 0 0 0; font-weight: bold; font-family: 'Comic Sans MS', cursive, sans-serif; color: #1f1f1f;">
                            Hello {{ Auth::user()->name }}
                        </p>
                    </div>
                    <hr style="margin: 10px 0; border-color: #e0e0e0;">
                    <div style="padding: 10px;">
                        <a href="{{ url('/') }}"
                            style="display: flex; align-items: center; text-decoration: none; color: #333; padding: 5px 0;">
                            <i class="bi bi-house-fill" style="margin-right: 10px;"></i> Halaman Utama
                        </a>
                        @guest
                            <a class="nav-link" href="{{ url('login') }}"
                                style="display: flex; align-items: center; text-decoration: none; color: #333; padding: 5px 0;">
                                <i class="bi bi-box-arrow-in-right" style="margin-right: 10px;"></i> Login
                            </a>
                            <a class="nav-link" href="{{ url('register') }}"
                                style="display: flex; align-items: center; text-decoration: none; color: #333; padding: 5px 0;">
                                <i class="bi bi-r-circle" style="margin-right: 10px;"></i> Register
                            </a>
                        @else
                            @if (Auth::user()->isAdmin)
                                <a href="{{ url('admin/dashboard') }}"
                                    style="display: flex; align-items: center; text-decoration: none; color: #333; padding: 5px 0;">
                                    <i class="bi bi-speedometer2" style="margin-right: 10px;"></i> Admin Dashboard
                                </a>
                            @endif
                            <a class="nav-link text-dark" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                style="display: flex; align-items: center; text-decoration: none; color: #333; padding: 5px 0;">
                                <i class="bi bi-box-arrow-left" style="margin-right: 10px; color: #333;"></i> <span
                                    style="color: black">Logout</span>
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
@push('scripts')
<script>
    $(document).on('click', '.notification-item', function() {
        const notificationId = $(this).data('id');

        $.post(`/notification/${notificationId}/markAsRead`, {
            _token: '{{ csrf_token() }}' // Menambahkan token CSRF untuk keamanan
        }).done(function(response) {
            if (response.success) {
                // Hapus notifikasi dari tampilan atau tandai sebagai dibaca
                $(this).fadeOut();

                // Perbarui jumlah notifikasi
                const badge = $('.notification-icon .badge');
                const count = parseInt(badge.text()) - 1;

                // Jika tidak ada notifikasi, sembunyikan badge
                if (count <= 0) {
                    badge.remove(); // Hapus badge jika jumlah notifikasi 0
                } else {
                    badge.text(count); // Perbarui angka pada badge
                }
            }
        }.bind(this)); // Mengikat `this` ke konteks saat ini
    });
</script>
@endpush
