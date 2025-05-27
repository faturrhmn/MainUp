@extends('layouts/contentNavbarLayout')

@section('title', 'Detail Maintenance')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="card-title fw-bold">Detail Maintenance</h4>
        </div>

        <!-- Detail Barang -->
        <div class="row mb-4">
            <div class="col-md-6">
                <h6 class="fw-bold">Informasi Barang</h6>
                <p><strong>Nama Barang:</strong> {{ $maintenance->asset->nama_barang ?? '-' }}</p>
                <p><strong>Merk:</strong> {{ $maintenance->asset->merk ?? '-' }}</p>
                <p><strong>Tahun:</strong> {{ $maintenance->asset->tahun ?? '-' }}</p>
            </div>
            <div class="col-md-6">
                <h6 class="fw-bold">Detail Maintenance</h6>
                <p><strong>Tanggal Perbaikan:</strong> {{ $maintenance->tanggal_perbaikan ?? '-' }}</p>
                <p><strong>Status:</strong> 
                    @if($maintenance->status == 'selesai')
                        <span class="badge bg-success">Selesai</span>
                    @else
                        <span class="badge bg-warning text-dark">Proses</span>
                    @endif
                </p>
                <p><strong>PIC:</strong> {{ $maintenance->pic ?? '-' }}</p>
                <p><strong>Teknisi:</strong><br>{{ $maintenance->teknisi ?? '-' }}</p>
                <p><strong>Keterangan:</strong><br>{{ $maintenance->keterangan ?? '-' }}</p>
            </div>
        </div>

        <hr>

        <!-- Gambar Sebelum Perbaikan -->
        @if($maintenance->beforeImages && $maintenance->beforeImages->count())
            <h6 class="fw-bold">Gambar Sebelum Perbaikan:</h6>
            <div class="mb-4">
                @foreach($maintenance->beforeImages as $image)
                    <div class="d-inline-block me-3 mb-3" style="max-width: 200px;">
                        <img src="{{ Storage::url('maintenance/before/' . $image->hashed_name) }}" 
                             alt="Before Image"
                             class="img-thumbnail"
                             style="width: 200px; height: 150px; object-fit: cover;">
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Gambar Setelah Perbaikan -->
        @if($maintenance->afterImages && $maintenance->afterImages->count())
            <h6 class="fw-bold">Gambar Setelah Perbaikan:</h6>
            <div class="mb-4">
                @foreach($maintenance->afterImages as $image)
                    <div class="d-inline-block me-3 mb-3" style="max-width: 200px;">
                        <img src="{{ Storage::url('maintenance/after/' . $image->hashed_name) }}" 
                             alt="After Image"
                             class="img-thumbnail"
                             style="width: 200px; height: 150px; object-fit: cover;">
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
