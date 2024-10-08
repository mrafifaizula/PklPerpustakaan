@extends('layouts.profil')

@section('title', 'Detail Buku')

<style>
    .card-text {
        font-size: 0.9rem;
    }

    .card-title {
        font-size: 1.5rem;
    }

    .card {
        border-radius: 0.5rem;
        overflow: hidden;
    }

    .img-container {
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #f8f9fa;
    }

    .img-container img {
        object-fit: cover;
        width: 100%;
        height: 100%;
    }

    .card-body {
        padding: 2rem;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        font-size: 1.125rem;
        border-radius: 0.375rem;
        flex: 1;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 120px;
        white-space: nowrap;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        color: #ffffff;
    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
        color: #ffffff;
    }

    .button-container {
        display: flex;
        gap: 1rem;
    }


    .comment {
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #fff;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease-in-out;
    }

    .comment:hover {
        transform: translateY(-5px);
    }

    .comment img {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 50%;
        margin-right: 10px;
    }

    .comment strong {
        font-size: 1.1rem;
        color: #007bff;
    }

    .comment .rating i {
        margin-right: 2px;
    }

    .comment .rating .fa-star.text-warning {
        color: #ffc107;
    }

    .comment-text {
        font-size: 1rem;
        color: #333;
        line-height: 1.5;
    }

    .text-muted {
        color: #6c757d !important;
    }

    .d-flex.justify-content-between {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
</style>

@section('content')
    <div class="main-banner" id="top">
        <div class="container my-5">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card shadow-sm">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <div class="img-container">
                                    <img src="{{ file_exists(public_path('images/buku/' . $buku->image_buku)) ? asset('images/buku/' . $buku->image_buku) : asset('assets/img/noimage.png') }}"
                                        class="img-fluid" alt="...">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title text-center mb-4">{{ $buku->judul }}</h5>
                                    <p class="card-text">Code Buku: <span>{{ $buku->code_buku }}</span></p>
                                    <p class="card-text">Stok Buku: <span>{{ $buku->jumlah_buku }}</span></p>
                                    <p class="card-text">Kategori: <span>{{ $buku->kategori->nama_kategori }}</span></p>
                                    <p class="card-text">Nama Penulis: <span>{{ $buku->Penulis->nama_penulis }}</span></p>
                                    <p class="card-text">Nama Penerbit: <span>{{ $buku->Penerbit->nama_penerbit }}</span>
                                    </p>
                                    <p class="card-text">Tahun Terbit: <span>{{ $buku->tahun_terbit }}</span></p>
                                    <p class="card-text">Deskripsi: <span>{{ $buku->desc_buku }}</span></p>
                                    <div class="button-container mt-4">
                                        <a href="{{ url('pinjam/buku', $buku->id) }}" class="btn btn-primary">Pinjam</a>
                                        <a href="{{ url('profil/daftarbuku') }}" class="btn btn-secondary">Kembali</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="testimoni-section mt-5">
                        <h4 class="mb-4">Testimoni</h4>
                        @if ($testimoni->isEmpty())
                            <p class="text-muted">Tidak ada testimoni untuk buku ini.</p>
                        @else
                            @foreach ($testimoni as $item)
                                <div class="comment mb-4 p-4 border rounded shadow-sm bg-light">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $item->user->image_user ? asset('images/user/' . $item->user->image_user) : asset('assets/img/user.jpg') }}" alt="Foto Profil"
                                                class="rounded-circle mr-2"
                                                style="width: 40px; height: 40px; object-fit: cover;">
                                            <strong class="text-primary">{{ $item->user->name }}</strong>
                                            <!-- Ganti name menjadi nama -->
                                        </div>
                                        <span class="text-muted small">{{ $item->created_at->format('d M Y H:i') }}</span>
                                    </div>
                                    <div class="rating mb-2">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i
                                                class="fa fa-star {{ $i <= $item->penilaian ? 'text-warning' : 'text-muted' }}"></i>
                                        @endfor
                                    </div>
                                    <p class="comment-text text-dark">{{ $item->testimoni }}</p>
                                </div>
                            @endforeach
                        @endif
                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection
