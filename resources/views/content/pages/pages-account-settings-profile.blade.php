@extends('layouts/contentNavbarLayout')

@section('title', 'Profile Settings')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}">
<style>
.profile-photo-preview {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border: 2px solid #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
.upload-error {
    color: #dc3545;
    font-size: 0.875em;
    margin-top: 0.25rem;
}
</style>
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/dashboards-analytics.js')}}"></script>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <h5 class="card-header">Profile Details</h5>
            <!-- Account -->
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="d-flex align-items-start align-items-sm-center gap-4">
                    @if($user->profile_photo)
                        <img src="{{ asset('assets/profile-photos/' . $user->profile_photo) }}" 
                             alt="{{ $user->name }}'s avatar" 
                             class="profile-photo-preview rounded-circle" 
                             id="uploadedAvatar" />
                    @else
                        <img src="{{ asset('assets/img/avatars/default.jpg') }}" 
                             alt="Default avatar" 
                             class="profile-photo-preview rounded-circle" 
                             id="uploadedAvatar" />
                    @endif
                    <div class="button-wrapper">
                        <form action="{{ route('profile.update') }}" 
                              method="POST" 
                              enctype="multipart/form-data" 
                              id="profilePhotoForm">
                            @csrf
                            <label for="profile_photo" class="btn btn-primary me-2 mb-4" tabindex="0">
                                <span class="d-none d-sm-block">Upload new photo</span>
                                <i class="bx bx-upload d-block d-sm-none"></i>
                                <input type="file" 
                                       id="profile_photo" 
                                       name="profile_photo" 
                                       class="account-file-input" 
                                       hidden 
                                       accept="image/png, image/jpeg" />
                            </label>
                            <button type="submit" 
                                    class="btn btn-outline-primary account-image-save mb-4" 
                                    id="savePhotoBtn" 
                                    style="display: none;">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Save</span>
                            </button>
                        </form>
                        @if($user->profile_photo)
                            <button type="button" class="btn btn-outline-danger account-image-reset mb-4" data-bs-toggle="modal" data-bs-target="#modalKonfirmasiHapusFotoProfil">
                                <i class="bx bx-trash d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Delete</span>
                            </button>
                        @endif
                        <p class="text-muted mb-0">Allowed JPG or PNG. Max size of 2MB</p>
                        @error('profile_photo')
                            <div class="upload-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <hr class="my-0">
            <div class="card-body">
                <form id="formAccountSettings" method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Nama</label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" id="name" name="name" value="{{ old('name', $user->name) }}" autofocus />
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="username" class="form-label">Username</label>
                            <input class="form-control @error('username') is-invalid @enderror" type="text" id="username" name="username" value="{{ old('username', $user->username) }}" />
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="role" class="form-label">Role</label>
                            <input class="form-control" type="text" id="role" name="role" value="{{ $user->role->name ?? 'N/A' }}" disabled />
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="current_password" class="form-label">Password Saat Ini</label>
                            <div class="input-group">
                                <input class="form-control" type="password" id="current_password" name="current_password" placeholder="············">
                                <button class="btn btn-outline-secondary" type="button" id="toggleCurrentPassword">
                                    <i class="bx bx-hide"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="new_password" class="form-label">Password Baru</label>
                            <div class="input-group">
                                <input class="form-control" type="password" id="new_password" name="new_password" placeholder="············">
                                <button class="btn btn-outline-secondary" type="button" id="toggleNewPassword">
                                    <i class="bx bx-hide"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <div class="input-group">
                                <input class="form-control" type="password" id="new_password_confirmation" name="new_password_confirmation" placeholder="············">
                                <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                    <i class="bx bx-hide"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary me-2">Save changes</button>
                        <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                    </div>
                </form>
            </div>
            <!-- /Account -->
        </div>
    </div>
</div>

@if($user->profile_photo)
<!-- Modal Konfirmasi Hapus Foto Profil -->
<div class="modal fade" id="modalKonfirmasiHapusFotoProfil" tabindex="-1" aria-labelledby="modalKonfirmasiHapusFotoProfilLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalKonfirmasiHapusFotoProfilLabel">Konfirmasi Penghapusan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        Apakah Anda yakin ingin menghapus foto profil Anda?
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Batal</button>
        <form id="formHapusFotoProfil" action="{{ route('profile.delete-photo') }}" method="POST">
          @csrf
          <button type="submit" class="btn btn-danger">Hapus</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    const uploadedImage = document.getElementById('uploadedAvatar');
    const fileInput = document.querySelector('.account-file-input');
    const saveButton = document.getElementById('savePhotoBtn');
    const originalSrc = uploadedImage.src;
    let hasChanges = false;

    if (fileInput) {
        fileInput.onchange = () => {
            const file = fileInput.files[0];
            if (file) {
                // Validate file size (2MB = 2 * 1024 * 1024 bytes)
                if (file.size > 2 * 1024 * 1024) {
                    alert('File is too large. Maximum size is 2MB.');
                    fileInput.value = '';
                    return;
                }

                // Validate file type
                if (!['image/jpeg', 'image/png'].includes(file.type)) {
                    alert('Only JPG and PNG files are allowed.');
                    fileInput.value = '';
                    return;
                }

                // Preview image
                uploadedImage.src = URL.createObjectURL(file);
                hasChanges = true;
                saveButton.style.display = 'inline-block';
            }
        };
    }

    // Reset form if cancel is clicked
    document.querySelector('button[type="reset"]')?.addEventListener('click', (e) => {
        if (hasChanges) {
            if (confirm('Are you sure you want to discard changes?')) {
                uploadedImage.src = originalSrc;
                fileInput.value = '';
                hasChanges = false;
                saveButton.style.display = 'none';
            } else {
                e.preventDefault();
            }
        }
    });

    // Toggle Password Fields
    function setupPasswordToggle(toggleId, passwordId) {
        const toggleBtn = document.getElementById(toggleId);
        const passwordInput = document.getElementById(passwordId);
        
        if (toggleBtn && passwordInput) {
            toggleBtn.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                // Toggle icon
                const icon = this.querySelector('i');
                icon.classList.toggle('bx-hide');
                icon.classList.toggle('bx-show');
            });
        }
    }

    // Setup toggle for all password fields
    setupPasswordToggle('toggleCurrentPassword', 'current_password');
    setupPasswordToggle('toggleNewPassword', 'new_password');
    setupPasswordToggle('toggleConfirmPassword', 'new_password_confirmation');
});
</script>
@endsection 