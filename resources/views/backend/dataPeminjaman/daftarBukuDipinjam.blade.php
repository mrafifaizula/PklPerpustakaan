@extends('layouts.backend')

@section('title', 'Data Buku Yang di Pinjam')

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.5/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.1.2/css/buttons.dataTables.css">
@endsection

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
    <h4 class="m-5"><span style="color: white">Buku </span> Yang Dipinjam
    </h4>
    <div class="card m-5">
        <div class="card-header">
            <div class="float-start">
                <h5>
                    Buku Yang Dipinjam
                </h5>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table" id="example">
                    <thead>
                        <td class="text-center">No</td>
                        <td>Name</td>
                        <td>Judul</td>
                        <td>Jumlah</td>
                        {{-- <td>Tanggal Pinjam</td> --}}
                        <td class="text-center">Batas Pengembalian</td>
                        <td>Status</td>
                        <td class="text-center">Aksi</td>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
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
                                            Dipinjam
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
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" title="Detail"
                                        data-bs-target="#exampleModal{{ $item->id }}">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- start Modal -->
                            <div class="modal fade" id="exampleModal{{ $item->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                Riwayat
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="row mb-2">
                                                    <div class="col-md-6">
                                                        <label for="">Nama</label>
                                                        <input type="text" class="form-control" name="name"
                                                            value="{{ $item->user->name }}" disabled>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="">Judul</label>
                                                        <input type="text" class="form-control" name="judul"
                                                            value="{{ $item->buku->judul }}" disabled>
                                                    </div>
                                                </div>

                                                <div class="row mb-2">
                                                    <div class="col-md-6">
                                                        <label for="">Jumlah</label>
                                                        <input type="text" class="form-control" name="jumlah_buku"
                                                            value="{{ $item->jumlah }}" disabled>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="">Kode Buku</label>
                                                        <input type="text" class="form-control" name="code_buku"
                                                            value="{{ $item->buku->code_buku }}" disabled>
                                                    </div>
                                                </div>

                                                <div class="row mb-2">
                                                    <div class="col-md-6">
                                                        <label for="">Tanggal Pinjam</label>
                                                        <input type="text" class="form-control" name="tanggal_pinjambuku"
                                                            value="{{ $item->tanggal_pinjambuku }}" disabled>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="">Batas Pengembalian</label>
                                                        <input type="text" class="form-control" name="batas_pengembalian"
                                                            value="{{ $item->batas_pengembalian }}" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-sm btn-secondary"
                                                data-bs-dismiss="modal">Kembali</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end modal -->
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
                        titleAttr: 'Export PDF',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
                        }
                    },
                    {
                        extend: 'excel',
                        text: '<i class="bi bi-file-earmark-excel"></i> Excel',
                        className: 'btn btn-success',
                        titleAttr: 'Export Excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="bi bi-printer"></i> Print',
                        className: 'btn btn-primary',
                        titleAttr: 'Print',
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
    <script>
        const myModal = document.getElementById('myModal')
        const myInput = document.getElementById('myInput')

        myModal.addEventListener('shown.bs.modal', () => {
            myInput.focus()
        })
    </script>
@endpush
