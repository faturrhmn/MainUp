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
{{-- Tampilkan kartu history jika ada record maintenance --}}
@if($asset->maintenance && $asset->maintenance->isNotEmpty())
<div class="card mt-4">
    <div class="card-body">
        <h5 class="card-title fw-bold">History Maintenance</h5>
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>Tanggal Perbaikan</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Loop melalui SEMUA record maintenance, lalu tampilkan history masing-masing --}}
                    @forelse($asset->maintenance as $maint)
                        {{-- Pastikan record maintenance ini punya history --}}
                        @if($maint->history && $maint->history->isNotEmpty())
                            {{-- Menggunakan relasi history yang sudah di-load dan mengurutkan --}}
                            @foreach($maint->history->sortByDesc('created_at') as $history)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($history->tanggal_perbaikan)->format('d/m/Y H:i') }}</td>
                                    <td>{{ $history->keterangan ?? '-' }}</td>
                                </tr>
                            @endforeach
                        @endif
                    @empty
                    {{-- Pesan jika tidak ada record maintenance sama sekali untuk aset ini --}}
                    <tr>
                        <td colspan="2" class="text-center">Belum ada history maintenance untuk barang ini.</td>
                    </tr>
                    @endforelse

                    {{-- Opsional: Pesan jika ada record maintenance tapi tidak satupun punya history --}}
                    {{-- @if($asset->maintenance->isNotEmpty() && $asset->maintenance->every(fn($maint) => $maint->history->isEmpty()))
                         <tr>
                            <td colspan="2" class="text-center">Semua record maintenance tidak memiliki riwayat.</td>
                        </tr>
                    @endif --}}

                </tbody>
            </table>
        </div>
    </div>
</div>
@else
    {{-- Pesan jika tidak ada record maintenance sama sekali untuk aset ini --}}
    <div class="card mt-4">
        <div class="card-body">
            <p class="text-muted text-center">Belum ada history maintenance untuk barang ini.</p>
        </div>
    </div>
@endif

@endsection
