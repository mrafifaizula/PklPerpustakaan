@extends('layouts.backend')

@section('title', 'Create User')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Data User
                        <a href="{{ route('user.index') }}" class="btn btn-sm btn-primary" style="float: right">Kembali</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('user.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="mb-2">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col">
                                    <div class="mb-2">
                                        <label for="tlp">Nomor Telepon</label>
                                        <input type="text" class="form-control @error('tlp') is-invalid @enderror"
                                            name="tlp">
                                        @error('tlp')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat"></textarea>
                                        @error('alamat')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="image_user" class="form-label">Images</label>
                                        <input type="file" name="image_user"
                                            class="form-control @error('image_user') is-invalid @enderror">
                                        @error('image_user')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-2">
                                        <label for="email">Email</label>
                                        <input type="text" class="form-control @error('email') is-invalid @enderror"
                                            name="email">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-2">
                                        <label for="password">password</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                            name="password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-2">
                                        <label for="role">Role</label>
                                        <select name="role" class="form-control select @error('role') is-invalid @enderror">
                                            <option value="">Pilih</option>
                                            <option value="user">User</option>
                                            <option value="staf">Staf</option>
                                            <option value="admin">Admin</option>
                                        </select>
                                    </div>                                    
                                </div>
                            </div>
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
