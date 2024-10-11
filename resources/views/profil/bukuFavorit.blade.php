@extends('layouts.profil')

@section('title', 'Daftar Buku')

@section('styles')
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 10px;
        }

        .cards-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            justify-items: center;
            margin-top: 20px;
        }

        .card {
            position: relative;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            text-align: center;
            background-color: #f9f9f9;
            transition: transform 0.3s;
            width: 100%;
            max-width: 270px;
        }


        .card {
            position: relative;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            text-align: center;
            background-color: #f9f9f9;
            transition: transform 0.3s;
            width: 100%;
            max-width: 270px;
            width: 270px;
        }

        .card img {
            width: 100%;
            height: 310px;
            object-fit: cover;
            border-bottom: 2px solid #e0e0e0;
        }

        .card p {
            padding: 5px 10px;
            font-size: 14px;
            font-weight: bold;
            margin: 0;
            color: #333;
            height: 40px;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: #e0e0e0;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
        }

        .heart-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 18px;
            color: red;
            cursor: pointer;
        }

        .card-buttons {
            display: flex;
            justify-content: space-between;
            padding: 5px;
            margin-top: 2px;
        }

        .card-buttons a,
        .card-buttons button {
            width: auto;
            font-size: 14px;
            padding: 6px 16px;
            border: none;
            color: white;
            border-radius: 25px;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-right: 5px;
            background-color: red;
        }

        .card-buttons button:hover {
            background-color: #c00;
        }


        .card-buttons a:last-child,
        .card-buttons button:last-child {
            margin-right: 0;
        }

        .card-buttons a:hover {
            background-color: #0056b3;
        }

        @media (max-width: 1200px) {
            .cards-container {
                grid-template-columns: repeat(3, 1fr);
                /* 3 buku per baris */
            }
        }

        @media (max-width: 992px) {
            .cards-container {
                grid-template-columns: repeat(2, 1fr);
                /* 2 buku per baris */
            }
        }

        @media (max-width: 768px) {
            .cards-container {
                grid-template-columns: 1fr;
                /* 1 buku per baris */
            }
        }
    </style>
@endsection

@section('content')
    <div class="container">
       
        @if ($buku->isEmpty())
            <div class="d-flex m-5 justify-content-center align-items-center">
                <p style="color: white; font-size: 50px; text: bold;"><strong>Tidak Ada Buku Favorit</strong></p>
            </div>
        @else
        <div class="d-flex m-3 justify-content-center align-items-center">
            <p style="color: white; font-size: 40px; text: bold;"><strong>Daftar Buku Favorit</strong></p>
        </div>
            <div class="cards-container m-4">
                @foreach ($buku as $item)
                    <div class="card {{ strtolower($item->kategori->nama_kategori) }}">
                        <a href="{{ url('profil/buku', $item->id) }}">
                            <img src="{{ file_exists(public_path('images/buku/' . $item->image_buku)) ? asset('images/buku/' . $item->image_buku) : asset('assets/img/noimage.png') }}"
                                alt="{{ $item->judul }}">
                        </a>
                        <span class="badge">{{ $item->kategori->nama_kategori }}</span>
                        <i class="bi bi-heart-fill heart-icon" style="color: red"></i>
                        <p>{{ $item->judul }}</p>
                        <div class="card-buttons">
                            <a href="{{ url('pinjam/buku', $item->id) }}" class="btn" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Pinjam Buku"
                                style="background-color: green;">Pinjam</a>
                            <a href="{{ url('profil/buku', $item->id) }}" class="btn" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Detail Buku"
                                style="background-color: rgb(232, 232, 42);">Detail</a>
                            <form action="{{ route('buku.hapusFavorit', $item->id) }}" method="POST"
                                style="display:inline-block;">
                                @csrf
                                <button type="submit" class="btn" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Hapus Favorit">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
@endsection

@push('scripts')
@endpush
