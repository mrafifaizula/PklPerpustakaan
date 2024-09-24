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
                                    <img src="{{ file_exists(public_path('images/buku/' . $buku->image_buku)) ? asset('images/buku/' . $buku->image_buku) : asset('assets/img/noimage.png') }}" class="img-fluid"
                                        alt="{{ $buku->judul }}">
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
                                                <label for="tanggal_kembali">Tanggal Kembali</label>
                                                <input type="date" placeholder="Tanggal Kembali"
                                                    class="form-control @error('tanggal_kembali') is-invalid @enderror"
                                                    name="tanggal_kembali" value="{{ date('Y-m-d', strtotime('+1 week')) }}"
                                                    readonly>
                                                @error('tanggal_kembali')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

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
                                                <label for="harga">Harga</label>
                                                <input type="text" id="harga" placeholder="harga Pinjam Buku"
                                                    class="form-control @error('harga') is-invalid @enderror" name="harga"
                                                    value="{{ number_format($buku->harga, 2, ',', '.') }}" readonly>
                                                @error('harga')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="total_harga">Total Harga</label>
                                                <input type="text" id="total_harga" placeholder="Total Harga Pinjam Buku"
                                                    class="form-control @error('total_harga') is-invalid @enderror"
                                                    name="total_harga"
                                                    value="{{ number_format($totalHarga, 2, ',', '.') }}" readonly>
                                                @error('total_harga')
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
    <script>
        function updateTotalHarga() {
            // Ambil nilai harga dan jumlah
            var hargaElement = document.getElementById('harga');
            var jumlahElement = document.getElementById('jumlah');

            // Remove non-numeric characters and parse the price
            var harga = parseFloat(hargaElement.value.replace(/[^0-9,-]+/g, "").replace(',', '.') || 0);
            var jumlah = parseFloat(jumlahElement.value) || 0;

            // Periksa apakah harga dan jumlah adalah angka yang valid
            if (!isNaN(harga) && !isNaN(jumlah)) {
                // Hitung total harga
                var total_harga = harga * jumlah;

                // Simpan total harga tanpa format (number only)
                document.getElementById('total_harga').value = total_harga;

                // Format harga field as Rupiah when displaying
                hargaElement.value = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(harga);
            } else {
                // Jika harga atau jumlah tidak valid, set total_harga kosong
                document.getElementById('total_harga').value = '';
            }
        }

        // Event listeners
        document.getElementById('jumlah').addEventListener('input', updateTotalHarga);
        document.getElementById('harga').addEventListener('input', updateTotalHarga);

        // Initial calculation
        updateTotalHarga();
    </script>
@endpush
