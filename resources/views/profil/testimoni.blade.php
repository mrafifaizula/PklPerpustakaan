@extends('layouts.profil')

@section('styles')
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@section('title', 'Ulasan')

<style>
    .form-label {
        font-weight: bold;
    }

    input[type="radio"] {
        margin-right: 5px;
    }

    button[type="submit"] {
        background-color: #28a745;
        border: none;
        color: white;
        padding: 8px 16px;
        font-size: 14px;
        border-radius: 6px;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
    }

    .card {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        margin-top: 40px;
        margin-left: 60px;
        margin-right: 60px;
        padding: 30px;
    }

    .rating .fa-star {
        font-size: 30px;
        cursor: pointer;
        color: #ddd;
    }

    .rating .fa-star.checked {
        color: #ffcc00;
    }

    .mb-3 {
        margin-bottom: 1.5rem;
    }


    <style>.rating .fa-star {
        font-size: 20px;
        cursor: pointer;
        color: #ddd;
    }

    .rating .fa-star.checked {
        color: #ffcc00;
    }
</style>


@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title">Formulir Testimoni</h2>

                <form action="{{ route('testimoni.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_pinjambuku" value="{{ $pinjambuku->id }}">
                    <div class="row mb-2 mt-4">
                        <div class="col-md-6">
                            <label for="">Nama</label>
                            <input type="text" name="name" class="form-control me-2" value="{{ $user->name }}"
                                readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="">Judul Buku</label>
                            <input type="text" name="judul" class="form-control me-2"
                                value="{{ $pinjambuku->buku->judul ?? 'Tidak ada pinjaman' }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-2 mt-4">
                        <div class="col-md-6">
                            <label for="">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $user->email }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="">Nomor Handphone</label>
                            <div class="d-flex">
                                <input type="text" name="tlp" class="form-control me-2" value="{{ $user->tlp }}"
                                    readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2 mt-4">
                        <div class="col-md-12">
                            <label for="testimoni" class="form-label">Testimoni Anda *</label>
                            <textarea name="testimoni" class="form-control" placeholder="Ketik di sini..." rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="row mb-2 mt-4">
                        <div class="col-md-6">
                            <label for="penilaian" class="form-label">Penilaian layanan kami *</label>
                            <div class="rating" id="rating-stars">
                                <i class="fa fa-star" data-value="1"></i>
                                <i class="fa fa-star" data-value="2"></i>
                                <i class="fa fa-star" data-value="3"></i>
                                <i class="fa fa-star" data-value="4"></i>
                                <i class="fa fa-star" data-value="5"></i>
                            </div>
                            <input type="hidden" name="penilaian" id="penilaian" value="0">
                        </div>
                    </div>
                    <!-- Submit Button -->
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-success me-2">Kirim</button>
                        <a href="{{ url('profil/riwayat') }}">
                            <button type="button" class="btn btn-warning">Kembali</button>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Tambahkan Script untuk Interaksi Rating Bintang -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('#rating-stars .fa-star');
            const ratingInput = document.getElementById('penilaian');

            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const ratingValue = this.getAttribute('data-value');
                    ratingInput.value = ratingValue;

                    stars.forEach(s => s.classList.remove('checked'));
                    for (let i = 0; i < ratingValue; i++) {
                        stars[i].classList.add('checked');
                    }
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ratingInput = document.getElementById('penilaian');
            const stars = document.querySelectorAll('#rating-stars .fa-star');
            const currentRating = ratingInput.value;

            // Highlight the stars based on the current rating
            stars.forEach(star => {
                if (star.getAttribute('data-value') <= currentRating) {
                    star.classList.add('checked');
                }
            });

            // Star click event to update rating
            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const ratingValue = this.getAttribute('data-value');
                    ratingInput.value = ratingValue;

                    stars.forEach(s => s.classList.remove('checked'));
                    for (let i = 0; i < ratingValue; i++) {
                        stars[i].classList.add('checked');
                    }
                });
            });
        });
    </script>

@endpush
