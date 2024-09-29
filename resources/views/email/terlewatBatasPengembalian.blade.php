<p>Halo {{ $peminjaman->user->name }},</p>
<p>Buku yang kamu pinjam dengan judul <strong>{{ $peminjaman->buku->judul }}</strong> sudah melewati batas pengembalian pada {{ $peminjaman->batas_pengembalian }}.</p>
<p>Harap segera mengembalikan buku ke perpustakaan.</p>
