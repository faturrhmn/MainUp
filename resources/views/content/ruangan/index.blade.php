@extends('layouts/contentNavbarLayout')

@section('title', 'Ruangan')

@section('vendor-style')
<link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endsection

@section('vendor-script')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
@endsection

@section('page-script')
<script>
$(document).ready(function() {
    var table = new DataTable('#ruanganTable', {
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
            { orderable: false, targets: [0, 4] },
            { orderable: true, targets: '_all' }
        ],
        order: [[1, 'asc']]
    });

    // Handle select all checkbox
    $(document).on('click', '#select-all', function() {
        $('.item-checkbox').prop('checked', this.checked);
        updateDeleteButton();
    });

    // Handle individual checkbox
    $(document).on('click', '.item-checkbox', function() {
        updateDeleteButton();
        if (!this.checked) {
            $('#select-all').prop('checked', false);
        } else {
            var allChecked = $('.item-checkbox:not(:checked)').length === 0;
            $('#select-all').prop('checked', allChecked);
        }
    });

    // Update delete button state
    function updateDeleteButton() {
        var checkedCount = $('.item-checkbox:checked').length;
        $('#delete-selected').prop('disabled', checkedCount === 0);
        $('#selected-count').text(checkedCount);
    }

    // Handle delete confirmation
    $(document).on('click', '#delete-selected', function(e) {
        e.preventDefault();
        var checkedItems = $('.item-checkbox:checked');
        if (checkedItems.length > 0) {
            if (confirm('Apakah Anda yakin ingin menghapus ' + checkedItems.length + ' ruangan yang dipilih?')) {
                $('#delete-form').submit();
            }
        }
    });

    // Initialize delete button state
    updateDeleteButton();
});

document.addEventListener('DOMContentLoaded', function () {
    var modalRuangan = document.getElementById('modalKonfirmasiHapusRuangan');
    if (modalRuangan) {
        modalRuangan.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var nama = button.getAttribute('data-nama');
            modalRuangan.querySelector('#modal-hapus-ruangan-text').textContent =
                'Apakah Anda yakin ingin menghapus ruangan "' + nama + '"?';
            modalRuangan.querySelector('#formHapusRuangan').action =
                '/ruangan/' + id;
        });
    }
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
                            <h5 class="card-title text-primary">Daftar Ruangan</h5>
                            <div>
                                <button type="button" class="btn btn-danger me-2" id="delete-selected" disabled>
                                    <i class="bx bx-trash me-1"></i> Hapus (<span id="selected-count">0</span>)
                                </button>
                                <a href="{{ route('ruangan.create') }}" class="btn btn-primary">
                                    <i class="bx bx-plus me-1"></i> Tambah Ruangan
                                </a>
                                <x-export-buttons route="export.ruangan" />
                            </div>
                        </div>
                        <form id="delete-form" action="{{ route('ruangan.destroy-multiple') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="table-responsive">
                                <table id="ruanganTable" class="table table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>
                                                <input type="checkbox" id="select-all" class="form-check-input">
                                            </th>
                                            <th>No</th>
                                            <th>Ruangan</th>
                                            <th>Total Aset</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($ruangans as $index => $r)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="selected_items[]" value="{{ $r->id_ruangan }}" class="form-check-input item-checkbox">
                                            </td>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $r->nama_ruangan }}</td>
                                            <td>{{ $r->assets_count }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a href="{{ route('ruangan.edit', $r->id_ruangan) }}" class="dropdown-item">
                                                            <i class="bx bx-edit-alt me-1"></i> Edit
                                                        </a>
                                                        <a class="dropdown-item" href="{{ route('ruangan.show', $r->id_ruangan) }}">
                                                            <i class="bx bx-detail me-1"></i> Details
                                                        </a>
                                                        <button type="button" class="dropdown-item text-danger btn-hapus-ruangan" data-id="{{ $r->id_ruangan }}" data-nama="{{ $r->nama_ruangan }}" data-bs-toggle="modal" data-bs-target="#modalKonfirmasiHapusRuangan">
                                                            <i class="bx bx-trash me-1"></i> Hapus
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus Ruangan -->
<div class="modal fade" id="modalKonfirmasiHapusRuangan" tabindex="-1" aria-labelledby="modalKonfirmasiHapusRuanganLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalKonfirmasiHapusRuanganLabel">Konfirmasi Penghapusan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <span id="modal-hapus-ruangan-text">Apakah Anda yakin ingin menghapus ruangan ini?</span>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Batal</button>
        <form id="formHapusRuangan" method="POST" action="">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger">Hapus</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection 