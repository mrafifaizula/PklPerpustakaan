<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Bergabung di Perpustakaan</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f9fc;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            padding: 20px;
            text-align: center;
        }

        .header img {
            max-width: 100px;
            height: auto;
        }

        .content {
            padding: 20px;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        p {
            font-size: 16px;
            color: #333;
            line-height: 1.5;
        }

        .footer {
            text-align: center;
            padding: 10px;
            background: #f1f1f1;
            font-size: 14px;
            color: #777;
        }

        .footer p {
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('assets/img/assalaam2.png') }}" alt="Logo Perpustakaan SMK Assalaam Bandung">
            <h2>Perpustakaan SMK Assalaam Bandung</h2>
        </div>
        <div class="content">
            <h1>Selamat Datang, {{ $user->name }}!</h1>
            <p>Terima kasih telah mendaftar sebagai anggota Perpustakaan SMK Assalaam Bandung melalui akun Google Anda.
            </p>
            <p>Berikut adalah informasi akun Anda:</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p>Anda sekarang dapat mulai meminjam buku dan menikmati semua layanan yang kami tawarkan.</p>
            <p>Jika Anda memiliki pertanyaan atau butuh bantuan, jangan ragu untuk menghubungi kami.</p>
        </div>
        <div class="footer">
            <p>&copy; 2024 Perpustakaan SMK Assalaam Bandung. Semua hak dilindungi.</p>
        </div>
    </div>
</body>

</html>
