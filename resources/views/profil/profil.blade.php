@extends('layouts.profil')

@section('title', 'Profile')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex align-items-center">
                            <p class="mb-0">Mengedit Profile</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="row g-3" method="POST" action="{{ route('profil.update', $user->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            
                            <!-- Input Nama -->
                            <div class="col-md-6">
                                <label for="name" class="form-label">Nama</label>
                                <div class="position-relative">
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ $user->name }}" placeholder="Nama" required>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        
                            <!-- Input Foto Profile -->
                            <div class="col-md-6">
                                <label for="image_user" class="form-label">Foto Profile</label>
                                <div class="position-relative">
                                    <input class="form-control mb-3" type="file" name="image_user" id="image_user">
                                </div>
                            </div>
                        
                            <!-- Input Nomor Telepon -->
                            <div class="col-md-6">
                                <label for="tlp" class="form-label">Nomor Handphone</label>
                                <div class="position-relative">
                                    <input class="form-control mb-3 @error('tlp') is-invalid @enderror" type="tel" name="tlp" id="tlp" placeholder="Nomor Handphone" value="{{ $user->tlp }}" required>
                                    @error('tlp')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        
                            <!-- Input Email (Readonly) -->
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <div class="position-relative">
                                    <input type="email" name="email" class="form-control" id="email" value="{{ $user->email }}" placeholder="Email" readonly>
                                </div>
                            </div>
                        
                            <!-- Input Alamat -->
                            <div class="col-md-12">
                                <label for="alamat" class="form-label">Alamat</label>
                                <div class="position-relative">
                                    <textarea class="form-control mb-3 @error('alamat') is-invalid @enderror" name="alamat" id="alamat" placeholder="Alamat" required>{{ $user->alamat }}</textarea>
                                    @error('alamat')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        
                            <!-- Tombol Update -->
                            <div class="col-md-12">
                                <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                    <button type="submit" class="btn btn-sm btn-primary px-4">Perbarui Profile</button>
                                </div>
                            </div>
                        </form>                        
                    </div>
                </div>
            </div>
            <div class="col-md-4" >
                <div class="card card-profile">
                    <img src="{{ Auth::user()->image_user ? asset('images/user/' . Auth::user()->image_user) : asset('assets/img/user.jpg') }}" alt="Image placeholder" class="card-img-top" style="height: 250px;">
                    {{-- <div class="row justify-content-center">
                        <div class="col-4 col-lg-4 order-lg-2">
                            <div class="mt-n4 mt-lg-n6 mb-4 mb-lg-0">
                                <a href="javascript:;">
                                    <img src="{{ asset('images/user/' . $user->image_user) }}"
                                        style="border-radius: 50%; object-fit: cover; width: 80px; height: 80px;"
                                        class="img-fluid border border-2 border-white">
                                </a>                                
                            </div>
                        </div>
                    </div> --}}
                    <div class="card-header text-center border-0 pt-0 pt-lg-2 pb-4 pb-lg-3">
                        <div class="d-flex justify-content-between">
                            <a href="javascript:;" class="btn btn-sm btn-info mb-0 d-none d-lg-block">Connect</a>
                            <a href="javascript:;" class="btn btn-sm btn-info mb-0 d-block d-lg-none"><i
                                    class="ni ni-collection"></i></a>
                            <a href="javascript:;"
                                class="btn btn-sm btn-dark float-right mb-0 d-none d-lg-block">Message</a>
                            <a href="javascript:;" class="btn btn-sm btn-dark float-right mb-0 d-block d-lg-none"><i
                                    class="ni ni-email-83"></i></a>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col">
                                <div class="d-flex justify-content-center">
                                    <div class="d-grid text-center mx-4">
                                        <span class="text-lg font-weight-bolder">{{ $userPinjamBuku }}</span>
                                        <span class="text-sm opacity-8">Buku yang Dipinjam</span>
                                    </div>
                                    <div class="d-grid text-center">
                                        <span
                                            class="text-lg font-weight-bolder">{{ $jumlahBukuPinjam }}</span>
                                        <span class="text-sm opacity-8">Jumlah Buku Yang Dipinjam</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <h5 style="font-size: 15px">
                                {{ Auth::user()->name }}
                            </h5>
                            <div>
                                <i class="ni education_hat mr-2"></i>Smk Assalaam Bandung
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
