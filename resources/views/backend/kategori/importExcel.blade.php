@extends('layouts.backend')

@section('title', 'Kategori Import Excel')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Kategori Import Excel
                        <a href="{{ route('export.kategori') }}" class="btn btn-sm btn-success m-2" style="float: right"><i class="bi bi-file-earmark-excel"></i> Unduh Excel</a>
                        <a href="{{ route('kategori.index') }}" class="btn btn-sm btn-primary m-2" style="float: right">Kembali</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('importManual.kategori') }}" method="POST">
                            @csrf
                            <label for="kategoris" class="form-label">Paste Disinih:</label>
                            <textarea class="form-control rows= @error('kategoris') is-invalid @enderror" rows="7" name="kategoris"></textarea>
                            @error('kategoris')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <button class="btn btn-sm btn-success mt-2" type="submit">Simpan</button>
                            <button class="btn btn-sm btn-warning mt-2" type="reset">Reset</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
