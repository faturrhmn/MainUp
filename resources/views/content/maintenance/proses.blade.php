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
<div class="mb-3 d-flex justify-content-between align-items-center">
    <div class="flex-grow-1 me-3">
        <input type="text" class="form-control" placeholder="Search" id="searchInput">
    </div>
    <div>
        <button class="btn btn-outline-danger me-2" id="btnHapus">
            <i class="bx bx-trash"></i> Hapus
        </button>
        <button class="btn btn-primary" id="btnTambah">
            <i class="bx bx-plus"></i> Tambah
        </button>
    </div>
</div>
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
                        <th>Tanggal</th>
                        <th>Tipe</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($data as $item)
   <tr>
       <td>{{ $item->asset->nama_barang ?? '-' }}</td>
       <td>{{ $item->asset->merk ?? '-' }}</td>
       <td>{{ $item->asset->ruangan->nama_ruangan ?? '-' }}</td>
       <td>{{ $item->tanggal_mulai }}</td>
       <td>{{ $item->asset->tipe ?? '-' }}</td>
       <td>
           <a href="{{ route('maintenance.edit', $item->id_jadwal) }}" class="btn btn-outline-secondary btn-sm" title="Aksi">
               <i class="bx bx-wrench"></i>
           </a>
       </td>
   </tr>
   @empty
   <tr>
       <td colspan="6" class="text-center">Tidak ada data.</td>
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