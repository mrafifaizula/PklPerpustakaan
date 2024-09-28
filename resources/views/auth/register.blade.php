<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/assalaam2.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/assalaam2.png') }}">
    <title>Perpustakaan Smk Assalaam</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style media="screen">
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #080710;
            overflow: hidden;
            height: 100%;
        }

        .wave {
            background: rgb(255 255 255 / 25%);
            border-radius: 1000% 1000% 0 0;
            position: fixed;
            width: 200%;
            height: 12em;
            animation: wave 10s -3s linear infinite;
            opacity: 0.8;
            bottom: 0;
            left: 0;
            z-index: -1;
        }

        @keyframes wave {
            2% {
                transform: translateX(1);
            }

            25% {
                transform: translateX(-25%);
            }

            50% {
                transform: translateX(-50%);
            }

            75% {
                transform: translateX(-25%);
            }

            100% {
                transform: translateX(1);
            }
        }

        .background {
            width: 500px;
            /* Increased width */
            height: auto;
            position: absolute;
            transform: translate(-50%, -50%);
            left: 50%;
            top: 50%;
        }

        form {
            height: auto;
            /* Allow auto height */
            width: 500px;
            /* Increased width */
            background-color: rgba(255, 255, 255, 0.13);
            position: absolute;
            transform: translate(-50%, -50%);
            top: 50%;
            left: 50%;
            border-radius: 10px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 40px rgba(8, 7, 16, 0.6);
            padding: 50px 35px;
        }

        form * {
            font-family: 'Poppins', sans-serif;
            color: #ffffff;
            outline: none;
            border: none;
        }

        form h3 {
            font-size: 32px;
            font-weight: 500;
            text-align: center;
        }

        label {
            display: block;
            margin-top: 20px;
            font-size: 16px;
            font-weight: 500;
        }

        .row input {
            display: block;
            height: 50px;
            width: 100%;
            background-color: rgba(255, 255, 255, 0.07);
            border-radius: 3px;
            padding: 0 10px;
            margin-top: 8px;
            font-size: 14px;
            font-weight: 300;
        }

        button {
            margin-top: 30px;
            width: 100%;
            background-color: #ffffff;
            color: #080710;
            padding: 15px 0;
            font-size: 18px;
            font-weight: 600;
            border-radius: 5px;
            cursor: pointer;
        }

        .social {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }

        .social div {
            width: 48%;
            background-color: rgba(255, 255, 255, 0.27);
            color: #eaf0fb;
            text-align: center;
            padding: 10px;
            border-radius: 3px;
            cursor: pointer;
        }

        .social div:hover {
            background-color: rgba(255, 255, 255, 0.47);
        }
    </style>
</head>

<body>
    <div class="wave"></div>
    <div class="background"></div>
    <form role="form" action="{{ route('register') }}" method="POST">
        @csrf
        <h3>Register</h3>
        <div class="row">
            <div class="col-6">
                <label for="name">Nama</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                    name="name" placeholder="Nama" autofocus />
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-6">
                <label for="email">Email</label>
                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                    name="email" placeholder="Email" />
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <label for="password">Password</label>
                <input type="password" id="password" class="form-control @error('password') is-invalid @enderror"
                    name="password"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="password" />
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-6">
                <label for="password_confirmation">Password confirmation</label>
                <input type="password" id="password_confirmation" class="form-control" name="password_confirmation"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="password_confirmation" />
            </div>
        </div>

        <button type="submit">Register</button>

        <div class="social">
            <div class="fb"><i class="fab fa-facebook-f"></i> Facebook</div>
            <div class="google"><i class="fab fa-google"></i> Google</div>
        </div>

        <p class="text-sm mt-3 mb-0" >Sudah memiliki akun? <a href="{{ route('login') }}" style="color:  #ff512f">Login</a></p>
    </form>
</body>

</html>
