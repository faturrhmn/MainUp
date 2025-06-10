@extends('layouts/contentNavbarLayout')

@section('title', 'Detail Maintenance')

@section('content')
<div class="card">
    <div class="card-body">
    <div class="d-flex justify-content-end mt-4">
        <a href="{{ route('export.maintenance.detail', ['id_maintenance' => $maintenance->id_maintenance, 'type' => 'pdf']) }}" class="btn btn-outline-secondary" target="_blank">
            <i class="bx bxs-file-pdf me-1 text-danger"></i> Export PDF
        </a>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="card-title fw-bold">Detail Maintenance</h4>
    </div>
    
    <!-- Detail Barang -->
    <div class="row mb-4">
        <div class="col-md-6">
            <h6 class="fw-bold">Informasi Barang</h6>
            <p><strong>No Aset:</strong> {{ $maintenance->asset->nomor_aset ?? '-' }}</p>
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
        <div class="row">
            @foreach($maintenance->beforeImages as $image)
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <img src="{{ asset('assets/maintenance/before/' . $image->hashed_name) }}" 
                             class="card-img-top" 
                             alt="Before Maintenance Image"
                             loading="lazy"
                             style="max-height: 300px; object-fit: contain;">
                        @if($image->keterangan)
                            <div class="card-body">
                                <p class="card-text">{{ $image->keterangan }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <h5 class="card-title text-primary mt-4">After Images</h5>
    <!-- Gambar Setelah Perbaikan -->
    @if($maintenance->afterImages && $maintenance->afterImages->count())
        <div class="row">
            @foreach($maintenance->afterImages as $image)
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <img src="{{ asset('assets/maintenance/after/' . $image->hashed_name) }}" 
                             class="card-img-top" 
                             alt="After Maintenance Image"
                             loading="lazy"
                             style="max-height: 300px; object-fit: contain;">
                        @if($image->keterangan)
                            <div class="card-body">
                                <p class="card-text">{{ $image->keterangan }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <hr>

    <!-- Tabel History Perbaikan -->
    @if($maintenance->history && $maintenance->history->isNotEmpty())
        <div class="mt-4">
            <h5 class="card-title fw-bold">Riwayat Perbaikan</h5>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>Tanggal Perbaikan</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Loop melalui history dari maintenance saat ini --}}
                        @foreach($maintenance->history->sortByDesc('created_at') as $history)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($history->tanggal_perbaikan)->format('d/m/Y') }}</td>
                                <td>{{ $history->keterangan ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        {{-- Pesan jika tidak ada history untuk maintenance ini --}}
        {{-- <div class="mt-4">
            <p class="text-muted">Tidak ada riwayat perbaikan untuk maintenance ini.</p>
        </div> --}}
    @endif

    <!-- Tambahkan tombol export baru untuk Detail Maintenance -->
    
</div>
</div>
@endsection
