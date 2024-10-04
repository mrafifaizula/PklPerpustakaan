@extends('layouts.backend')

@section('title', 'penulis Import Excel')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">penulis Import Excel
                        <a href="{{ route('export.penulis') }}" class="btn btn-sm btn-success m-2" style="float: right"><i
                                class="bi bi-file-earmark-excel"></i> Unduh Excel</a>
                        <a href="{{ route('penulis.index') }}" class="btn btn-sm btn-primary m-2"
                            style="float: right">Kembali</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('importManual.penulis') }}" method="POST">
                            @csrf
                            <label for="penuliss" class="form-label">Paste Disinih:</label>
                            <textarea class="form-control rows= @error('penuliss') is-invalid @enderror" rows="7" name="penuliss"></textarea>
                            @error('penuliss')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <button type="submit" class="btn btn-sm btn-success mt-2">Import penulis</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
