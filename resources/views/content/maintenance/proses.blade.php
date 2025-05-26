@extends('layouts/contentNavbarLayout')

@section('title', 'Maintenance Barang Processed')

@section('vendor-style')
<link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
@endsection

@section('vendor-script')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
@endsection

@section('page-script')
<script>
document.addEventListener('DOMContentLoaded', function() {
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
        columnDefs: [
            { orderable: true, targets: '_all' }
        ],
        order: [[3, 'asc']]
    });
});
</script>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="card-title fw-bold">Maintenance Barang Processed</h4>
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
                        <th>Tanggal Mulai</th>
                        <th>Jadwal Maintenance</th>
                        <th>Siklus</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($data as $item)
                    @php
                    $maintenanceProses = $item->maintenance->where('status', 'proses')->first();
                @endphp
                    <tr>
                        <td>{{ $item->asset->nama_barang ?? '-' }}</td>
                        <td>{{ $item->asset->merk ?? '-' }}</td>
                        <td>{{ $item->asset->ruangan->nama_ruangan ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d-m-Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->next_maintenance_date)->format('d-m-Y') }}</td>
                        <td>
                            @switch($item->siklus)
                                @case('hari') Harian @break
                                @case('minggu') Mingguan @break
                                @case('bulan') Bulanan @break
                                @case('3_bulan') 3 Bulan @break
                                @case('6_bulan') 6 Bulan @break
                                @case('1_tahun') 1 Tahun @break
                                @default {{ $item->siklus }}
                            @endswitch
                        </td>
                        <td>
                            @if($maintenanceProses)
                                <span class="badge bg-warning">Proses</span>
                            @else
                                <span class="badge bg-secondary">Belum Diproses</span>
                            @endif
                        </td>

                        <td>
                            @if($maintenanceProses)
                                <a href="{{ route('maintenance.edit', $item->id_jadwal) }}" class="btn btn-outline-secondary btn-sm" title="Edit Maintenance (Proses)">
                                    <i class="bx bx-edit"></i> Edit
                                </a>
                            @else
                                <a href="{{ route('maintenance.edit', $item->id_jadwal) }}" class="btn btn-outline-secondary btn-sm" title="Proses Maintenance">
                                    <i class="bx bx-wrench"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach


                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
