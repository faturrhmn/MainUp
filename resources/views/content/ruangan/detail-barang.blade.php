@extends('layouts/contentNavbarLayout')

@section('title', 'Detail Barang')

@section('content')
<div class="container" style="border-radius: 10px; background: #fff; padding: 32px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 text-primary">Detail Barang</h4>
        <a href="javascript:history.back()" class="btn btn-outline-primary">
            <i class="bx bx-arrow-back"></i> Kembali
        </a>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <span class="fw-bold">ID Barang</span><br>
                {{ $asset->id }}
            </div>
            <div class="mb-3">
                <span class="fw-bold">Nama Barang</span><br>
                {{ $asset->nama_barang }}
            </div>
            <div class="mb-3">
                <span class="fw-bold">Merk</span><br>
                {{ $asset->merk }}
            </div>
            <div class="mb-3">
                <span class="fw-bold">Tahun</span><br>
                {{ $asset->tahun }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <span class="fw-bold">Jumlah</span><br>
                {{ $asset->jumlah }}
            </div>
            <div class="mb-3">
                <span class="fw-bold">Ruangan</span><br>
                {{ $asset->ruangan->nama_ruangan ?? '-' }}
            </div>
            <div class="mb-3">
                <span class="fw-bold">Keterangan</span><br>
                {{ $asset->keterangan }}
            </div>
        </div>
    </div>
</div>
@endsection 