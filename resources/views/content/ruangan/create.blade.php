@extends('layouts/contentNavbarLayout')

@section('title', 'Tambah Ruangan')

@section('content')
<div class="container py-4">
    <div class="card border-primary" style="max-width:900px;margin:auto;">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0">Tambah Ruangan</h4>
                <a href="{{ route('ruangan.index') }}" class="btn btn-primary">
                    <i class="bx bx-arrow-back"></i> Kembali
                </a>
            </div>
            <form action="{{ route('ruangan.store') }}" method="POST" style="max-width:500px;">
                @csrf
                <div class="mb-3">
                    <label for="nama_ruangan" class="form-label">Nama Ruangan</label>
                    <input type="text" class="form-control @error('nama_ruangan') is-invalid @enderror" id="nama_ruangan" name="nama_ruangan" value="{{ old('nama_ruangan') }}" required>
                    @error('nama_ruangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection 