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

        <!-- Form utama: update data maintenance dan upload gambar baru -->
        <form action="{{ route('maintenance.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id_jadwal" value="{{ $jadwal->id_jadwal }}">
            @if(isset($maintenance))
                <input type="hidden" name="id_maintenance" value="{{ $maintenance->id_maintenance }}">
            @endif

            <div class="row">
                <!-- Kolom kiri -->
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
                        <label for="tanggal_perbaikan" class="form-label">Tanggal Perbaikan</label>
                        <input type="date" name="tanggal_perbaikan" id="tanggal_perbaikan"
                            class="form-control @error('tanggal_perbaikan') is-invalid @enderror"
                            value="{{ old('tanggal_perbaikan', $maintenance->tanggal_perbaikan ?? '') }}">
                        @error('tanggal_perbaikan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="status_perbaikan" class="form-label">Status Perbaikan</label>
                        <select name="status_perbaikan" id="status_perbaikan"
                            class="form-control @error('status_perbaikan') is-invalid @enderror">
                            <option value="proses" {{ old('status_perbaikan', $maintenance->status ?? '') == 'proses' ? 'selected' : '' }}>Proses</option>
                            <option value="selesai" {{ old('status_perbaikan', $maintenance->status ?? '') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                        @error('status_perbaikan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="before_maintenance" class="form-label">Gambar Sebelum Perbaikan (upload baru)</label>
                        <input type="file" name="before_maintenance[]" id="before_maintenance"
                            class="form-control @error('before_maintenance') is-invalid @enderror @error('before_maintenance.*') is-invalid @enderror"
                            multiple>
                        @error('before_maintenance')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @error('before_maintenance.*')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Kolom kanan -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="pic" class="form-label">PIC</label>
                        <input type="text" name="pic" id="pic"
                            class="form-control @error('pic') is-invalid @enderror"
                            value="{{ old('pic', $maintenance->pic ?? '') }}">
                        @error('pic')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="teknisi" class="form-label">Teknisi</label>
                        <textarea name="teknisi" id="teknisi"
                            class="form-control @error('teknisi') is-invalid @enderror" rows="3">{{ old('teknisi', $maintenance->teknisi ?? '') }}</textarea>
                        @error('teknisi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea name="keterangan" id="keterangan"
                            class="form-control @error('keterangan') is-invalid @enderror"
                            oninput="autoResize(this)">{{ old('keterangan', $maintenance->keterangan ?? '') }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="after_maintenance" class="form-label">Gambar Setelah Perbaikan (upload baru)</label>
                        <input type="file" name="after_maintenance[]" id="after_maintenance"
                            class="form-control @error('after_maintenance') is-invalid @enderror @error('after_maintenance.*') is-invalid @enderror"
                            multiple>
                        @error('after_maintenance')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @error('after_maintenance.*')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>

        <hr>

        <!-- Form hapus gambar BEFORE -->
        @if(!empty($beforeImages))
            <form action="{{ route('maintenance.before_image.batch_destroy') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus gambar sebelum perbaikan yang dipilih?')">
                @csrf
                <h5>Gambar Sebelum Perbaikan:</h5>
                <div class="mb-3">
                    @forelse($beforeImages as $image)
                        <label class="d-inline-block position-relative me-3 mb-3" style="max-width: 200px; cursor: pointer;">
                            <img src="{{ Storage::url('maintenance/before/' . $image->hashed_name) }}" 
                                 alt="Before Image" 
                                 class="img-fluid"  
                                 style="width: 200px; height: 150px; object-fit: cover; display: block;"
                                 onerror="this.onerror=null; this.src='{{ asset('assets/img/error-image.png') }}';">
                            <input type="checkbox" name="image_ids[]" value="{{ $image->id }}" class="form-check-input position-absolute top-0 start-0 m-2">
                        </label>
                    @empty
                        <p class="text-muted">Tidak ada gambar sebelum perbaikan</p>
                    @endforelse
                </div>
                <button type="submit" class="btn btn-danger">Hapus Gambar Sebelum Terpilih</button>
            </form>
        @else
            <p class="text-muted">Tidak ada gambar sebelum perbaikan</p>
        @endif

        <hr>

        <!-- Form hapus gambar AFTER -->
        @if(!empty($afterImages))
            <form action="{{ route('maintenance.after_image.batch_destroy') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus gambar setelah perbaikan yang dipilih?')">
                @csrf
                <h5>Gambar Setelah Perbaikan:</h5>
                <div class="mb-3">
                    @forelse($afterImages as $image)
                        <label class="d-inline-block position-relative me-3 mb-3" style="max-width: 200px; cursor: pointer;">
                            <img src="{{ Storage::url('maintenance/after/' . $image->hashed_name) }}" 
                                 alt="After Image" 
                                 class="img-fluid"  
                                 style="width: 200px; height: 150px; object-fit: cover; display: block;"
                                 onerror="this.onerror=null; this.src='{{ asset('assets/img/error-image.png') }}';">
                            <input type="checkbox" name="image_ids[]" value="{{ $image->id }}" class="form-check-input position-absolute top-0 start-0 m-2">
                        </label>
                    @empty
                        <p class="text-muted">Tidak ada gambar setelah perbaikan</p>
                    @endforelse
                </div>
                <button type="submit" class="btn btn-danger">Hapus Gambar Setelah Terpilih</button>
            </form>
        @else
            <p class="text-muted">Tidak ada gambar setelah perbaikan</p>
        @endif
    </div>
</div>

<script>
    function autoResize(textarea) {
        textarea.style.height = 'auto'; // Reset height
        textarea.style.height = textarea.scrollHeight + 'px'; // Set new height
    }

    window.addEventListener('DOMContentLoaded', function () {
        const textarea = document.getElementById('keterangan');
        if (textarea) autoResize(textarea);
    });
</script>

@endsection
