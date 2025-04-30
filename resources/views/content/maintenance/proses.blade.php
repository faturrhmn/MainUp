@extends('layouts/contentNavbarLayout')

@section('title', 'Maintenance Barang Proccessed')

@section('vendor-style')
<link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<!-- Bootstrap Icons -->
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
    new DataTable('#assetsTable', {
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
        order: [[0, 'asc']]
    });
});
</script>
@endsection

<style>
.custom-card {
  background-color: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
  transition: all 0.3s ease;
}

.custom-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 6px 16px rgba(0,0,0,0.1);
}

.icon-wrapper {
  background-color: #f5f5f5;
  border-radius: 50%;
  width: 50px;
  height: 50px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.icon-wrapper i {
  font-size: 24px;
  color: #333;
}
</style>
@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="card-title mb-4 fw-bold">Maintenace Barang Proccessed</h4>
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="maintenanceTable">
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
                @forelse($data as $item)
   <tr>
       <td>{{ $item->asset->nama_barang ?? '-' }}</td>
       <td>{{ $item->asset->merk ?? '-' }}</td>
       <td>{{ $item->asset->ruangan->nama_ruangan ?? '-' }}</td>
       <td>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d-m-Y') }}</td>
       <td>{{ \Carbon\Carbon::parse($item->next_maintenance_date)->format('d-m-Y') }}</td>
       <td>
           @switch($item->siklus)
               @case('hari')
                   Harian
                   @break
               @case('minggu')
                   Mingguan
                   @break
               @case('bulan')
                   Bulanan
                   @break
               @case('3_bulan')
                   3 Bulan
                   @break
               @case('6_bulan')
                   6 Bulan
                   @break
               @case('1_tahun')
                   1 Tahun
                   @break
               @default
                   {{ $item->siklus }}
           @endswitch
       </td>
       <td>
           @if($item->status_perbaikan)
               <span class="badge bg-{{ $item->status_perbaikan == 'selesai' ? 'success' : 'warning' }}">
                   {{ ucfirst($item->status_perbaikan) }}
               </span>
           @else
               <span class="badge bg-info">Belum Diproses</span>
           @endif
       </td>
       <td>
           <a href="{{ route('maintenance.edit', $item->id_jadwal) }}" class="btn btn-outline-secondary btn-sm" title="Proses Maintenance">
               <i class="bx bx-wrench"></i>
           </a>
       </td>
   </tr>
   @empty
   <tr>
       <td colspan="8" class="text-center">Tidak ada barang yang memerlukan maintenance dalam 7 hari ke depan.</td>
   </tr>
   @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('page-script')
<script>
document.getElementById('searchInput').addEventListener('keyup', function() {
    let value = this.value.toLowerCase();
    let rows = document.querySelectorAll('#maintenanceTable tbody tr');
    rows.forEach(row => {
        let show = Array.from(row.children).some(td => td.textContent.toLowerCase().includes(value));
        row.style.display = show ? '' : 'none';
    });
});
</script>
@endsection