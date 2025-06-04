@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Data Barang')

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

    // Function to toggle preventive fields visibility
    function togglePreventiveFields() {
        var tipe = $('#tipe').val();
        if (tipe === 'preventive') {
            $('#preventive-fields').show();
            $('#siklus').prop('required', true);
            $('#tanggal_mulai').prop('required', true);
        } else {
            $('#preventive-fields').hide();
            $('#siklus').prop('required', false);
            $('#tanggal_mulai').prop('required', false);
        }
    }

    // Initial call on page load
    togglePreventiveFields();

    // Call on tipe change
    $('#tipe').change(function() {
        togglePreventiveFields();
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
                            <h5 class="card-title text-primary">Edit Data Barang</h5>
                            <a href="{{ route('data-barang') }}" class="btn btn-outline-primary">
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

                        <form action="{{ route('data-barang.update', $asset->id_aset) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="nama_barang">Nama Barang</label>
                                        <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="{{ $asset->nama_barang }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="merk">Merk</label>
                                        <input type="text" class="form-control" id="merk" name="merk" value="{{ $asset->merk }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="tahun">Tahun</label>
                                        <input type="number" class="form-control" id="tahun" name="tahun" value="{{ $asset->tahun }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="tipe">Tipe Barang</label>
                                        <select class="form-select" id="tipe" name="tipe" required>
                                            <option value="">Pilih Tipe Barang</option>
                                            <option value="preventive" {{ old('tipe', $asset->tipe) == 'preventive' ? 'selected' : '' }}>Preventive</option>
                                            <option value="corrective" {{ old('tipe', $asset->tipe) == 'corrective' ? 'selected' : '' }}>Corrective</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="jumlah">Jumlah</label>
                                        <input type="number" class="form-control" id="jumlah" name="jumlah" value="{{ $asset->jumlah }}" min="1" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="ruangan">Ruangan</label>
                                        <select class="form-select" id="ruangan" name="ruangan" required>
                                            <option value="">Pilih Ruangan</option>
                                            @foreach($ruangans as $ruangan)
                                                <option value="{{ $ruangan->id_ruangan }}" {{ $asset->id_ruangan == $ruangan->id_ruangan ? 'selected' : '' }}>
                                                    {{ $ruangan->nama_ruangan }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="keterangan">Keterangan</label>
                                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3">{{ $asset->keterangan }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Siklus & Tanggal Mulai -->
                            <div class="row" id="preventive-fields">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="siklus">Siklus Maintenance</label>
                                        <select class="form-select" id="siklus" name="siklus" required>
                                            <option value="">Pilih Siklus Maintenance</option>
                                            <option value="hari" {{ $asset->jadwals->isNotEmpty() && old('siklus', $asset->jadwals->first()->siklus) == 'hari' ? 'selected' : '' }}>Hari</option>
                                            <option value="minggu" {{ $asset->jadwals->isNotEmpty() && old('siklus', $asset->jadwals->first()->siklus) == 'minggu' ? 'selected' : '' }}>Minggu</option>
                                            <option value="bulan" {{ $asset->jadwals->isNotEmpty() && old('siklus', $asset->jadwals->first()->siklus) == 'bulan' ? 'selected' : '' }}>Bulan</option>
                                            <option value="3_bulan" {{ $asset->jadwals->isNotEmpty() && old('siklus', $asset->jadwals->first()->siklus) == '3_bulan' ? 'selected' : '' }}>3 Bulan</option>
                                            <option value="6_bulan" {{ $asset->jadwals->isNotEmpty() && old('siklus', $asset->jadwals->first()->siklus) == '6_bulan' ? 'selected' : '' }}>6 Bulan</option>
                                            <option value="1_tahun" {{ $asset->jadwals->isNotEmpty() && old('siklus', $asset->jadwals->first()->siklus) == '1_tahun' ? 'selected' : '' }}>1 Tahun</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="tanggal_mulai">Tanggal Mulai</label>
                                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="{{ $asset->jadwals->isNotEmpty() ? old('tanggal_mulai', \Carbon\Carbon::parse($asset->jadwals->first()->tanggal_mulai)->format('Y-m-d')) : old('tanggal_mulai') }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
