<style>
    .profile-placeholder {
        width: 50px;
        height: 50px;
        background-color: #fff;
        /* Warna background putih */
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 14px;
        color: #000;
        /* Warna font */
    }


    .profile-image {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
    }

    .navbar-profile-image {
        width: 30px;
        /* Ukuran dapat disesuaikan */
        height: 30px;
        /* Ukuran dapat disesuaikan */
        object-fit: cover;
        border-radius: 50%;
        /* Jika ingin berbentuk bulat */
    }


    .dropdown-menu {
        padding: 10px;
        border-radius: 12px;
        width: 250px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        border: 1px solid rgba(0, 0, 0, 0.1);
        background-color: #ffffff;
    }

    .dropdown-content {
        text-align: center;
        padding: 15px;
    }

    .profile-image-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 10px;
        background-color: #ffffff;
        /* White background */
        width: 120px;
        height: 120px;
        border-radius: 50%;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .profile-image-container img {
        border-radius: 50%;
        width: 110px;
        height: 110px;
        object-fit: cover;
        background-color: #450000;
        /* Ensure white background behind image */
    }

    .greeting {
        margin: 10px 0 5px 0;
        font-weight: bold;
        font-family: 'Comic Sans MS', cursive, sans-serif;
        color: #333;
        font-size: 1.2rem;
    }

    .dropdown-divider {
        margin: 0;
        border-top: 1px solid rgba(0, 0, 0, 0.1);
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        padding: 10px;
        justify-content: flex-start;
        font-size: 1rem;
        color: #333;
        transition: background-color 0.3s;
    }

    .dropdown-item i {
        margin-right: 10px;
        color: #007bff;
        /* Icon color */
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
    }

    .nav-link img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
    }
</style>

<header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <a href="index.html" class="logo">
                        <h1>Perpus&nbsp;Smk&nbsp;Assalaam</h1>
                    </a>

                    <ul class="nav">
                        <li class="scroll-to-section"><a href="#top" class="active">Home</a></li>
                        <li class="scroll-to-section"><a href="#services">Services</a></li>
                        <li class="scroll-to-section"><a href="#about">About</a></li>
                        <li class="scroll-to-section"><a href="#buku">Buku</a></li>

                        @guest
                            <li class="scroll-to-section"><a href="{{ url('login') }}">Login</a></li>
                            <li class="scroll-to-section"><a href="{{ url('register') }}">Register</a></li>
                        @endguest

                        @auth
                            <li>
                                <a class="nav-link d-flex align-items-center" href="#" role="button"
                                    id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ Auth::user()->image_user ? asset('images/user/' . Auth::user()->image_user) : asset('assets/img/user.jpg') }}"
                                        alt="Profile Image" class="navbar-profile-image">
                                </a>

                                <div class="dropdown-menu dropdown-menu-end shadow-sm rounded"
                                    aria-labelledby="profileDropdown">
                                    <div class="dropdown-content">
                                        <div class="profile-image-container" style="margin-left: 40px">
                                            <img src="{{ Auth::user()->image_user ? asset('images/user/' . Auth::user()->image_user) : asset('assets/img/user.jpg') }}"
                                                alt="Profile Image">
                                        </div>
                                        <div class="greeting">
                                            Hello {{ Auth::user()->name }}
                                        </div>
                                    </div>

                                    <a class="dropdown-item" href="{{ url('profil/anda') }}">
                                        <i class="fas fa-user" style="color: black"></i> <span
                                            style="color: black">Profile</span>
                                    </a>

                                    @if (in_array(Auth::user()->role, ['admin', 'staf']))
                                        <a class="dropdown-item" href="{{ url('admin/dashboard') }}">
                                            <i class="fas fa-cogs" style="color: black"></i> <span style="color: #000">Admin
                                                Dashboard</span>
                                        </a>
                                    @endif

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt" style="color: black"></i> <span
                                            style="color: #000;">Logout</span>
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endauth
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</header>
