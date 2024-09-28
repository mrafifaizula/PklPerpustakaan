@extends('layouts.backend')

@section('title', 'Crate Buku')


@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Data Buku
                        <a href="{{ route('buku.index') }}" class="btn btn-sm btn-primary" style="float: right">Kembali</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('buku.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-2">
                                <label for="judul">Judul</label>
                                <input type="text" placeholder="Judul"
                                    class="form-control @error('judul') is-invalid @enderror" name="judul">
                                @error('judul')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <label for="code_buku">Kode Buku</label>
                                <input type="text" placeholder="Kode Buku"
                                    class="form-control @error('code_buku') is-invalid @enderror" name="code_buku">
                                @error('code_buku')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <label for="tahun_terbit">Tahun Terbit</label>
                                <input type="date" placeholder="Tahun Terbit"
                                    class="form-control @error('tahun_terbit') is-invalid @enderror" name="tahun_terbit">
                                @error('tahun_terbit')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <label for="jumlah_buku">Stok</label>
                                <input type="number" placeholder="Stok"
                                    class="form-control @error('jumlah_buku') is-invalid @enderror" name="jumlah_buku">
                                @error('jumlah_buku')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="image_buku" class="form-label">Foto Buku</label>
                                <input type="file" name="image_buku"
                                    class="form-control @error('image_buku') is-invalid @enderror">
                                @error('image_buku')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="id_kategori" class="form-label">Kategori Buku</label>
                                <select name="id_kategori" class="form-control @error('id_kategori') is-invalid @enderror">
                                    <option value="" disabled selected>Pilih Kategori</option>
                                    @foreach ($kategori as $data)
                                        <option value="{{ $data->id }}">{{ $data->nama_kategori }}</option>
                                    @endforeach
                                </select>
                                @error('id_kategori')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="id_penulis" class="form-label">Nama Penulis</label>
                                <select name="id_penulis" class="form-control @error('id_penulis') is-invalid @enderror">
                                    <option value="" disabled selected>Pilih Penulis</option>
                                    @foreach ($penulis as $data)
                                        <option value="{{ $data->id }}">{{ $data->nama_penulis }}</option>
                                    @endforeach
                                </select>
                                @error('id_penulis')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="id_penerbit" class="form-label">Nama Penerbit</label>
                                <select name="id_penerbit" class="form-control @error('id_penerbit') is-invalid @enderror">
                                    <option value="" disabled selected>Pilih Penerbit</option>
                                    @foreach ($penerbit as $data)
                                        <option value="{{ $data->id }}">{{ $data->nama_penerbit }}</option>
                                    @endforeach
                                </select>
                                @error('id_penerbit')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="desc_buku" class="form-label">Deskripsi</label>
                                <textarea class="form-control @error('desc_buku') is-invalid @enderror" name="desc_buku"></textarea>
                                @error('desc_buku')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <button class="btn btn-sm btn-success" type="submit">Simpan</button>
                                <button class="btn btn-sm btn-warning" type="reset">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
   
@endpush
