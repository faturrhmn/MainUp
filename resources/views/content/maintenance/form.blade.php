@extends('layouts/contentNavbarLayout')

@section('title', 'Form Maintenance Barang')

@section('vendor-style')
<link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
@endsection

@section('vendor-script')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
@endsection

@section('page-script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    new DataTable('#assetsTable', {
        processing: true,
        pageLength: 10,
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data per halaman",
            zeroRecords: "Tidak ada data yang ditemukan",
            info: "Menampilkan halaman _PAGE_ dari _PAGES_",
            infoEmpty: "Tidak ada data yang tersedia",
            infoFiltered: "(difilter dari _MAX_ total data)",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Selanjutnya",
                previous: "Sebelumnya"
            }
        },
        columnDefs: [
            { orderable: true, targets: '_all' }
        ],
        order: [[0, 'asc']]
    });
});
</script>
@endsection

<style>
.custom-card {
  background-color: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
  transition: all 0.3s ease;
}

.custom-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 6px 16px rgba(0,0,0,0.1);
}

.icon-wrapper {
  background-color: #f5f5f5;
  border-radius: 50%;
  width: 50px;
  height: 50px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.icon-wrapper i {
  font-size: 24px;
  color: #333;
}
</style>
@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Form Maintenance Barang</h4>
        <a href="{{ url()->previous() }}" class="btn btn-outline-primary"><i class="bx bx-arrow-back"></i> Kembali</a>
    </div>
    <form action="{{ isset($jadwal) ? route('maintenance.update', $jadwal->id_jadwal) : route('maintenance.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($jadwal))
            @method('PUT')
        @endif
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Nama Barang</label>
                    <input type="text" class="form-control" value="{{ $jadwal->asset->nama_barang ?? '' }}" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Merk</label>
                    <input type="text" class="form-control" value="{{ $jadwal->asset->merk ?? '' }}" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tahun</label>
                    <input type="text" class="form-control" value="{{ $jadwal->asset->tahun ?? '' }}" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal Perbaikan</label>
                    <input type="date" class="form-control" name="tanggal_perbaikan" value="{{ old('tanggal_perbaikan', $jadwal->tanggal_perbaikan ?? '') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Status Perbaikan</label>
                    <select class="form-select" name="status_perbaikan">
                        <option value="">Pilih Status Perbaikan</option>
                        <option value="proses" {{ (old('status_perbaikan', $jadwal->status_perbaikan ?? '') == 'proses') ? 'selected' : '' }}>Proses</option>
                        <option value="selesai" {{ (old('status_perbaikan', $jadwal->status_perbaikan ?? '') == 'selesai') ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Before Maintenance</label>
                    <input type="file" class="form-control" name="before_image">
                    <small class="text-muted">Max 1Mb. File: .jpg/.png/.pdf</small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Jumlah</label>
                    <input type="text" class="form-control" value="{{ $jadwal->asset->jumlah ?? '' }}" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Ruangan</label>
                    <input type="text" class="form-control" value="{{ $jadwal->asset->ruangan->nama_ruangan ?? '' }}" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea class="form-control" name="keterangan" rows="3">{{ old('keterangan', $jadwal->keterangan ?? '') }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">After Maintenance</label>
                    <input type="file" class="form-control" name="after_image">
                    <small class="text-muted">Max 1Mb. File: .jpg/.png/.pdf</small>
                </div>
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ url()->previous() }}" class="btn btn-danger">Cancel</a>
        </div>
    </form>
</div>
@endsection 