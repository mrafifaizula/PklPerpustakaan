<h1>Pengembalian Buku Disetujui</h1>
<p>Halo,</p>
<p>Pengembalian buku berikut telah disetujui:</p>
<p>Judul Buku: {{ $pinjamBuku->buku->judul }}</p>
<p>Nama Peminjam: {{ $pinjamBuku->user->name }}</p>
<p>Jumlah Buku Dipinjam: {{ $pinjamBuku->jumlah}}</p>
<p>Jumlah Tanggal Pinjam: {{ $pinjamBuku->tanggal_pinjambuku}}</p>
<p>Batas Pengembalian: {{ $pinjamBuku->batas_pengembalian}}</p>
<p>Status: dikembalikan</p>

