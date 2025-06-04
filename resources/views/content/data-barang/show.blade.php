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
                            <div class="d-flex gap-2">
                                <a href="{{ route('export.assets.detail', ['id' => $asset->id_aset, 'type' => 'pdf']) }}" class="btn btn-danger" target="_blank">
                                    <i class="bx bxs-file-pdf me-1"></i> Export PDF
                                </a>
                                <a href="{{ route('data-barang.index') }}" class="btn btn-outline-primary">
                                    <i class="bx bx-arrow-back me-1"></i> Kembali
                                </a>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">No Aset</label>
                                    <p>{{ $asset->nomor_aset ?? '-' }}</p>
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
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Tipe Barang</label>
                                    <p>{{ $asset->tipe }}</p>
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
@if($asset->maintenance && $asset->maintenance->isNotEmpty())
<div class="card mt-4">
    <div class="card-body">
        <h5 class="card-title fw-bold">History Maintenance</h5>
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>Tanggal Perbaikan</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($asset->maintenance->sortByDesc('created_at') as $maintenance)
                        <tr>
                            <td>{{ $maintenance->tanggal_perbaikan ? \Carbon\Carbon::parse($maintenance->tanggal_perbaikan)->format('d/m/Y') : '-' }}</td>
                            <td>
                                @if($maintenance->status == 'proses')
                                    <span class="badge bg-warning">Proses</span>
                                @else
                                    <span class="badge bg-success">Selesai</span>
                                @endif
                            </td>
                            <td>{{ $maintenance->keterangan ?? '-' }}</td>
                            <td>
                                <a href="{{ route('maintenance.detail', $maintenance->id_maintenance) }}" class="btn btn-primary btn-sm">
                                    <i class="bx bx-show me-1"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@else
    <div class="card mt-4">
        <div class="card-body">
            <p class="text-muted text-center">Belum ada history maintenance untuk barang ini.</p>
        </div>
    </div>
@endif

@endsection
