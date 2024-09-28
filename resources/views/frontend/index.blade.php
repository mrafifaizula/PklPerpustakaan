@extends('layouts.frontend')

@section('title', 'Home')


<style>
    .rating .fa-star {
        color: white;
       
        /* Color for unfilled stars */
    }

    .rating .fa-star.checked {
        color: yellow;
        /* Color for filled stars */
    }
</style>

@section('content')
    <div class="main-banner" id="top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="owl-carousel owl-banner">
                        <div class="item item-1">
                            <div class="header-text">
                                <span class="category">Our Courses</span>
                                <h2>With Scholar Teachers, Everything Is Easier</h2>
                                <p>Scholar is free CSS template designed by TemplateMo for online educational related
                                    websites. This layout is based on the famous Bootstrap v5.3.0 framework.</p>
                                <div class="buttons">
                                    <div class="main-button">
                                        <a href="#">Request Demo</a>
                                    </div>
                                    <div class="icon-button">
                                        <a href="#"><i class="fa fa-play"></i> What's Scholar?</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item item-2">
                            <div class="header-text">
                                <span class="category">Best Result</span>
                                <h2>Get the best result out of your effort</h2>
                                <p>You are allowed to use this template for any educational or commercial purpose. You are
                                    not allowed to re-distribute the template ZIP file on any other website.</p>
                                <div class="buttons">
                                    <div class="main-button">
                                        <a href="#">Request Demo</a>
                                    </div>
                                    <div class="icon-button">
                                        <a href="#"><i class="fa fa-play"></i> What's the best result?</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item item-3">
                            <div class="header-text">
                                <span class="category">Online Learning</span>
                                <h2>Online Learning helps you save the time</h2>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod temporious
                                    incididunt ut labore et dolore magna aliqua suspendisse.</p>
                                <div class="buttons">
                                    <div class="main-button">
                                        <a href="#">Request Demo</a>
                                    </div>
                                    <div class="icon-button">
                                        <a href="#"><i class="fa fa-play"></i> What's Online Course?</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="services section" id="services">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="service-item">
                        <div class="icon">
                            <img src="{{ asset('front/assets/images/service-01.png') }}" alt="online degrees">
                        </div>
                        <div class="main-content">
                            <h4>Koleksi Referensi</h4>
                            <p>Buku-buku seperti ensiklopedia atau kamus yang tidak dipinjamkan dan hanya dapat digunakan di
                                dalam perpustakaan.</p>
                            {{-- <div class="main-button">
                                <a href="#">Read More</a>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-item">
                        <div class="icon">
                            <img src="{{ asset('front/assets/images/service-02.png') }}" alt="short courses">
                        </div>
                        <div class="main-content">
                            <h4>Akses Digital</h4>
                            <p>Kemampuan untuk mengakses koleksi perpustakaan secara online, termasuk e-book, jurnal
                                elektronik, dan database.</p>
                            {{-- <div class="main-button">
                                <a href="#">Read More</a>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-item">
                        <div class="icon">
                            <img src="{{ asset('front/assets/images/service-03.png') }}" alt="web experts">
                        </div>
                        <div class="main-content">
                            <h4>Laporan Peminjaman</h4>
                            <p>Dokumen atau data yang berisi informasi mengenai buku-buku yang telah dipinjam dan oleh
                                siapa.</p>
                            {{-- <div class="main-button">
                                <a href="#">Read More</a>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section about-us" id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 lg-1">
                    <div class="accordion" id="accordionExample">
                        <img src="{{ asset('assets/img/assalaam.png') }}" alt=""
                            style="height: 400px; border-radius: 5%">
                    </div>
                </div>
                <div class="col-lg-5 align-self-center">
                    <div class="section-heading">
                        <h6>About Us</h6>
                        <h2>Perpustakaan Smk Assalaam</h2>
                        <p>Perpustakaan SMK Assalaam Bandung merupakan fasilitas yang disediakan oleh sekolah untuk
                            mendukung kegiatan belajar mengajar siswa. Sebagai bagian dari lembaga pendidikan, perpustakaan
                            ini memiliki peran penting dalam menyediakan sumber daya informasi yang dibutuhkan oleh siswa
                            dan guru, baik dalam bentuk buku cetak, materi digital, maupun referensi lainnya.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="section courses" id="buku">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="section-heading">
                        <h2>Daftar Buku</h2>
                    </div>
                </div>
            </div>
            <ul class="event_filter">
                <li>
                    <a class="is_active" data-filter="*">Tampilkan Semua</a>
                </li>
                @foreach ($kategori as $item)
                    <li>
                        <a data-filter=".{{ $item->nama_kategori }}">{{ $item->nama_kategori }}</a>
                    </li>
                @endforeach
            </ul>
            <div class="row event_box">
                @foreach ($buku as $item)
                    <div class="col-lg-4 col-md-6 align-self-center mb-30 event_outer {{ $item->Kategori->nama_kategori }}">
                        <div class="events_item">
                            <div class="thumb"
                                style="width: 100%; padding-top: 110%; position: relative; overflow: hidden;">
                                <a href="{{ url('buku', $item->id) }}">
                                    <img src="{{ file_exists(public_path('images/buku/' . $item->image_buku)) ? asset('images/buku/' . $item->image_buku) : asset('assets/img/noimage.png') }}"
                                        alt="{{ $item->judul }}"
                                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
                                </a>
                                <span class="category">{{ $item->Kategori->nama_kategori }}</span>
                            </div>
                            <div class="down-content">
                                <h4>{{ $item->judul }}</h4>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
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

    </section>

    <div class="section fun-facts" id="testimoni">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="wrapper">
                        <div class="row">
                            <div class="col-lg-3 col-md-6">
                                <div class="counter">
                                    <h2 class="timer count-title count-number"
                                        data-to="{{ \App\Models\User::where('role', 'user')->count() }}"
                                        data-speed="1000">
                                    </h2>
                                    <p class="count-text ">Jumlah Pengguna</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="counter">
                                    <h2 class="timer count-title count-number" data-to="{{ \App\Models\Buku::count() }}"
                                        data-speed="1000"></h2>
                                    <p class="count-text ">Total Buku</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="counter end">
                                    <h2 class="timer count-title count-number"
                                        data-to="{{ \App\Models\Kategori::count() }}" data-speed="1000"></h2>
                                    <p class="count-text ">Kategori</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="counter">
                                    <h2 class="timer count-title count-number"
                                        data-to="{{ \App\Models\Pinjambuku::where('status', 'diterima')->count() }}"
                                        data-speed="1000"></h2>
                                    <p class="count-text ">Total Buku Dipinjam</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section testimonials">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="owl-carousel owl-testimonials">
                        @foreach ($testimoni as $item)
                            <div class="item">
                                <h4>{{ $item->pinjambuku->buku->judul }}</h4>
                                <p>{{ $item->testimoni }}</p>
                                <div class="author">
                                    <img src="{{ $item->user->image_user ? asset('images/user/' . $item->user->image_user) : asset('assets/img/user.jpg') }}"
                                        alt=""
                                        style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;">
                                    <h4>{{ $item->user->name }}</h4>
                                    <div class="col-md-12 mt-2">
                                        <div class="rating" style="color: yellow;">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fa fa-star {{ $i <= $item->penilaian ? 'checked' : '' }}"></i>
                                            @endfor
                                        </div>
                                        <input type="hidden" name="penilaian" value="{{ $item->penilaian }}">
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>

                <div class="col-lg-5 align-self-center">
                    <div class="section-heading">
                        <h6>TESTIMONIALS</h6>
                        <h2>Apa yang mereka katakan tentang kita?</h2>
                        <p>Periksa artikel berita atau laporan yang mungkin telah diterbitkan mengenai aktivitas atau
                            pencapaian perpustakaan.</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="contact-us section" id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-6  align-self-center">
                    <div class="section-heading">
                        <h6>Contact Us</h6>
                        <h2>Jangan ragu untuk menghubungi kami kapan saja</h2>
                        <p>Kami di sini untuk membantu! Jangan ragu untuk menghubungi kami jika ada pertanyaan atau
                            pertanyaan tentang layanan perpustakaan kami.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="contact-us-content">
                        <form action="{{ route('kontak.store') }}" method="POST" id="contact-form">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <fieldset>
                                        <input type="text" placeholder="Your Name" class="form-control"
                                            name="name" value="{{ auth()->check() ? auth()->user()->name : '' }}"
                                            readonly>
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <fieldset>
                                        <input type="text" placeholder="Your Email" class="form-control"
                                            name="email" value="{{ auth()->check() ? auth()->user()->email : '' }}"
                                            readonly>
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <fieldset>
                                        <textarea class="form-control @error('pesan') is-invalid @enderror" name="pesan" placeholder="Your Message"></textarea>
                                        @error('pesan')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <fieldset>
                                        <button type="submit" id="form-submit" class="orange-button">Send Message
                                            Now</button>
                                    </fieldset>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    document.querySelectorAll('.pagination a').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault(); // Mencegah default behavior dari anchor tag
            const url = this.getAttribute('href'); // Ambil URL

            // Memuat konten baru dengan AJAX
            fetch(url)
                .then(response => response.text())
                .then(html => {
                    // Misalkan Anda mengganti konten dengan yang baru
                    document.querySelector('.event_box').innerHTML = html;

                    // Scroll ke atas atau ke posisi tertentu
                    window.scrollTo({
                        top: document.querySelector('#buku')
                            .offsetTop, // Scroll ke bagian atas section buku
                        behavior: 'smooth' // Menambahkan efek scroll yang halus
                    });
                })
                .catch(error => console.error('Error:', error));
        });
    });
</script>

<script>
    // Initialize Isotope
    var $grid = $('.event_box').isotope({
        itemSelector: '.event_outer',
        layoutMode: 'fitRows'
    });

    // Filter items on click
    $('.event_filter a').click(function() {
        $('.event_filter a').removeClass('is_active');
        $(this).addClass('is_active');

        var filterValue = $(this).attr('data-filter');
        $grid.isotope({
            filter: filterValue
        });

        return false;
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if ({{ session('scrollTo') === 'contact' ? 'true' : 'false' }}) {
            document.querySelector('#contact').scrollIntoView({
                behavior: 'smooth'
            });
        }
    });
</script>
