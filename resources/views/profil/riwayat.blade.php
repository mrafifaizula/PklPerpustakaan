@extends('layouts.profil')

@section('title', 'Riwayat')

<style>
    .container {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-start;
        align-items: flex-start;
        gap: 20px;
        margin: 20px 0;
        padding: 20px 0;
        max-width: 1000px;
        margin-left: auto;
        margin-right: auto;
        overflow-x: hidden;
    }

    .card {
        width: 218px;
        /* Lebar kartu */
        height: auto;
        /* Tinggi kartu menyesuaikan konten */
        border-radius: 10px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.12);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background-color: white;
        overflow: hidden;
        padding: 0;
        position: relative;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0px 12px 24px rgba(0, 0, 0, 0.25);
    }

    .image {
        height: 60%;
        /* Tinggi bagian gambar disesuaikan */
        display: flex;
        justify-content: center;
        align-items: center;
        text-decoration: none;
        border-bottom: 1px solid #ddd;
    }

    .image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 10px 10px 0 0;
    }

    .status-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background-color: rgba(0, 0, 0, 0.6);
        color: white;
        padding: 5px 10px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: bold;
    }

    .title {
        text-align: center;
        font-size: 14px;
        padding: 8px;
        color: #333;
        background-color: #f8f9fa;
    }

    .title p {
        margin: 0;
        font-size: 14px;
        font-weight: bold;
    }

    .foote {
        height: 50px;
        display: flex;
        justify-content: space-evenly;
        align-items: center;
        padding: 10px;
        background-color: #ffffff;
        border-top: 1px solid #ddd;
    }

    .button {
        width: 70px;
        height: 30px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 50px;
        transition: background-color 0.2s ease, transform 0.2s ease;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        font-size: 12px;
        box-shadow: 0 4px 8px rgba(0, 123, 255, 0.2);
    }

    .button:hover {
        background-color: #0056b3;
        transform: translateY(-2px);
    }

</style>

@section('content')
    <div class="container">
        @foreach ($pinjambuku as $item)
            <div class="card">
                <div class="status-badge">
                    @if ($item->status == 'ditolak')
                        Ditolak
                    @elseif($item->status == 'dikembalikan')
                        Dikembalikan
                    @else
                        {{ ucfirst($item->status) }}
                    @endif
                </div>
                <a href="#" class="image">
                    <img src="{{ file_exists(public_path('images/buku/' . $item->buku->image_buku)) ? asset('images/buku/' . $item->buku->image_buku) : asset('assets/img/noimage.png') }}" alt="{{ $item->buku->judul }}">
                </a>
                <div class="title">
                    <p>{{ $item->buku->judul }}</p>
                </div>
                <div class="foote">
                    <a href="{{ url('profil/testimoni', $item->id) }}">
                        <div class="button">Testimoni</div>
                    </a>
                    <div class="button" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $item->id }}">Detail
                    </div>
                </div>
            </div>
            <div class="modal fade" id="exampleModal{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">
                                Riwayat
                            </h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <label for="">Nama</label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ $item->user->name }}" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Judul</label>
                                        <input type="text" class="form-control" name="judul"
                                            value="{{ $item->buku->judul }}" disabled>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <label for="">Jumlah</label>
                                        <input type="text" class="form-control" name="jumlah_buku"
                                            value="{{ $item->jumlah }}" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Kode Buku</label>
                                        <input type="text" class="form-control" name="code_buku"
                                            value="{{ $item->buku->code_buku }}" disabled>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <label for="">Tanggal Pinjam</label>
                                        <input type="text" class="form-control" name="tanggal_pinjambuku"
                                            value="{{ $item->tanggal_pinjambuku }}" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Batas Pengembalian</label>
                                        <input type="text" class="form-control" name="batas_pengembalian"
                                            value="{{ $item->batas_pengembalian }}" disabled>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-12">
                                        <label for="">Status</label>
                                        <input type="text" class="form-control" name="status"
                                            value="{{ $item->status }}" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Kembali</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
