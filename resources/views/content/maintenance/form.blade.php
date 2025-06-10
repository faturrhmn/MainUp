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
                            @php
                                $imagePath = public_path('assets/maintenance/before/' . $image->hashed_name);
                                $imageUrl = file_exists($imagePath) 
                                    ? asset('assets/maintenance/before/' . $image->hashed_name)
                                    : asset('assets/img/error-image.png');
                            @endphp
                            <img src="{{ $imageUrl }}" 
                                 alt="Before Image" 
                                 class="img-fluid"  
                                 style="width: 200px; height: 150px; object-fit: cover; display: block;">
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
                            @php
                                $imagePath = public_path('assets/maintenance/after/' . $image->hashed_name);
                                $imageUrl = file_exists($imagePath) 
                                    ? asset('assets/maintenance/after/' . $image->hashed_name)
                                    : asset('assets/img/error-image.png');
                            @endphp
                            <img src="{{ $imageUrl }}" 
                                 alt="After Image" 
                                 class="img-fluid"  
                                 style="width: 200px; height: 150px; object-fit: cover; display: block;">
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

        <hr>

        <!-- Tabel History Perbaikan (Hanya tampil jika status maintenance = 'proses') -->
        @if(isset($maintenance) && $maintenance->status == 'proses' && $maintenance->history && $maintenance->history->isNotEmpty())
            <div class="mt-4">
                <h5>Riwayat Perbaikan:</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Tanggal Perbaikan</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($maintenance->history()->orderBy('created_at', 'desc')->get() as $history)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($history->tanggal_perbaikan)->format('d-m-Y') }}</td>
                                    <td>{{ $history->keterangan ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            {{-- Hanya tampilkan pesan jika ada record maintenance tapi belum ada history --}}
            @if(isset($maintenance))
                <p class="text-muted">Belum ada riwayat perbaikan</p>
            @endif
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

<script>
    document.querySelector('form').addEventListener('submit', function(event) {
        // Ini akan mencegah perilaku submit default jika ada handler lain,
        // tapi kemudian kita submit ulang secara manual untuk memastikan native submit
        event.preventDefault();
        this.submit();
    });
</script>

<script>
    // Script to force redirect after success message appears
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            // Check if an alert with class 'alert-success' is added
            if (mutation.addedNodes && mutation.addedNodes.length > 0) {
                mutation.addedNodes.forEach(function(node) {
                    if (node.nodeType === 1 && node.classList.contains('alert-success')) {
                        // Success alert found, wait a moment then redirect
                        setTimeout(function() {
                            window.location.href = '{{ route('maintenance.proses') }}';
                        }, 2000); // Redirect after 2 seconds (adjust as needed)
                        observer.disconnect(); // Stop observing once found
                    }
                });
            }
        });
    });

    // Start observing the body for added nodes
    observer.observe(document.body, { childList: true, subtree: true });

</script>

@endsection
