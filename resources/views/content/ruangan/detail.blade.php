@extends('layouts/contentNavbarLayout')

@section('title', 'Detail Ruangan')

@section('content')
<div class="container" style="border: 3px solidrgb(12, 12, 12); border-radius: 6px; padding: 32px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Detail Ruangan</h4>
        <a href="javascript:history.back()" class="btn btn-primary">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Merk</th>
                    <th>Tahun</th>
                    <th>Jumlah</th>
                    <th>Type</th>
                    <th>Ruangan</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($assets as $asset)
                <tr>
                    <td>{{ $asset->nama_barang }}</td>
                    <td>{{ $asset->merk }}</td>
                    <td>{{ $asset->tahun }}</td>
                    <td>{{ $asset->jumlah }}</td>
                    <td>{{ $asset->type }}</td>
                    <td>{{ $asset->ruangan->nama_ruangan ?? '-' }}</td>
                    <td>{{ $asset->keterangan }}</td>
                    <td>
                        <a href="{{ route('detail-barang', $asset->id_aset) }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bx bx-info-circle me-1"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection 