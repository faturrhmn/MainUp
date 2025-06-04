@extends('layouts.contentLayoutMaster')

@section('title', 'Preview Export Assets')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Preview Data Assets</h4>
                <div class="d-flex gap-2">
                    <a href="{{ route('export.assets', ['type' => 'pdf']) }}" class="btn btn-danger" target="_blank">
                        <i class="bx bxs-file-pdf me-1"></i> Download PDF
                    </a>
                    <a href="{{ route('export.assets', ['type' => 'excel']) }}" class="btn btn-success" target="_blank">
                        <i class="bx bxs-file me-1"></i> Download Excel
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Merk</th>
                                <th>Tahun</th>
                                <th>Jumlah</th>
                                <th>Ruangan</th>
                                <th>Keterangan</th>
                                <th>Siklus</th>
                                <th>Tanggal Mulai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($assets as $index => $asset)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $asset->nama_barang }}</td>
                                <td>{{ $asset->merk }}</td>
                                <td>{{ $asset->tahun }}</td>
                                <td>{{ $asset->jumlah }}</td>
                                <td>{{ $asset->ruangan->nama_ruangan ?? '-' }}</td>
                                <td>{{ $asset->keterangan }}</td>
                                <td>
                                    @if($asset->jadwals->isNotEmpty())
                                        {{ $asset->jadwals->first()->siklus }}
                                    @else
                                        Tidak Ada
                                    @endif
                                </td>
                                <td>
                                    @if($asset->jadwals->isNotEmpty())
                                        {{ \Carbon\Carbon::parse($asset->jadwals->first()->tanggal_mulai)->format('d-m-Y') }}
                                    @else
                                        Tidak Ada
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 