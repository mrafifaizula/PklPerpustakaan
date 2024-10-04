<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode OTP Verifikasi</title>
    <style>
        /* Mengatur font umum dan latar belakang */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        /* Container untuk konten utama email */
        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Gaya logo di atas */
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        /* Gaya judul */
        h1 {
            color: #333333;
            text-align: center;
        }

        /* Gaya paragraf */
        p {
            color: #666666;
            font-size: 16px;
            text-align: center;
        }

        /* Gaya untuk kode OTP agar lebih menonjol */
        .otp-code {
            font-size: 32px;
            font-weight: bold;
            color: #007bff;
            margin: 20px 0;
            text-align: center;
        }

        /* Gaya untuk footer email */
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #999999;
            text-align: center;
        }

        /* Responsif untuk tampilan mobile */
        @media only screen and (max-width: 600px) {
            .container {
                padding: 15px;
            }

            .otp-code {
                font-size: 28px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="logo">
            <img src="{{ asset('assets/img/assalaam2.png') }}" alt="Logo Perusahaan" width="100" />
        </div>
        <h1>Halo, {{ $user }}</h1>
        <p>Gunakan kode OTP berikut untuk verifikasi akun Anda:</p>
        <div class="otp-code">{{ $kodeOtp }}</div>
        <p>Harap tidak membagikan kode ini kepada siapapun. Jika Anda tidak meminta kode ini, abaikan email ini.</p>
        <div class="footer">
            <p>&copy; 2024 Smk Assalaam Bandung. Semua hak dilindungi.</p>
        </div>
    </div>
</body>

</html>
