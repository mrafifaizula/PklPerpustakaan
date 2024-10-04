@extends('layouts.backend')

@section('title', 'Penerbit Import Excel')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">penerbit Import Excel
                        <a href="{{ route('export.penerbit') }}" class="btn btn-sm btn-success m-2" style="float: right"><i class="bi bi-file-earmark-excel"></i> Unduh Excel</a>
                        <a href="{{ route('penerbit.index') }}" class="btn btn-sm btn-primary m-2" style="float: right">Kembali</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('importManual.penerbit') }}" method="POST">
                            @csrf
                            <label for="penerbits" class="form-label">Paste Disinih:</label>
                            <textarea class="form-control rows= @error('penerbits') is-invalid @enderror" rows="7" name="penerbits"></textarea>
                            @error('penerbits')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <button type="submit" class="btn btn-sm btn-success mt-2">Import penerbit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
