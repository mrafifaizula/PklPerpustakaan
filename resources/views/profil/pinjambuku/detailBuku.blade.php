@extends('layouts.profil')

@section('title', 'Detail Buku')

<style>
    .card-text{
        font-size: 0.9rem;
    }

    .card-title{
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
        padding: 0.75rem 1.5rem; /* Adjust padding for larger buttons */
        font-size: 1.125rem; /* Adjust font size for readability */
        border-radius: 0.375rem; /* Slightly rounded corners */
        flex: 1; /* Ensure buttons grow to take up available space */
        text-align: center; /* Center text inside the button */
        display: flex; /* Use flexbox for alignment */
        align-items: center; /* Center text vertically */
        justify-content: center; /* Center text horizontally */
        min-width: 120px; /* Minimum width to prevent shrinking */
        white-space: nowrap; /* Prevent text from wrapping */
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        color: #ffffff; /* Ensure text is readable */
    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
        color: #ffffff; /* Ensure text is readable */
    }

    .button-container {
        display: flex;
        gap: 1rem; /* Space between buttons */
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
                                    <img src="{{ file_exists(public_path('images/buku/' . $buku->image_buku)) ? asset('images/buku/' . $buku->image_buku) : asset('assets/img/noimage.png') }}" class="img-fluid" alt="...">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title text-center mb-4">{{$buku->judul}}</h5>
                                    <p class="card-text">Code Buku: <span>{{$buku->code_buku}}</span></p>
                                    <p class="card-text">Stok Buku: <span>{{$buku->jumlah_buku}}</span></p>
                                    <p class="card-text">Harga: <span>{{ number_format($buku->harga, 2, ',', '.') }}</span></p>
                                    <p class="card-text">Kategori: <span>{{$buku->kategori->nama_kategori}}</span></p>
                                    <p class="card-text">Nama Penulis: <span>{{$buku->Penulis->nama_penulis}}</span></p>
                                    <p class="card-text">Nama Penerbit: <span>{{$buku->Penerbit->nama_penerbit}}</span></p>
                                    <p class="card-text">Tahun Terbit: <span>{{$buku->tahun_terbit}}</span></p>
                                    <p class="card-text">Deskripsi: <span>{{$buku->desc_buku}}</span></p>
                                    <div class="button-container mt-4">
                                        <a href="{{ url('pinjam/buku', $buku->id) }}" class="btn btn-primary">Pinjam</a>
                                        <a href="{{ url('profil/daftarbuku')}}" class="btn btn-secondary">Kembali</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
