@extends('layouts.backend')

@section('title', 'Data User')

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.5/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.1.2/css/buttons.dataTables.css">
@endsection

@section('content')
    <h4 class="m-5"><span style="color: white">Tables</span> User</h4>
    <div class="card m-5">
        <div class="card-header">
            <div class="float-start">
                <h5> User </h5>
            </div>
            <div class="float-end">
                <a href="{{ route('user.create') }}" class="btn btn-sm btn-primary" title="Tambah">
                    <i class="bi bi-plus-lg"></i> Tambah
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table" id="example">
                    <thead>
                        <tr>
                            <td class="text-center">No</td>
                            <td>Nama</td>
                            <td>Alamat</td>
                            <td class="text-center">Telepon</td>
                            <td>Email</td>
                            <td>Role</td>
                            <td class="text-center">Aksi</td>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i=1; @endphp
                        @foreach ($user as $data)
                            <tr>
                                <td class="text-center">{{ $i++ }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->alamat }}</td>
                                <td class="text-center">{{ $data->tlp }}</td>
                                <td>{{ $data->email }}</td>
                                {{-- <td>{{ $data->isAdmin == 1 ? 'Admin' : ($data->isAdmin == 2 ? 'Manager' : 'User') }}</td> --}}
                                <td>{{ $data->isAdmin == 1 ? 'Admin' : 'User' }}</td>
                                <td class="text-center">
                                    <form action="{{ route('user.destroy', $data->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{ route('user.destroy', $data->id) }}"
                                            class="btn btn btn-danger" data-confirm-delete="true" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </form>
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
            buttons: [
                {
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
