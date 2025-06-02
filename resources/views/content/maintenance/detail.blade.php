@extends('layouts/contentNavbarLayout')

@section('title', 'Detail Maintenance')

@section('content')
<div class="card">
    <div class="card-body">
    <div class="d-flex justify-content-end mt-4">
{{--            <x-export-buttons route="export.maintenance.detail" :params="['id_maintenance' => $maintenance->id_maintenance]" />--}}
             <a href="{{ route('export.maintenance.detail', ['id_maintenance' => $maintenance->id_maintenance, 'type' => 'pdf']) }}" class="btn btn-danger" id="pdfBtn-export.maintenance.detail">
                <i class="bx bxs-file-pdf me-1"></i>
                Export PDF
            </a>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="card-title fw-bold">Detail Maintenance</h4>
        </div>
        
        <!-- Detail Barang -->
        <div class="row mb-4">
            <div class="col-md-6">
                <h6 class="fw-bold">Informasi Barang</h6>
                <p><strong>ID Barang:</strong> {{ $maintenance->asset->id_aset ?? '-' }}</p>
                <p><strong>Nama Barang:</strong> {{ $maintenance->asset->nama_barang ?? '-' }}</p>
                <p><strong>Merk:</strong> {{ $maintenance->asset->merk ?? '-' }}</p>
                <p><strong>Tahun:</strong> {{ $maintenance->asset->tahun ?? '-' }}</p>
                <p><strong>Jumlah:</strong> {{ $maintenance->asset->jumlah ?? '-' }}</p>
                <p><strong>Ruangan:</strong> {{ $maintenance->asset->ruangan->nama_ruangan ?? '-' }}</p>
                <p><strong>Tipe:</strong> {{ $maintenance->asset->tipe ?? '-' }}</p>
                <p><strong>Keterangan:</strong> {{ $maintenance->asset->keterangan ?? '-' }}</p>
                @php
                    $jadwal = $maintenance->asset->jadwals->first();
                    $siklusLabel = '-';
                    if(isset($jadwal->siklus)) {
                        switch($jadwal->siklus) {
                            case 'hari': $siklusLabel = 'Harian'; break;
                            case 'minggu': $siklusLabel = 'Mingguan'; break;
                            case 'bulan': $siklusLabel = 'Bulanan'; break;
                            case '3_bulan': $siklusLabel = '3 Bulan'; break;
                            case '6_bulan': $siklusLabel = '6 Bulan'; break;
                            case '1_tahun': $siklusLabel = '1 Tahun'; break;
                            default: $siklusLabel = ucfirst(str_replace('_', ' ', $jadwal->siklus)); break;
                        }
                    }
                @endphp
                <p><strong>Siklus:</strong> {{ $siklusLabel }}</p>
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

        <h5 class="card-title text-primary mt-4">Before Images</h5>
        <!-- Gambar Sebelum Perbaikan -->
        @if($maintenance->beforeImages && $maintenance->beforeImages->count())
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

        <h5 class="card-title text-primary mt-4">After Images</h5>
        <!-- Gambar Setelah Perbaikan -->
        @if($maintenance->afterImages && $maintenance->afterImages->count())
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

        <!-- Tambahkan tombol export baru untuk Detail Maintenance -->
        
    </div>
</div>
@endsection
