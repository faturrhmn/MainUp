@extends('layouts.contentLayoutMaster')

@section('title', 'Preview Export Detail Maintenance')

@section('content')
<div class="container-xxl">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Preview Export Detail Maintenance</h5>
            <a href="{{ route('export.download.maintenance.detail', $maintenance->id) }}" class="btn btn-primary" target="_blank">
                <i class="bx bx-download me-1"></i> Download PDF
            </a>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h6>Informasi Maintenance</h6>
                    <table class="table table-bordered">
                        <tr>
                            <th width="200">Tanggal</th>
                            <td>{{ $maintenance->tanggal }}</td>
                        </tr>
                        <tr>
                            <th>Barang</th>
                            <td>{{ $maintenance->dataBarang->nama_barang }}</td>
                        </tr>
                        <tr>
                            <th>Ruangan</th>
                            <td>{{ $maintenance->ruangan->nama_ruangan }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>{{ $maintenance->status }}</td>
                        </tr>
                        <tr>
                            <th>Keterangan</th>
                            <td>{{ $maintenance->keterangan }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            @if($maintenance->beforeImages->count() > 0)
            <div class="row mb-4">
                <div class="col-12">
                    <h6>Foto Sebelum</h6>
                    <div class="row">
                        @foreach($maintenance->beforeImages as $image)
                        <div class="col-md-3 mb-3">
                            <img src="{{ asset('storage/' . $image->path) }}" class="img-fluid rounded" alt="Before Image">
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            @if($maintenance->afterImages->count() > 0)
            <div class="row">
                <div class="col-12">
                    <h6>Foto Sesudah</h6>
                    <div class="row">
                        @foreach($maintenance->afterImages as $image)
                        <div class="col-md-3 mb-3">
                            <img src="{{ asset('storage/' . $image->path) }}" class="img-fluid rounded" alt="After Image">
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection 