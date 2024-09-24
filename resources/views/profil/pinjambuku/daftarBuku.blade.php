@extends('layouts.profil')

@section('title', 'Daftar Buku')

@section('styles')
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            padding: 20px;
        }

        .event_filter {
            width: 100%;
            text-align: center;
            margin-bottom: 20px;
            list-style: none;
            padding: 0;
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
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .card {
            position: relative;
            width: 260px;
            /* Width of the card */
            height: 410px;
            /* Fixed height for the card */
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            text-align: center;
            background-color: #f9f9f9;
            transition: transform 0.3s;
        }

        .card img {
            width: 100%;
            height: 360px;
            /* Fixed height for the image */
            object-fit: cover;
            /* Ensure the image covers the area without distortion */
            border-bottom: 2px solid #e0e0e0;
        }

        .card p {
            padding: 15px 10px;
            font-size: 18px;
            font-weight: bold;
            margin: 0;
            color: #333;
            height: 50px;
            /* Fixed height for the text area */
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: #e0e0e0;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
        }

    </style>
@endsection

@section('content')
    <div class="container">
        <!-- Filter Section -->
        <ul class="event_filter">
            <li>
                <a class="is_active" data-filter="*">Show All</a>
            </li>
            @foreach ($kategori as $item)
                <li>
                    <a data-filter=".{{ $item->nama_kategori }}">{{ $item->nama_kategori }}</a>
                </li>
            @endforeach
        </ul>

        <!-- Books Section -->
        <div class="cards-container m-4">
            @foreach ($buku as $item)
                <div class="card m-3 {{ $item->kategori->nama_kategori }}">
                    <a href="{{ url('profil/buku', $item->id) }}">
                        <img src="{{ file_exists(public_path('images/buku/' . $item->image_buku)) ? asset('images/buku/' . $item->image_buku) : asset('assets/img/noimage.png') }}"
                            alt="{{ $item->judul }}">
                    </a>
                    <span class="badge">{{ $item->kategori->nama_kategori }}</span>
                    <p>{{ $item->judul }}</p>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include Isotope -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Isotope on the container with the card items
            var $grid = $('.cards-container').isotope({
                itemSelector: '.card',
                layoutMode: 'fitRows',
                transitionDuration: '0.6s', // Set the transition duration for a smooth animation
                hiddenStyle: {
                    opacity: 0,
                    transform: 'scale(0.8)' // Shrinks the hidden items
                },
                visibleStyle: {
                    opacity: 1,
                    transform: 'scale(1)' // Enlarges the visible items
                }
            });

            // Filter items on click
            $('.event_filter li a').click(function(e) {
                e.preventDefault(); // Prevent default action for anchor links

                // Remove active class from all filter links and add to the clicked one
                $('.event_filter li a').removeClass('is_active');
                $(this).addClass('is_active');

                // Get the filter value from data-filter attribute
                var filterValue = $(this).attr('data-filter');

                // Apply the filter to Isotope
                $grid.isotope({
                    filter: filterValue
                });
            });
        });
    </script>
@endpush
