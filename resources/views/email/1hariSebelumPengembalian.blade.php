<p>Halo {{ $peminjaman->user->name }},</p>

<p>Ini adalah pengingat bahwa buku yang kamu pinjam dengan judul <strong>{{ $peminjaman->buku->judul }}</strong> akan mencapai batas pengembalian besok ({{ $peminjaman->batas_pengembalian }}).</p>

<p>Pastikan untuk mengembalikan buku tepat waktu untuk menghindari denda keterlambatan.</p>

<p>Terima kasih,</p>
<p>Perpustakaan Kami</p>
