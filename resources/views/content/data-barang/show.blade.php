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
                                    <p>{{ $asset->ruangan->nama_ruangan }}</p>
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

<!-- History Maintenance -->
<!-- History Maintenance -->
<div class="card mt-4">
    <div class="card-body">
        <h5 class="card-title fw-bold">History Maintenance</h5>
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>Tanggal Perbaikan</th>
                        <th>Status Perbaikan</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($asset->maintenance as $maint)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($maint->tanggal_perbaikan)->format('d/m/Y') }}</td>
                        <td>{{ $maint->status ?? '-' }}</td>
                        <td>{{ $maint->keterangan ?? '-' }}</td>
                        <td>
                            <a href="{{ route('maintenance.detail', ['id_maintenance' => $maint->id_maintenance]) }}" 
                               class="btn btn-outline-secondary btn-sm" 
                               title="Lihat Detail Maintenance">
                                <i class="bx bx-show"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">Belum ada history maintenance.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
