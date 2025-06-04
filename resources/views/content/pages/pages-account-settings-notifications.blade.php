@extends('layouts/contentNavbarLayout')

@section('title', 'Notifikasi Maintenance')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-0">Semua Notifikasi Maintenance</h5>
      </div>
      <div class="card-body">
        <div class="row">
          @forelse($allNotifications as $item)
            <div class="col-md-4 mb-4">
              <div class="card" style="cursor: pointer;" onclick="window.location='{{ route('maintenance.edit', $item->id_jadwal) }}';">
                <div class="card-body">
                  <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                      <i class="bx bx-wrench bx-sm text-warning"></i>
                    </div>
                    <div class="flex-grow-1">
                      <h6 class="mb-0">{{ $item->asset->nama_barang ?? '-' }}</h6>
                      <small class="text-muted">Perlu maintenance pada <span class="text-warning">{{ \Carbon\Carbon::parse($item->next_maintenance_date)->format('d-m-Y') }}</span></small>
                      <br>
                      <small class="text-muted">Ruangan: {{ $item->asset->ruangan->nama_ruangan ?? '-' }}</small>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @empty
            <div class="col-12">
              <p class="text-muted text-center">Tidak ada notifikasi maintenance</p>
            </div>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
