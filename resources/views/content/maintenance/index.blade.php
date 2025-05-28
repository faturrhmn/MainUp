@extends('layouts.contentLayoutMaster')

@section('title', 'Maintenance')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Daftar Maintenance</h4>
                <div class="d-flex gap-2">
                    <a href="{{ route('maintenance.create') }}" class="btn btn-primary">Tambah Maintenance</a>
                    <x-export-buttons route="export.maintenance" />
                </div>
            </div>
            <div class="card-body">
                <!-- Existing table content -->
            </div>
        </div>
    </div>
</div>
@endsection