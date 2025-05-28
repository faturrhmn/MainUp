@extends('layouts.contentLayoutMaster')

@section('title', 'Jadwal')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Daftar Jadwal</h4>
                <div class="d-flex gap-2">
                    <a href="{{ route('jadwal.create') }}" class="btn btn-primary">Tambah Jadwal</a>
                    <x-export-buttons route="export.jadwal" />
                </div>
            </div>
            <div class="card-body">
                <!-- Existing table content -->
            </div>
        </div>
    </div>
</div>
@endsection 