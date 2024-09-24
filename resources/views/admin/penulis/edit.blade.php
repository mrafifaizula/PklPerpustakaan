@extends('layouts.backend')

@section('title', 'Edit Penulis')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Nama Penulis
                        <a href="{{ route('penulis.index') }}" class="btn btn-sm btn-primary" style="float: right">Kembali</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('penulis.update', $penulis->id) }}" method="post"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="mb-2">
                                <label for="nama_penulis">Nama Penulis</label>
                                <input type="text" class="form-control @error('nama_penulis') is-invalid @enderror"
                                    name="nama_penulis" value="{{ $penulis->nama_penulis }}">
                                @error('nama_penulis')
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
