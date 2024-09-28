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
        
        <nav aria-label="Page navigation example" class="text-center">
            <ul class="pagination justify-content-center">
                <li class="page-item {{ $buku->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $buku->previousPageUrl() }}&kategori={{ request()->get('kategori') }}"
                        aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>

                @for ($i = 1; $i <= $buku->lastPage(); $i++)
                    <li class="page-item {{ $i == $buku->currentPage() ? 'active' : '' }}">
                        <a class="page-link"
                            href="{{ $buku->url($i) }}&kategori={{ request()->get('kategori') }}">{{ $i }}</a>
                    </li>
                @endfor

                <li class="page-item {{ $buku->hasMorePages() ? '' : 'disabled' }}">
                    <a class="page-link" href="{{ $buku->nextPageUrl() }}&kategori={{ request()->get('kategori') }}"
                        aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include Isotope -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.min.js"></script>

    <script>
        $(document).ready(function() {
            // Inisialisasi Isotope pada container dengan item kartu
            var $grid = $('.cards-container').isotope({
                itemSelector: '.card',
                layoutMode: 'fitRows',
                transitionDuration: '0.6s' // Durasi transisi untuk animasi yang halus
            });

            // Filter item saat klik
            $('.event_filter li a').click(function(e) {
                e.preventDefault(); // Cegah aksi default pada tautan anchor

                // Hapus kelas aktif dari semua tautan filter dan tambahkan ke yang diklik
                $('.event_filter li a').removeClass('is_active');
                $(this).addClass('is_active');

                // Ambil nilai filter dari atribut data-filter
                var nilaiFilter = $(this).attr('data-filter');

                // Terapkan filter ke Isotope dengan animasi transisi tunggal
                $grid.isotope({
                    filter: nilaiFilter
                });
            });
        });
    </script>

    {{-- pagination --}}
    <script>
        $(document).ready(function() {
            // Inisialisasi Isotope saat halaman pertama kali dimuat
            var $grid = $('.cards-container').isotope({
                itemSelector: '.card',
                layoutMode: 'fitRows',
                transitionDuration: '0.6s' // Durasi transisi untuk animasi yang halus
            });

            // Fungsi untuk menangani pagination dengan AJAX
            function handlePagination() {
                $('.pagination a').on('click', function(e) {
                    e.preventDefault(); // Cegah aksi default dari anchor tag
                    const url = $(this).attr('href'); // Ambil URL dari pagination

                    // Memuat konten baru dengan AJAX
                    fetch(url)
                        .then(response => response.text())
                        .then(html => {
                            // Ganti konten buku dengan yang baru
                            const newContent = $(html).find('.cards-container').html();
                            $('.cards-container').html(newContent);

                            // Ganti pagination dengan yang baru
                            const newPagination = $(html).find('.pagination').html();
                            $('.pagination').html(newPagination);

                            // Inisialisasi ulang Isotope setelah konten diperbarui
                            $grid.isotope('reloadItems').isotope({
                                itemSelector: '.card',
                                layoutMode: 'fitRows'
                            });

                            // Atur ulang layout untuk memastikan posisi item sesuai
                            $grid.isotope('layout');

                            // Panggil fungsi handlePagination lagi untuk pagination baru
                            handlePagination();

                            // Scroll ke atas setelah konten dimuat
                            window.scrollTo({
                                top: document.querySelector('.container')
                                    .offsetTop, // Scroll ke bagian atas section buku
                                behavior: 'smooth' // Menambahkan efek scroll yang halus
                            });
                        })
                        .catch(error => console.error('Error:', error));
                });
            }

            // Panggil fungsi handlePagination saat halaman pertama kali dimuat
            handlePagination();
        });
    </script>
@endpush
