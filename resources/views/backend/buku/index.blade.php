@extends('layouts.backend')

@section('title', 'Table Buku')

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
    <h4 class="m-5"><span style="color: white">Table </span> Buku</h4>
    <div class="card m-5">
        <div class="card-header">
            <div class="float-start">
                <h5> Buku </h5>
            </div>
            <div class="float-end">
                <a href="{{ route('buku.create') }}" class="btn btn-sm btn-primary" title="Tambah">
                    <i class="bi bi-plus-lg"></i> Tambah
                </a>
                <a href="{{ route('import.buku') }}" class="btn btn-sm btn-success" title="Import Excel">
                    <i class="bi bi-file-earmark-excel"></i> Import Excel
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table" id="example">
                    <thead>
                        <td>No</td>
                        <td>Judul</td>
                        {{-- <td>Code Book</td> --}}
                        {{-- <td>Year</td> --}}
                        <td>Stok</td>
                        <td>Kategori</td>
                        <td>Penulis</td>
                        <td>Penerbit</td>
                        {{-- <td>Image</td> --}}
                        <td class="text-center">Aksi</td>
                    </thead>
                    @php $no = 1; @endphp
                    <tbody>
                        @foreach ($buku as $item)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td>{{ $item->judul }}</td>
                                {{-- <td>{{ $item->code_buku }}</td> --}}
                                {{-- <td>{{ $item->tahun_terbit }}</td> --}}
                                <td class="text-center">{{ $item->jumlah_buku }}</td>
                                <td>{{ $item->kategori->nama_kategori }}</td>
                                <td>{{ $item->penulis->nama_penulis }}</td>
                                <td>{{ $item->penerbit->nama_penerbit }}</td>
                                {{-- <td>
                                    <img src="{{ asset('images/buku/' . $item->image_buku) }}" alt="Product Image"
                                        style="width: 50px; height: 50px;">
                                </td> --}}
                                <td>
                                    <form action="{{ route('buku.destroy', $item->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{ route('buku.edit', $item->id) }}" class="btn btn-success"
                                            title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" title="Detail"
                                            data-bs-target="#exampleModal{{ $item->id }}">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button type="submit" class="btn btn-danger" title="Hapus"
                                            data-confirm-delete="true">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <!-- start Modal -->
                            <div class="modal fade" id="exampleModal{{ $item->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Buku</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="">Judul</label>
                                                        <input type="text"
                                                            class="form-control @error('judul') is-invalid @enderror"
                                                            name="judul" value="{{ $item->judul }}" disabled>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="">Kategori</label>
                                                        <input type="text"
                                                            class="form-control @error('kategori') is-invalid @enderror"
                                                            name="kategori" value="{{ $item->Kategori->nama_kategori }}"
                                                            disabled>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="">Stok</label>
                                                        <input type="text"
                                                            class="form-control @error('jumlah_buku') is-invalid @enderror"
                                                            name="jumlah_buku" value="{{ $item->jumlah_buku }}" disabled>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="">Tahun Terbit</label>
                                                        <input type="text"
                                                            class="form-control @error('tahun_terbit') is-invalid @enderror"
                                                            name="tahun_terbit" value="{{ $item->tahun_terbit }}" disabled>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="">Nama Penulis</label>
                                                        <input type="text"
                                                            class="form-control @error('nama_penulis') is-invalid @enderror"
                                                            name="nama_penulis" value="{{ $item->Penulis->nama_penulis }}"
                                                            disabled>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="">Nama Penerbit</label>
                                                        <input type="text"
                                                            class="form-control @error('nama_penerbit') is-invalid @enderror"
                                                            name="nama_penerbit"
                                                            value="{{ $item->Penerbit->nama_penerbit }}" disabled>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row mb-2">
                                                <div class="col-md-12">
                                                    <label for="">Deskripsi</label>
                                                    <textarea class="form-control @error('desc_buku') is-invalid @enderror" name="desc_buku" disabled>{{ $item->desc_buku }}
                                                        </textarea>
                                                </div>
                                            </div>


                                            <div class="mb-2 text-center">
                                                <label for="">Foto Buku</label>
                                                <div>
                                                    <img src="{{ asset('images/buku/' . $item->image_buku) }}"
                                                        alt="Foto Buku"
                                                        style="width: 150px; height: 150px; object-fit: cover;"
                                                        class="rounded">
                                                </div>
                                            </div>


                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-sm btn-secondary"
                                                    data-bs-dismiss="modal">Kembali</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- end modal --}}
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
