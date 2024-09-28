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
                                        {{ \App\Models\User::where('role', 'user')->count() }}
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
                            <h6 class="mb-2">Table Buku</h6>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="bukuTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <td class="text-center">No</td>
                                    <td>Judul</td>
                                    <td>Kategori</td>
                                    <td>Penulis</td>
                                    <td>Penerbit</td>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($buku as $item)
                                    <tr>
                                        <td class="text-center">{{ $no++ }}</td>
                                        <td>{{ $item->judul }}</td>
                                        <td class="text-center">{{ $item->Kategori->nama_kategori }}</td>
                                        <td class="text-center">{{ $item->Penulis->nama_penulis }}</td>
                                        <td class="text-center">{{ $item->Penerbit->nama_penerbit }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-5" style="height: 400px;">
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
            </div>

        </div>
    </div>
@endsection


@push('scripts')
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            // Destroy existing DataTable instance for bukuTable
            if ($.fn.DataTable.isDataTable('#bukuTable')) {
                $('#bukuTable').DataTable().destroy();
            }

            // Initialize DataTable for bukuTable only
            $('#bukuTable').DataTable({
                "language": {
                    "zeroRecords": "Tidak ada data yang tersedia",
                    "info": "   ", // Info display
                    "infoEmpty": "Tidak ada entri yang tersedia", // When no data is available
                    "lengthMenu": "Tampilkan _MENU_ entri", // Length menu
                    "paginate": {
                        "first": '<i class="bi bi-chevron-double-left"></i>', // First page
                        "last": '<i class="bi bi-chevron-double-right"></i>', // Last page
                        "next": '<i class="bi bi-chevron-right"></i>', // Next page
                        "previous": '<i class="bi bi-chevron-left"></i>' // Previous page
                    }

                },
                "paging": true, // Enable pagination
                "searching": false, // Disable searching
                "pageLength": 5 // Set default number of entries to show
            });
        });
    </script>

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
