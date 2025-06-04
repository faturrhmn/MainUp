@extends('layouts/contentNavbarLayout')

@section('title', 'Tambah Data Barang')

@section('vendor-style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
@endsection

@section('vendor-script')
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection

@section('page-script')
<script>
$(document).ready(function() {
    $('#ruangan').select2({
        theme: 'bootstrap-5',
        placeholder: 'Pilih Ruangan',
        allowClear: true,
        width: '100%'
    });
    $('#siklus').select3({
        theme: 'bootstrap-5',
        placeholder: 'Pilih Siklus Maintenance',
        allowClear: true,
        width: '100%'
    });
});
</script>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-sm-12">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title text-primary">Tambah Data Barang</h5>
                            <a href="{{ route('data-barang.index') }}" class="btn btn-outline-primary">
                                <i class="bx bx-arrow-back me-1"></i> Kembali
                            </a>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('data-barang.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="nama_barang">Nama Barang</label>
                                        <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="merk">Merk</label>
                                        <input type="text" class="form-control" id="merk" name="merk" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="tahun">Tahun</label>
                                        <input type="number" class="form-control" id="tahun" name="tahun" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="tipe">Tipe Barang</label>
                                        <select class="form-select" id="tipe" name="tipe" required>
                                            <option value="">Pilih Tipe Barang</option>
                                            <option value="preventive" {{ old('tipe') == 'preventive' ? 'selected' : '' }}>Preventive</option>
                                            <option value="corrective" {{ old('tipe') == 'corrective' ? 'selected' : '' }}>Corrective</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="siklus">Siklus Maintenance</label>
                                        <select class="form-select" id="siklus" name="siklus" required>
                                            <option value="">Pilih Siklus Maintenance</option>
                                            @foreach(App\Models\Jadwal::SIKLUS_OPTIONS as $value => $label)
                                                <option value="{{ $value }}" {{ old('siklus') == $value ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="tanggal_mulai">Tanggal Mulai</label>
                                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="jumlah">Jumlah</label>
                                        <input type="number" class="form-control" id="jumlah" name="jumlah" min="1" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="ruangan">Ruangan</label>
                                        <select class="form-select" id="ruangan" name="ruangan" required>
                                            <option value="">Pilih Ruangan</option>
                                            @foreach($ruangans as $ruangan)
                                                <option value="{{ $ruangan->id_ruangan }}">{{ $ruangan->nama_ruangan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="keterangan">Keterangan</label>
                                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 