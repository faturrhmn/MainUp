@extends('layouts/contentNavbarLayout')

@section('title', 'Profile Settings')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}">
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
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="d-flex align-items-start align-items-sm-center gap-4">
                    @if($user->profile_photo)
                        <img src="{{ asset('storage/profile-photos/' . $user->profile_photo) }}" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
                    @else
                        <img src="{{ asset('assets/img/avatars/default.jpg') }}" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
                    @endif
                    <div class="button-wrapper">
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label for="profile_photo" class="btn btn-primary me-2 mb-4" tabindex="0">
                                <span class="d-none d-sm-block">Upload new photo</span>
                                <i class="bx bx-upload d-block d-sm-none"></i>
                                <input type="file" id="profile_photo" name="profile_photo" class="account-file-input" hidden accept="image/png, image/jpeg" />
                            </label>
                            <button type="submit" class="btn btn-outline-primary account-image-reset mb-4">
                                <i class="bx bx-reset d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Save</span>
                            </button>
                        </form>
                        @if($user->profile_photo)
                            <form action="{{ route('profile.delete-photo') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger account-image-reset mb-4">
                                    <i class="bx bx-trash d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Delete</span>
                                </button>
                            </form>
                        @endif
                        <p class="text-muted mb-0">Allowed JPG or PNG. Max size of 2MB</p>
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
                            <input class="form-control @error('current_password') is-invalid @enderror" type="password" id="current_password" name="current_password" />
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="new_password" class="form-label">Password Baru</label>
                            <input class="form-control @error('new_password') is-invalid @enderror" type="password" id="new_password" name="new_password" />
                            @error('new_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <input class="form-control" type="password" id="new_password_confirmation" name="new_password_confirmation" />
                        </div>
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary me-2">Save changes</button>
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">Cancel</a>

                    </div>
                </form>
            </div>
            <!-- /Account -->
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preview uploaded image
    const input = document.querySelector('.account-file-input');
    const uploadedAvatar = document.getElementById('uploadedAvatar');

    input.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                uploadedAvatar.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endsection 