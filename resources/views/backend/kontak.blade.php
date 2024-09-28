@extends('layouts.backend')

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
    <h4 class="m-5"><span style="color: white">Data </span> kontak</h4>
    <div class="card m-5">
        <div class="card-header">
            <div class="float-start">
                <h5> kontak </h5>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table" id="example">
                    <thead>
                        <td>No</td>
                        <td>Nama</td>
                        <td>Pesan</td>
                        <td>Action</td>
                    </thead>
                    @php $no = 1; @endphp
                    <tbody>
                        @foreach ($kontak as $item)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $item->user->name }}</td>
                                <td>{{ $item->pesan }}</td>
                                <td>
                                    <form action="" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal{{ $item->id }}" title="Lihat">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        {{-- <a href="{{ route('kontak.destroy', $item->id) }}" class="btn btn-danger"
                                            data-confirm-delete="true" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </a> --}}
                                    </form>
                                </td>
                            </tr>
                            <!-- start Modal -->
                            <div class="modal fade" id="exampleModal{{ $item->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Kontak</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-2">
                                                <label for="">Nama</label>
                                                <input type="text"
                                                    class="form-control @error('name') is-invalid @enderror"
                                                    name="name" value="{{ $item->user->name }}" disabled>
                                            </div>
                                            <div class="mb-2">
                                                <label for="">Pesan</label>
                                                <input type="text"
                                                    class="form-control @error('pesan') is-invalid @enderror"
                                                    name="pesan" value="{{ $item->pesan }}" disabled>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Keluar</button>
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
    {{-- <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script> --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.bootstrap5.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.colVis.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                dom: '<"row"<"col-sm-6"B><"col-sm-6"f>>' + // Buttons on the left, search on the right
                    '<"row"<"col-sm-12"tr>>' + // Table
                    '<"row"<"col-sm-5"i><"col-sm-7"p>>', // Info and pagination
                buttons: [{
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0, 1]
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1]
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [0, 1]
                        }
                    },
                ]
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
