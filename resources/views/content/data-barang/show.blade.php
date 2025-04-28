@extends('layouts/contentNavbarLayout')

@section('title', 'Detail Barang')

@section('content')
<div class="row">
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-sm-12">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title text-primary">Detail Barang</h5>
                            <a href="{{ route('data-barang') }}" class="btn btn-outline-primary">
                                <i class="bx bx-arrow-back me-1"></i> Kembali
                            </a>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">ID Barang</label>
                                    <p>{{ $asset->id_aset }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Nama Barang</label>
                                    <p>{{ $asset->nama_barang }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Merk</label>
                                    <p>{{ $asset->merk }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Tahun</label>
                                    <p>{{ $asset->tahun }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Jumlah</label>
                                    <p>{{ $asset->jumlah }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Ruangan</label>
                                    <p>{{ $asset->ruangan->nama_ruangan ?? '-' }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Keterangan</label>
                                    <p>{{ $asset->keterangan }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 