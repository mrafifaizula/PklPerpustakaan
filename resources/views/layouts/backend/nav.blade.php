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
        min-width: 150px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
        border-radius: 5px;
        z-index: 9999; 
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
   
</style>
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur"
    data-scroll="false">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                {{-- <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Perpustakaan</a></li> --}}
                <li class="breadcrumb-item text-sm text-white active" aria-current="page">Perpustakaan</li>
            </ol>
            <h6 class="font-weight-bolder text-white mb-0">SMK ASSALAAM BANDUNG</h6>
        </nav>
        
        <div class="profile-menu">
            <button class="profile-button">
                <img src="{{ Auth::user()->image_user ? asset('images/user/' . Auth::user()->image_user) : asset('assets/img/user.jpg') }}" alt="User Image">
            </button>

            <div class="dropdown-content" style="width: 200px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-radius: 10px; overflow: hidden; background-color: #fff;">
                <div style="padding: 20px; text-align: center;">
                    <div style="width: 110px; height: 110px; background-color: #f1f1f1; border-radius: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center;">
                        <img src="{{ Auth::user()->image_user ? asset('images/user/' . Auth::user()->image_user) : asset('assets/img/user.jpg') }}" alt="Profile Image" style="border-radius: 50%; width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <p style="margin: 15px 0 0 0; font-weight: bold; font-family: 'Comic Sans MS', cursive, sans-serif; color: #1f1f1f;">Hello {{ Auth::user()->name }}</p>
                </div>
                <hr style="margin: 10px 0; border-color: #e0e0e0;">
                <div style="padding: 10px;">
                    <a href="{{url('/')}}" style="display: flex; align-items: center; text-decoration: none; color: #333; padding: 5px 0;">
                        <i class="bi bi-house-fill" style="margin-right: 10px;"></i> Home
                    </a>
                    @guest
                    <a class="nav-link" href="{{ url('login') }}" style="display: flex; align-items: center; text-decoration: none; color: #333; padding: 5px 0;">
                        <i class="bi bi-box-arrow-in-right" style="margin-right: 10px;"></i> Login
                    </a>
                    <a class="nav-link" href="{{ url('register') }}" style="display: flex; align-items: center; text-decoration: none; color: #333; padding: 5px 0;">
                        <i class="bi bi-r-circle" style="margin-right: 10px;"></i> Register
                    </a>
                    @else
                    <a class="nav-link text-dart" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="display: flex; align-items: center; text-decoration: none; color: #333; padding: 5px 0;" style="color: #333">
                        <i class="bi bi-box-arrow-left" style="margin-right: 10px; color: #333"></i> <span style="color: #333">Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    @endguest
                </div>
            </div>
            
        </div>
    </div>
</nav>
