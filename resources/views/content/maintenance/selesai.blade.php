@extends('layouts/contentNavbarLayout')

@section('title', 'Maintenance Barang Selesai')

@section('vendor-style')
<link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet" />
@endsection

@section('vendor-script')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
@endsection

@section('page-script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    new DataTable('#maintenanceTable', {
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
        columnDefs: [{ orderable: true, targets: '_all' }],
        order: [[3, 'asc']]
    });
});
</script>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="card-title fw-bold">Maintenance Barang Selesai</h4>
            <a href="{{ url()->previous() }}" class="btn btn-outline-primary">
                <i class="bx bx-arrow-back"></i> Kembali
            </a>
        </div>
        <div class="table-responsive">
            <table id="maintenanceTable" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Merk</th>
                        <th>Ruangan</th>
                        <th>Tanggal Perbaikan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $item)
                    <tr>
                        <td>{{ $item->asset->nama_barang ?? '-' }}</td>
                        <td>{{ $item->asset->merk ?? '-' }}</td>
                        <td>{{ $item->asset->ruangan->nama_ruangan ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_perbaikan)->format('d-m-Y') }}</td>
                        <td>
                            @if($item->status === 'selesai')
                                <span class="badge bg-success">Selesai</span>
                            @else
                                <span class="badge bg-warning text-dark">{{ ucfirst($item->status) }}</span>
                            @endif
                        </td>
                        <td>
                            <a href="#" 
                               class="btn btn-outline-secondary btn-sm" 
                               title="Lihat Detail">
                                <i class="bx bx-show"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada barang yang telah selesai maintenance.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
