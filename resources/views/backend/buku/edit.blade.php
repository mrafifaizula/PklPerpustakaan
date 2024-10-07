@extends('layouts.backend')

@section('title', 'Edit Buku')


@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Edit Buku</span>
                        <a href="{{ route('buku.index') }}" class="btn btn-sm btn-primary">Kembali</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('buku.update', $buku->id) }}" method="post" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="row">
                                <div class="col-md-4 text-center">
                                    @if ($buku->image_buku)
                                        <img src="{{ asset('images/buku/' . $buku->image_buku) }}" alt="Foto Buku"
                                            class="img-thumbnail mb-3"
                                            style="width: 150px; height: 190px; object-fit: cover;">
                                    @else
                                        <img src="{{ asset('images/placeholder.png') }}" alt="Placeholder"
                                            class="img-thumbnail mb-3"
                                            style="width: 150px; height: 190px; object-fit: cover;">
                                    @endif
                                    <input type="file" name="image_buku"
                                        class="form-control @error('image_buku') is-invalid @enderror">
                                    @error('image_buku')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="judul" class="form-label">Judul Buku</label>
                                        <input type="text" name="judul"
                                            class="form-control @error('judul') is-invalid @enderror"
                                            value="{{ old('judul', $buku->judul) }}">
                                        @error('judul')
                                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="code_buku" class="form-label">Kode Buku</label>
                                        <input type="text" name="code_buku"
                                            class="form-control @error('code_buku') is-invalid @enderror"
                                            value="{{ old('code_buku', $buku->code_buku) }}">
                                        @error('code_buku')
                                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="jumlah_buku" class="form-label">Stok</label>
                                        <input type="text" name="jumlah_buku"
                                            class="form-control @error('jumlah_buku') is-invalid @enderror"
                                            value="{{ old('jumlah_buku', $buku->jumlah_buku) }}">
                                        @error('jumlah_buku')
                                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="id_kategori" class="form-label">Kategori</label>
                                        <select name="id_kategori"
                                            class="form-control @error('id_kategori') is-invalid @enderror">
                                            <option value="" disabled selected>--Pilih Kategori--</option>
                                            @foreach ($kategori as $data)
                                                <option value="{{ $data->id }}"
                                                    {{ old('id_kategori', $buku->id_kategori) == $data->id ? 'selected' : '' }}>
                                                    {{ $data->nama_kategori }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_kategori')
                                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                                        <input type="text" name="tahun_terbit"
                                            class="form-control @error('tahun_terbit') is-invalid @enderror"
                                            value="{{ old('tahun_terbit', $buku->tahun_terbit) }}">
                                        @error('tahun_terbit')
                                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="id_penulis" class="form-label">Penulis</label>
                                        <select name="id_penulis"
                                            class="form-control @error('id_penulis') is-invalid @enderror">
                                            <option value="" disabled selected>--Pilih Penulis--</option>
                                            @foreach ($penulis as $data)
                                                <option value="{{ $data->id }}"
                                                    {{ old('id_penulis', $buku->id_penulis) == $data->id ? 'selected' : '' }}>
                                                    {{ $data->nama_penulis }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_penulis')
                                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="id_penerbit" class="form-label">Penerbit</label>
                                        <select name="id_penerbit"
                                            class="form-control @error('id_penerbit') is-invalid @enderror">
                                            <option value="" disabled selected>--Pilih Penerbit--</option>
                                            @foreach ($penerbit as $data)
                                                <option value="{{ $data->id }}"
                                                    {{ old('id_penerbit', $buku->id_penerbit) == $data->id ? 'selected' : '' }}>
                                                    {{ $data->nama_penerbit }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_penerbit')
                                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="desc_buku" class="form-label">Deskripsi</label>
                                    <textarea class="form-control @error('desc_buku') is-invalid @enderror" name="desc_buku">{{ old('desc_buku', $buku->desc_buku) }}</textarea>
                                    @error('desc_buku')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="text">
                                <button type="submit" class="btn btn-sm btn-success">Simpan</button>
                                <button class="btn btn-sm btn-warning" type="reset">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
