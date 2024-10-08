@extends('layouts.backend')

@section('title', 'Dashboard Admin')

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endsection

<style>
    .dataTables_length label {
        display: none;
    }
</style>

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Pengguna</p>
                                    <h5 class="font-weight-bolder">
                                        {{ $jmlUser }}
                                    </h5>
                                    <p class="mb-0">
                                        Terbaru
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-secondary shadow-secondary text-center rounded-circle"
                                    style="position: relative; height: 50px; width: 50px;">
                                    <i class="bi bi-people-fill text-lg opacity-10"
                                        style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);"
                                        aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Buku Dipinjam</p>
                                    <h5 class="font-weight-bolder">
                                        {{ $bukuYangDipinjam }}
                                    </h5>
                                    <p class="mb-0">
                                        Terbaru
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-info shadow-info text-center rounded-circle"
                                    style="position: relative; height: 50px; width: 50px;">
                                    <i class="bi bi-book-half text-lg opacity-10"
                                        style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);"
                                        aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Data Buku</p>
                                    <h5 class="font-weight-bolder">
                                        {{ \App\Models\Buku::count() }}
                                    </h5>
                                    <p class="mb-0">
                                        Terbaru
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle"
                                    style="position: relative; height: 50px; width: 50px;">
                                    <i class="bi bi-book text-lg opacity-10"
                                        style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);"
                                        aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Data Kategori</p>
                                    <h5 class="font-weight-bolder">
                                        {{ \App\Models\Kategori::count() }}
                                    </h5>
                                    <p class="mb-0">
                                        Terbaru
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle"
                                    style="position: relative; height: 50px; width: 50px;">
                                    <i class="bi bi-house text-lg opacity-10"
                                        style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);"
                                        aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <h6 class="mb-3">Laporan Hari Ini</h6>
                <p class="text-sm text-muted mb-3">{{ $tanggalFormat }}</p>
                <div class="row text-center">
                    <div class="col-md-3">
                        <i class="bi bi-person-plus-fill text-success mb-1" style="font-size: 20px;"></i>
                        <p class="text-sm text-uppercase font-weight-bold mb-0">Pengguna Baru</p>
                        <h5 class="font-weight-bolder">{{ $jumlahUserHariIni }}</h5>
                    </div>

                    <div class="col-md-3">
                        <i class="bi bi-book-fill text-primary mb-1" style="font-size: 20px;"></i>
                        <p class="text-sm text-uppercase font-weight-bold mb-0">Peminjaman</p>
                        <h5 class="font-weight-bolder">{{ $jumlahPinjamBukuHariIni }}</h5>
                    </div>

                    <div class="col-md-3">
                        <i class="bi bi-arrow-repeat text-info mb-1" style="font-size: 20px;"></i>
                        <p class="text-sm text-uppercase font-weight-bold mb-0">Pengembalian</p>
                        <h5 class="font-weight-bolder">{{ $jumlahPengembalianBukuHariIni }}</h5>
                    </div>

                    <div class="col-md-3">
                        <i class="bi bi-exclamation-triangle-fill text-danger mb-1" style="font-size: 20px;"></i>
                        <p class="text-sm text-uppercase font-weight-bold mb-0">Jatuh Tempo</p>
                        <h5 class="font-weight-bolder">{{ $jumlahPinjamBukuJatuhTempo }}</h5>
                    </div>
                </div>
            </div>
        </div>



        <div class="row mt-4">
            <div class="col-lg-6 mb-lg-0 mb-4">
                <div class="card z-index-2 h-100">
                    <div class="card-header pb-0 pt-3 bg-transparent">
                        <h6 class="text-capitalize">Grafik Peminjaman</h6>
                        <p class="text-sm mb-0">
                            <i class="fa fa-arrow-up text-success"></i>
                            <span class="font-weight-bold"></span> 2024
                        </p>
                    </div>
                    <div class="card-body p-3">
                        <div class="chart">
                            <canvas id="chartPinjamBuku" height="185"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-lg-0 mb-4">
                <div class="card z-index-2 h-100">
                    <div class="card-header pb-0 pt-3 bg-transparent">
                        <h6 class="text-capitalize">Grafik Table</h6>
                        <p class="text-sm mb-0">
                            <i class="fa fa-arrow-up text-success"></i>
                            <span class="font-weight-bold"></span> 2024
                        </p>
                    </div>
                    <div class="card-body p-3">
                        <div class="chart">
                            <canvas id="chartJumlah" height="185"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-7 mb-lg-0 mb-4">
                <div class="card ">
                    <div class="card-header pb-0 p-3">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-2">Buku Favorit</h6>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center ">
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($buku as $item)
                                    <tr>
                                        <td class="w-30">
                                            <div class="d-flex px-2 py-1 align-items-center">
                                                <div>
                                                    {{ $no++ }}
                                                </div>
                                                <div class="ms-4">
                                                    <p class="text-xs font-weight-bold mb-0">Judul:</p>
                                                    <h6 class="text-sm mb-0">{{ $item->judul }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">Kategori:</p>
                                                <h6 class="text-sm mb-0">{{ $item->Kategori->nama_kategori }}</h6>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">Penulis:</p>
                                                <h6 class="text-sm mb-0">{{ $item->Penulis->nama_penulis }}</h6>
                                            </div>
                                        </td>
                                        <td class="align-middle text-sm">
                                            <div class="col text-center">
                                                <p class="text-xs font-weight-bold mb-0">Penerbit:</p>
                                                <h6 class="text-sm mb-0">{{ $item->Penerbit->nama_penerbit }}</h6>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- <div class="col-lg-5" style="height: 400px;">
                <div class="card card-carousel overflow-hidden h-100 p-0">
                    <div id="carouselExampleCaptions" class="carousel slide h-100" data-bs-ride="carousel">
                        <div class="carousel-inner border-radius-lg h-100">
                            @foreach ($buku as $item)
                                <div class="carousel-item h-100 active"
                                    style="background-image: url('{{ file_exists(public_path('images/buku/' . $item->image_buku)) ? asset('images/buku/' . $item->image_buku) : asset('assets/img/noimage.png') }}');
                                    background-size: cover;">
                                    <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                                        <h5 class="text-white mb-1">{{ $item->judul }}</h5>
                                        <p>{{ $item->desc_buku }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev w-5 me-3" type="button"
                            data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next w-5 me-3" type="button"
                            data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div> --}}

            <div class="col-lg-5">
                <!-- Card for Total Pendapatan Denda -->
                <div class="card border-0 shadow-sm p-4 mb-3">
                    <div class="card-body p-3">
                        <h6 class="card-title text-uppercase text-muted mb-1" style="font-size: 14px;">Total Pendapatan
                            Denda</h6>
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <div class="d-flex align-items-center">
                                <h4 class="text-dark mb-0" style="font-size: 18px;">Rp0</h4>
                            </div>
                            <div class="rounded-circle bg-success d-flex justify-content-center align-items-center shadow-sm"
                                style="width: 30px; height: 30px; position: relative;">
                                <i class="bi bi-currency-dollar text-white" style="font-size: 16px;"></i>
                            </div>
                        </div>
                        <p class="mb-1 text-muted" style="font-size: 12px;">{{ $tanggalFormat }}</p>
                        <p class="text-success small mb-0" style="font-size: 12px;">+0% dari bulan sebelumnya</p>
                    </div>
                </div>

                <!-- Card for Total Tunggakan -->
                <div class="card border-0 shadow-sm p-4">
                    <div class="card-body p-3">
                        <h6 class="card-title text-uppercase text-muted mb-1" style="font-size: 14px;">Total Tunggakan
                        </h6>
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <div class="d-flex align-items-center">
                                <h4 class="text-dark mb-0" style="font-size: 18px;">Rp0</h4>
                            </div>
                            <div class="rounded-circle bg-danger d-flex justify-content-center align-items-center shadow-sm"
                                style="width: 30px; height: 30px; position: relative;">
                                <i class="bi bi-currency-dollar text-white" style="font-size: 16px;"></i>
                            </div>
                        </div>
                        <p class="mb-1 text-muted" style="font-size: 12px;">{{ $tanggalFormat }}</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection


@push('scripts')
    <script>
        var ctx = document.getElementById('chartPinjamBuku').getContext('2d');
        var chartPinjamBuku = new Chart(ctx, {
            type: 'line', // Change to 'line' for a line chart
            data: {
                labels: @json($namaBulan), // Nama bulan di sumbu x
                datasets: [{
                    label: '', // Mengosongkan label
                    data: @json($dataDikembalikan), // Data jumlah peminjaman dengan status 'dikembalikan'
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2, // Adjusted for line chart
                    fill: false, // No fill under the line
                    tension: 0.1 // Smoothness of the line
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 10, // Langkah antar nilai
                            callback: function(value) {
                                if (value % 10 === 0) {
                                    return value; // Tampilkan hanya kelipatan 10
                                }
                            }
                        },
                        min: 0, // Mulai dari 0
                        max: 100 // Sampai 100 sesuai contoh gambar
                    }
                },
                plugins: {
                    legend: {
                        display: false // Menonaktifkan kotak legend
                    }
                }
            }
        });
    </script>

    <script>
        var ctx = document.getElementById('chartJumlah').getContext('2d');
        var chartJumlah = new Chart(ctx, {
            type: 'bar', // Tipe chart batang
            data: {
                labels: ['Kategori', 'Penulis', 'Penerbit', 'Buku'], // Label untuk tiap batang
                datasets: [{
                    label: '', // Mengosongkan label
                    data: [
                        @json($jumlahKategori), // Jumlah kategori
                        @json($jumlahPenulis), // Jumlah penulis
                        @json($jumlahPenerbit), // Jumlah penerbit
                        @json($jumlahBuku) // Jumlah buku
                    ],
                    backgroundColor: [
                        'rgba(0, 0, 255)', // Biru 
                        'rgba(255, 165, 0)', // Oranye 
                        'rgba(255, 69, 0)', // Merah 
                        'rgba(0, 128, 0)', // Hijau 
                    ],
                    borderColor: [
                        'rgba(0, 0, 255, 1)', // Biru 
                        'rgba(255, 165, 0, 1)', // Oranye 
                        'rgba(255, 69, 0, 1)', // Merah 
                        'rgba(0, 128, 0, 1)', // Hijau 
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false // Menonaktifkan kotak legend
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 10, // Langkah antar nilai
                            callback: function(value) {
                                if (value % 10 === 0) {
                                    return value; // Tampilkan hanya kelipatan 
                                }
                            }
                        },
                        min: 0, // Mulai dari 0
                        max: 100 // Sampai 100 sesuai contoh gambar
                    }
                }
            }
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
@endpush
