@extends('layouts/contentNavbarLayout')

@section('title', 'Data Barang')

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
    var table = new DataTable('#assetsTable', {
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
            { orderable: false, targets: [0] },
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

    // Handle delete button click
    $(document).on('click', '#delete-selected', function(e) {
        e.preventDefault();
        var checkedItems = $('.item-checkbox:checked');
        if (checkedItems.length > 0) {
            // Update modal text with item count
            $('#item-count').text('(' + checkedItems.length + ' item)');
            // Show the confirmation modal
            var deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
            deleteModal.show();
        }
    });

    // Handle confirmation button click in the modal
    $(document).on('click', '#confirm-delete-btn', function() {
        // Hide the modal
        var deleteModal = bootstrap.Modal.getInstance(document.getElementById('deleteConfirmationModal'));
        deleteModal.hide();
        // Submit the delete form
        $('#delete-form').submit();
    });

    // Initialize delete button state
    updateDeleteButton();
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
                            <h5 class="card-title text-primary">Daftar Data Barang</h5>
                            <div class="d-flex flex-wrap gap-2 justify-content-end align-items-center">
                                <button type="button" class="btn btn-danger" id="delete-selected" disabled>
                                    <i class="bx bx-trash me-1"></i> Hapus (<span id="selected-count">0</span>)
                                </button>
                                <a href="{{ route('data-barang.create') }}" class="btn btn-primary">
                                    <i class="bx bx-plus me-1"></i> Tambah Data
                                </a>
                                <x-export-buttons route="export.assets" />
                            </div>
                        </div>

                        <form id="delete-form" action="{{ route('data-barang.destroy-multiple') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="table-responsive">
                                <table id="assetsTable" class="table table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>
                                                <input type="checkbox" id="select-all" class="form-check-input">
                                            </th>
                                            <th>No</th>
                                            <th>Nama Barang</th>
                                            <th>Nomor Aset</th>
                                            <th>Merk</th>
                                            <th>Tahun</th>
                                            <th>Tipe Barang</th>
                                            <th>Jumlah</th>
                                            <th>Ruangan</th>
                                            <th>Keterangan</th>
                                            <th>Siklus</th>
                                            <th>Tanggal Mulai</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($assets as $index => $asset)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="selected_items[]" value="{{ $asset->id_aset }}" class="form-check-input item-checkbox">
                                            </td>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $asset->nama_barang }}</td>
                                            <td>{{ $asset->nomor_aset ?? '-' }}</td>
                                            <td>{{ $asset->merk }}</td>
                                            <td>{{ $asset->tahun }}</td>
                                            <td>{{ $asset->tipe }}</td>
                                            <td>{{ $asset->jumlah }}</td>
                                            <td>{{ $asset->ruangan->nama_ruangan ?? '-' }}</td>
                                            <td>{{ $asset->keterangan ?? '-'  }}</td>
                                            <td>
                                                @if($asset->jadwals->isNotEmpty())
                                                    @php
                                                        $siklus = $asset->jadwals->first()->siklus;
                                                        $siklusLabel = '-';
                                                        switch($siklus) {
                                                            case 'hari': $siklusLabel = 'Harian'; break;
                                                            case 'minggu': $siklusLabel = 'Mingguan'; break;
                                                            case 'bulan': $siklusLabel = 'Bulanan'; break;
                                                            case '3_bulan': $siklusLabel = '3 Bulan'; break;
                                                            case '6_bulan': $siklusLabel = '6 Bulan'; break;
                                                            case '1_tahun': $siklusLabel = '1 Tahun'; break;
                                                            default: $siklusLabel = ucfirst(str_replace('_', ' ', $siklus)); break;
                                                        }
                                                    @endphp
                                                    {{ $siklusLabel }}
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

                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="{{ route('data-barang.edit', $asset->id_aset) }}">
                                                            <i class="bx bx-edit-alt me-1"></i> Edit
                                                        </a>
                                                        <a class="dropdown-item" href="{{ route('data-barang.show', $asset->id_aset) }}">
                                                            <i class="bx bx-detail me-1"></i> Details
                                                        </a>
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

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmationModalLabel">Konfirmasi Penghapusan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                Apakah Anda yakin ingin menghapus item yang dipilih? <span id="item-count"></span>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirm-delete-btn">Hapus</button>
            </div>
        </div>
    </div>
</div>
@endsection
