@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard')

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

<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row g-4">

    <!-- Card 1 -->
    <div class="col-md-3 col-sm-6">
      <div class="custom-card p-4 text-center">
        <div class="icon-wrapper mx-auto mb-3">
          <i class="bi bi-box"></i> <!-- Total Aset -->
        </div>
        <small class="text-muted mb-1 d-block">Total Aset</small>
        <h3 class="fw-bold mb-0">{{ $totalAssets }}</h3>
      </div>
    </div>

    <!-- Card 2 -->
    <div class="col-md-3 col-sm-6">
      <div class="custom-card p-4 text-center">
        <div class="icon-wrapper mx-auto mb-3">
          <i class="bi bi-door-open"></i> <!-- Total Ruangan -->
        </div>
        <small class="text-muted mb-1 d-block">Total Ruangan</small>
        <h3 class="fw-bold mb-0">{{ $totalRooms }}</h3>
      </div>
    </div>

    <!-- Card 3 -->
    <div class="col-md-3 col-sm-6">
      <div class="custom-card p-4 text-center">
        <div class="icon-wrapper mx-auto mb-3">
          <i class="bi bi-shield-check"></i> <!-- Aset Preventif -->
        </div>
        <small class="text-muted mb-1 d-block">Aset Preventive</small>
        <h3 class="fw-bold mb-0">{{ $totalPreventive }}</h3>
      </div>
    </div>

    <!-- Card 4 -->
    <div class="col-md-3 col-sm-6">
      <div class="custom-card p-4 text-center">
        <div class="icon-wrapper mx-auto mb-3">
          <i class="bi bi-tools"></i> <!-- Total Corrective -->
        </div>
        <small class="text-muted mb-1 d-block">Total Corrective</small>
        <h3 class="fw-bold mb-0">{{ $totalCorrective }}</h3>
      </div>
    </div>

  </div>
</div>

<!-- Tabel Daftar Aset -->
<div class="row mt-4">
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-sm-12">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Daftar Aset</h5>
                        <div class="table-responsive">
                            <table id="assetsTable" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Barang</th>
                                        <th>Merk</th>
                                        <th>Tahun</th>
                                        <th>Jumlah</th>
                                        <th>Tipe</th>
                                        <th>Ruangan</th>
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
                                        <td>{{ $asset->tipe }}</td>
                                        <td>{{ $asset->room->nama_ruangan }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
