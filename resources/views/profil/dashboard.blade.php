@extends('layouts.profil')

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endsection

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid py-4">
        <div class="col-12 col-lg-12 col-xxl-12">
            <div class="card bg-secondary text-light">
                <div class="card-header d-flex align-items-center p-2">
                    <i class="bi bi-exclamation-diamond-fill fs-3 me-2" style="color: red"></i>
                    <h4 class="card-title mb-0">Peraturan</h4>
                </div>
                <div class="card-body p-2">
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex align-items-center mb-1">
                            <i class="bi bi-check-circle-fill fs-4 me-2" style="color: rgb(0, 145, 255)"></i>
                            Pastikan untuk mengembalikan buku tepat waktu untuk menghindari denda.
                        </li>
                        <li class="d-flex align-items-center mb-1">
                            <i class="bi bi-check-circle-fill fs-4 me-2" style="color: rgb(0, 145, 255)"></i>
                            Jaga agar buku dalam kondisi baik Kerusakan dapat dikenakan biaya.
                        </li>
                        <li class="d-flex align-items-center mb-1">
                            <i class="bi bi-check-circle-fill fs-4 me-2" style="color: rgb(0, 145, 255)"></i>
                            Ajukan perpanjangan sebelum tanggal jatuh tempo jika memakan waktu lebih lama.
                        </li>
                        <li class="d-flex align-items-center mb-1">
                            <i class="bi bi-check-circle-fill fs-4 me-2" style="color: rgb(0, 145, 255)"></i>
                            Segera laporkan jika buku hilang atau rusak untuk menghindari denda tambahan.
                        </li>
                        <li class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill fs-4 me-2" style="color: rgb(0, 145, 255)"></i>
                            Segera bayar denda atau biaya yang terlambat untuk menghindari pembatasan pinjaman di masa
                            mendatang.
                        </li>
                    </ul>
                </div>
            </div>
        </div>


        <div class="row mt-5">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Buku Yang Dipinjam</p>
                                    <h5 class="font-weight-bolder">
                                        {{ $userPinjamBuku }}
                                    </h5>
                                    <p class="mb-0">
                                        Terbaru
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle"
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
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Jumlah Buku yang Dipinjam</p>
                                    <h5 class="font-weight-bolder">
                                        {{ $totalJumlahBukuDipinjam }}
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
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Riwayat pinjaman</p>
                                    <h5 class="font-weight-bolder">
                                        {{ $pinjamBukuDikembalikan }}
                                    </h5>
                                    <p class="mb-0">
                                        Terbaru
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-secondary shadow-secondary text-center rounded-circle"
                                    style="position: relative; height: 50px; width: 50px;">
                                    <i class="bi bi-list-ul text-lg opacity-10"
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
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Ditolak</p>
                                    <h5 class="font-weight-bolder">
                                        {{ $pinjamBukuUserTolak }}
                                    </h5>
                                    <p class="mb-0">
                                        Latest
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle"
                                    style="position: relative; height: 50px; width: 50px;">
                                    <i class="bi bi-x-octagon-fill text-lg opacity-10"
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
            <!-- Table Section -->
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
                                    <th class="text-center">No</th>
                                    <th>Judul</th>
                                    <th>Kategori</th>
                                    <th>Penulis</th>
                                    <th>Penerbit</th>
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
            <!-- Carousel Section -->
            <div class="col-lg-5">
                <div class="card card-carousel overflow-hidden p-0" style="height: 400px;">
                    <div id="carouselExampleCaptions" class="carousel slide h-100" data-bs-ride="carousel">
                        <div class="carousel-inner h-100">
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
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                            data-bs-slide="next">
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
            // Destroy existing DataTable instances
            if ($.fn.DataTable.isDataTable('#bukuTable')) {
                $('#bukuTable').DataTable().destroy();
            }
            if ($.fn.DataTable.isDataTable('#kategoriTable')) {
                $('#kategoriTable').DataTable().destroy();
            }

            // Initialize DataTables for both tables
            $('#bukuTable, #kategoriTable').DataTable({
                "language": {
                    "zeroRecords": "Tidak ada data yang tersedia",
                    "info": "", // Completely remove the info display
                    "infoEmpty": "", // Do not show anything when there is no data
                    "lengthMenu": "" // Remove the length menu
                },
                "paging": false, // Disable pagination
                "searching": true // Enable searching
            });
        });
    </script>
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
@endpush
