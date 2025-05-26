@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Maintenance')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="card-title fw-bold">Form Maintenance</h4>
            <a href="{{ route('maintenance.proses') }}" class="btn btn-outline-primary">
                <i class="bx bx-arrow-back"></i> Kembali
            </a>
        </div>

        <form action="{{ route('maintenance.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id_jadwal" value="{{ $jadwal->id_jadwal }}">
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
                <label for="tanggal_perbaikan" class="form-label">Tanggal Perbaikan</label>
                <input type="date" name="tanggal_perbaikan" id="tanggal_perbaikan"
                    class="form-control @error('tanggal_perbaikan') is-invalid @enderror"
                    value="{{ old('tanggal_perbaikan', $maintenance->tanggal_perbaikan ?? '') }}">

                @error('tanggal_perbaikan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="pic">PIC</label>
                <input type="text" name="pic" class="form-control" value="{{ old('pic', $maintenance->pic ?? '') }}">
            </div>

            <div class="mb-3">
                <label for="teknisi">Teknisi</label>
                <textarea name="teknisi" class="form-control" rows="3">{{ old('teknisi', $maintenance->teknisi ?? '') }}</textarea>
            </div>


            <div class="mb-3">
                <label for="status_perbaikan" class="form-label">Status Perbaikan</label>
                <select name="status_perbaikan" id="status_perbaikan" class="form-control">
                    <option value="proses" {{ old('status_perbaikan', $maintenance->status ?? '') == 'proses' ? 'selected' : '' }}>Proses</option>
                    <option value="selesai" {{ old('status_perbaikan', $maintenance->status ?? '') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea name="keterangan" id="keterangan" class="form-control" oninput="autoResize(this)">{{ old('keterangan', $maintenance->keterangan ?? '') }}</textarea>
            </div>


            <div class="mb-3">
                <label for="before_maintenance" class="form-label">Gambar Sebelum Perbaikan</label>
                <input type="file" name="before_maintenance" id="before_maintenance" class="form-control">
                @if($beforeImages)
                    <div class="mt-3">
                        <h5>Gambar Sebelumnya:</h5>
                        @foreach($beforeImages as $image)
                        <img src="{{ Storage::url('maintenance/before/' . $image->hashed_name) }}" alt="Before Image" class="img-fluid" style="max-width: 200px;">
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="mb-3">
                <label for="after_maintenance" class="form-label">Gambar Setelah Perbaikan</label>
                <input type="file" name="after_maintenance" id="after_maintenance" class="form-control">
                @if($afterImages)
                    <div class="mt-3">
                        <h5>Gambar Setelah:</h5>
                        @foreach($afterImages as $image)
                        <img src="{{ Storage::url('maintenance/after/' . $image->hashed_name) }}" alt="After Image" class="img-fluid" style="max-width: 200px;">

                        @endforeach
                    </div>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>

<script>
    function autoResize(textarea) {
        textarea.style.height = 'auto'; // Reset height
        textarea.style.height = textarea.scrollHeight + 'px'; // Set new height
    }

    // Auto-resize saat halaman dimuat (jika ada nilai awal)
    window.addEventListener('DOMContentLoaded', function () {
        const textarea = document.getElementById('keterangan');
        if (textarea) autoResize(textarea);
    });
</script>

@endsection
