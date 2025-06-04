@extends('layouts.contentLayoutMaster')

@section('title', 'Preview Export Ruangan')

@section('content')
<div class="container-xxl">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Preview Export Ruangan</h5>
            <a href="{{ route('export.download.ruangan') }}" class="btn btn-primary" target="_blank">
                <i class="bx bx-download me-1"></i> Download PDF
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Ruangan</th>
                            <th>Lokasi</th>
                            <th>Kapasitas</th>
                            <th>Jumlah Barang</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ruangans as $index => $ruangan)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $ruangan->nama_ruangan }}</td>
                            <td>{{ $ruangan->lokasi }}</td>
                            <td>{{ $ruangan->kapasitas }}</td>
                            <td>{{ $ruangan->dataBarang->count() }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 