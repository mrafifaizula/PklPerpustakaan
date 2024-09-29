@extends('layouts.profil')

@section('title', 'Peminjaman Buku')

<style>
    .card-text {
        font-size: 1rem;
    }

    .card-title {
        font-size: 1.75rem;
    }

    .card {
        border-radius: 0.75rem;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .img-container {
        width: 100%;
        height: 460px;
        /* Fixed height for better layout */
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #f8f9fa;
        overflow: hidden;
    }

    .img-container img {
        object-fit: cover;
        width: 100%;
        height: 100%;
    }

    .card-body {
        padding: 2.5rem;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        font-size: 1.125rem;
        border-radius: 0.375rem;
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 120px;
        white-space: nowrap;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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
        gap: 1.5rem;
        margin-top: 1.5rem;
    }

    .form-control {
        font-size: 1rem;
        border-radius: 0.375rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .form-control:focus {
        box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.25);
        border-color: #007bff;
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
                                        class="img-fluid" alt="{{ $buku->judul }}">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <form action="{{ route('pinjambuku.store') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf

                                        <input type="hidden" name="id_user" value="{{ Auth::user()->id }}">
                                        <input type="hidden" name="id_buku" value="{{ $buku->id }}">

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="name">Name</label>
                                                <input type="text" placeholder="Name Pinjam Buku"
                                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                                    value="{{ Auth::user()->name }}" readonly>
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label for="judul">Judul</label>
                                                <input type="text" placeholder="Judul Pinjam Buku"
                                                    class="form-control @error('judul') is-invalid @enderror" name="judul"
                                                    value="{{ $buku->judul }}" readonly>
                                                @error('judul')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="tanggal_pinjambuku">Tanggal Pinjam</label>
                                                <input type="date" placeholder="Tanggal Pinjam"
                                                    class="form-control @error('tanggal_pinjambuku') is-invalid @enderror"
                                                    name="tanggal_pinjambuku" value="{{ date('Y-m-d') }}" readonly>
                                                @error('tanggal_pinjambuku')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label for="batas_pengembalian">Batas Pengembalian</label>
                                                <input type="date" placeholder="Tanggal Kembali"
                                                    class="form-control @error('batas_pengembalian') is-invalid @enderror"
                                                    name="batas_pengembalian"
                                                    value="{{ \Carbon\Carbon::now()->addDays(7)->format('Y-m-d') }}"
                                                    readonly>
                                                @error('batas_pengembalian')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="jumlah">Jumlah</label>
                                                <input type="number" id="jumlah" placeholder="Jumlah Buku"
                                                    class="form-control @error('jumlah') is-invalid @enderror"
                                                    name="jumlah" value="1" min="1">
                                                @error('jumlah')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label for="status">Status</label>
                                                <select name="status"
                                                    class="form-control @error('status') is-invalid @enderror" required>
                                                    <option value="Pinjam" selected>Pinjam</option>
                                                </select>
                                                @error('status')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="button-container">
                                            <button class="btn btn-sm btn-primary" type="submit">Pinjam</button>
                                            <button class="btn btn-sm btn-warning" type="reset">Reset</button>
                                            <a href="{{ url()->previous() }}" class="btn btn-sm btn-secondary">
                                                Back
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
@endpush
