<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman Buku Disetujui</title>
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

        .warning {
            background-color: #fff3cd;
            color: #856404;
            border-left: 4px solid #ffeeba;
            padding: 10px;
            margin: 20px 0;
            border-radius: 5px;
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

        .status {
            font-weight: bold;
            color: #28a745;
            /* Warna hijau untuk status */
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
            <h1>Peminjaman Buku Disetujui</h1>
            <p>Halo, {{ $pinjamBuku->user->name }}</p>
            <p>Peminjaman buku berikut telah disetujui:</p>
            <p>Judul Buku: <strong>{{ $pinjamBuku->buku->judul }}</strong></p>
            <p>Jumlah Buku Dipinjam: <strong>{{ $pinjamBuku->jumlah }}</strong></p>
            <p>Tanggal Pinjam: <strong>{{ $pinjamBuku->tanggal_pinjambuku }}</strong></p>
            <p>Batas Pengembalian: <strong>{{ $pinjamBuku->batas_pengembalian }}</strong></p>
            <p>Status: <span class="status">Diterima</span></p>

            <div class="warning">
                <strong>Peringatan:</strong> Pastikan Anda mengembalikan buku tepat waktu untuk menghindari denda. Jika
                ada pertanyaan, silakan hubungi perpustakaan.
            </div>
        </div>
        <div class="footer">
            <p>&copy; 2024 Perpustakaan SMK Assalaam Bandung. Semua hak dilindungi.</p>
        </div>
    </div>
</body>

</html>
