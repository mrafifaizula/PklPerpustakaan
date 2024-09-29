@extends('layouts.profil')

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.5/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.1.2/css/buttons.dataTables.css">
@endsection

@section('title', 'Peminjaman Buku')

<style>
    .dataTables_wrapper .dt-buttons {
        margin-bottom: 2px;
        /* Adjust margin between buttons and table */
    }

    .dataTables_wrapper .dataTables_filter {
        text-align: right;
        /* Align search box to the right */
    }
</style>

@section('content')
    <h4 class="m-5"><span style="color: white">Peminjaman </span>Buku</h4>
    <div class="card m-5">
        <div class="card-header">
            <div class="float-start">
                <h5> peminjaman buku </h5>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table" id="example">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Nama</td>
                            <td>Judul</td>
                            <td>Jumlah</td>
                            {{-- <td>Tanggal Pinjam</td> --}}
                            <td class="taxt-center">Bata Pengembalian</td>
                            <td>Status</td>
                            <td class="text-center">Aksi</td>
                        </tr>
                    </thead>

                    @php $no = 1; @endphp
                    <tbody>
                        @foreach ($pinjambuku as $item)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td>{{ $item->user->name }}</td>
                                <td>{{ $item->buku->judul }}</td>
                                <td class="text-center">{{ $item->jumlah }}</td>
                                {{-- <td>{{ $item->tanggal_pinjambuku }}</td> --}}
                                <td class="text-center">{{ $item->batas_pengembalian }}</td>
                                <td>
                                    <span
                                        class="badge badge-sm 
                                    @if ($item->status == 'menunggu') bg-gradient-info
                                    @elseif($item->status == 'diterima') bg-gradient-success
                                    @elseif($item->status == 'ditolak') bg-gradient-danger
                                    @elseif($item->status == 'dikembalikan') bg-gradient-primary
                                    @elseif($item->status == 'menunggu pengembalian') bg-gradient-warning
                                    @elseif($item->status == 'pengembalian ditolak') bg-gradient-warning @endif
                                ">
                                        @if ($item->status == 'menunggu')
                                            Menunggu
                                        @elseif($item->status == 'diterima')
                                            Disetujui
                                        @elseif($item->status == 'ditolak')
                                            Ditolak
                                        @elseif($item->status == 'dikembalikan')
                                            Sudah Dikembalikan
                                        @elseif($item->status == 'menunggu pengembalian')
                                            Menunggu Pengembalian
                                        @elseif($item->status == 'pengembalian ditolak')
                                            Pengembalian Ditolak
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    @if ($item->status == 'menunggu pengembalian')
                                        <!-- Tombol Batalkan Pengajuan Pengembalian -->
                                        <form action="{{ route('batalkan.pengajuan.pengembalian', $item->id) }}" method="POST"
                                              onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pengajuan pengembalian ini?');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-warning">
                                                Batalkan
                                            </button>
                                        </form>
                                    @elseif ($item->status == 'menunggu')
                                        <!-- Tombol Batalkan Pengajuan -->
                                        <form action="{{ route('batalkan.pengajuan', $item->id) }}" method="POST"
                                              onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pengajuan ini?');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-warning">
                                                Batalkan
                                            </button>
                                        </form>
                                    @else
                                        <!-- Tombol Ajukan Pengembalian -->
                                        <form action="{{ route('pinjambuku.ajukanpengembalian', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-primary"
                                                    @if ($item->status != 'diterima' && $item->status != 'pengembalian ditolak') disabled @endif>
                                                Ajukan Pengembalian
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/2.1.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.colVis.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                dom: '<"row"<"col-sm-6"B><"col-sm-6"f>>' +
                    '<"row"<"col-sm-12"tr>>' +
                    '<"row"<"col-sm-5"i><"col-sm-7"p>>',
                buttons: [{
                        extend: 'pdf',
                        text: '<i class="bi bi-file-earmark-pdf"></i> PDF',
                        className: 'btn btn-danger',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
                        }
                    },
                    {
                        extend: 'excel',
                        text: '<i class="bi bi-file-earmark-excel"></i> Excel',
                        className: 'btn btn-success',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="bi bi-printer"></i> Print',
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
                        }
                    },
                ],
                language: {
                    search: "Mencari:", // Translations
                    lengthMenu: "Tampilkan _MENU_ entri",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
                    infoFiltered: "(difilter dari _MAX_ total entri)",
                    zeroRecords: "Tidak ada data yang cocok",
                    emptyTable: "Tidak ada data tersedia dalam tabel",
                }
            });
        });
    </script>
@endpush
