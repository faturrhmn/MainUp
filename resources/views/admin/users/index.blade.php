@extends('layouts/contentNavbarLayout')

@section('title', 'Daftar User')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar User</h5>
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Tambah User</a>
                
            </div>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Tanggal Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->role ? ucfirst($user->role->name) : '-' }}</td>
                                <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('admin.users.edit', $user->id) }}">
                                                <i class="bx bx-edit-alt me-1"></i> Edit
                                            </a>
                                            <button type="button" class="dropdown-item text-danger btn-hapus-user" data-id="{{ $user->id }}" data-nama="{{ $user->name }}" data-bs-toggle="modal" data-bs-target="#modalKonfirmasiHapusUser">
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
            </div>
        </div>
    </div>
</div>
<!-- Modal Konfirmasi Hapus User -->
<div class="modal fade" id="modalKonfirmasiHapusUser" tabindex="-1" aria-labelledby="modalKonfirmasiHapusUserLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalKonfirmasiHapusUserLabel">Konfirmasi Penghapusan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <span id="modal-hapus-user-text">Apakah Anda yakin ingin menghapus user ini?</span>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Batal</button>
        <form id="formHapusUser" method="POST" action="">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger">Hapus</button>
        </form>
      </div>
    </div>
  </div>
</div>
@section('page-script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var modalUser = document.getElementById('modalKonfirmasiHapusUser');
    if (modalUser) {
        modalUser.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var nama = button.getAttribute('data-nama');
            modalUser.querySelector('#modal-hapus-user-text').textContent =
                'Apakah Anda yakin ingin menghapus user "' + nama + '"?';
            modalUser.querySelector('#formHapusUser').action =
                '/admin/users/' + id;
        });
    }
});
</script>
@endsection 