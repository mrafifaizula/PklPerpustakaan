@extends('layouts.profil')

@section('title', 'Daftar Buku')

@section('styles')
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 10px 20px;
            padding-left: 45px;
        }

        .event_filter {
            margin: 0;
            padding: 0;
            list-style: none;
            text-align: center;
        }

        .event_filter li {
            display: inline-block;
            margin: 6px;
        }

        .event_filter li a {
            display: inline-block;
            background-color: #f3f3f3;
            border: none;
            border-radius: 20px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            color: #000;
            transition: background-color 0.3s, color 0.3s;
        }

        .event_filter li a:hover {
            background-color: #e0e0e0;
        }

        .event_filter li a.is_active {
            background-color: #333;
            color: #fff;
            font-weight: bold;
        }

        .cards-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin: 20px 0;
            width: 100%;
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
            margin: 0 auto;
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
            }
        }

        @media (max-width: 992px) {
            .cards-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .cards-container {
                grid-template-columns: repeat(1, 1fr);
            }
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <ul class="event_filter">
            <li>
                <a class="is_active" href="{{ route('daftarbuku') }}" data-filter="*">Show All</a>
            </li>
            @foreach ($kategoriList as $item)
                <li>
                    <a href="{{ route('daftarbuku', ['kategori' => $item->nama_kategori]) }}"
                        data-filter=".{{ strtolower($item->nama_kategori) }}">{{ $item->nama_kategori }}</a>
                </li>
            @endforeach
        </ul>

        <div class="cards-container m-4">
            @foreach ($buku as $item)
                <div class="card m-3 {{ strtolower($item->kategori->nama_kategori) }}">
                    <a href="{{ url('profil/buku', $item->id) }}">
                        <img src="{{ file_exists(public_path('images/buku/' . $item->image_buku)) ? asset('images/buku/' . $item->image_buku) : asset('assets/img/noimage.png') }}"
                            alt="{{ $item->judul }}">
                    </a>
                    <span class="badge">{{ $item->kategori->nama_kategori }}</span>
                    <i class="bi bi-heart-fill heart-icon"
                        style="color: {{ in_array($item->id, $favoritBukuIds) ? 'red' : 'gray' }};"></i>
                    <p>{{ $item->judul }}</p>
                    <div class="card-buttons">
                        <a href="{{ url('pinjam/buku', $item->id) }}" class="btn" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Pinjam Buku"
                            style="background-color: green;">Pinjam</a>
                        <a href="{{ url('profil/buku', $item->id) }}" class="btn" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Detail Buku"
                            style="background-color: rgb(232, 232, 42);">Detail</a>
                        <form action="{{ route('buku.favorit', $item->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            <button type="submit" class="btn" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tambah Favorit">
                                Favorit
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.min.js"></script>

    <script>
        $(document).ready(function() {
            var $grid = $('.cards-container').isotope({
                itemSelector: '.card',
                layoutMode: 'fitRows'
            });

            $('.event_filter li a').click(function(e) {
                e.preventDefault();

                $('.event_filter li a').removeClass('is_active');
                $(this).addClass('is_active');

                var nilaiFilter = $(this).attr('data-filter');

                $grid.isotope({
                    filter: nilaiFilter,
                });

                $grid.isotope('layout');
            });
        });
    </script>
@endpush
