@extends('layouts.admin')
@section('title', 'Admin Dashboard')
@section('page_title', 'Dashboard')
@section('page_subtitle', 'Overview of your housing operations')

@section('content')
{{-- Hero banner --}}
<div class="ds-dashboard-hero mb-4 ds-animate-scale-in">
  <img src="{{ $heroImage }}" alt="DormSphere residences">
  <div class="ds-dashboard-hero-overlay">
    <div>
      <h2 class="h4 mb-1">Housing operations center</h2>
      <p class="mb-0 small opacity-75">{{ $stats['dorms'] }} dorms · {{ $stats['available_rooms'] }} rooms available · {{ $stats['pending_applications'] }} pending applications</p>
    </div>
  </div>
</div>

{{-- Animated stat cards --}}
<div class="row g-4 mb-4">
  @foreach([
    ['label'=>'Dorms','value'=>$stats['dorms'],'icon'=>'buildings','color'=>'primary'],
    ['label'=>'Available Rooms','value'=>$stats['available_rooms'],'icon'=>'door-open','color'=>'success'],
    ['label'=>'Pending Applications','value'=>$stats['pending_applications'],'icon'=>'hourglass-split','color'=>'warning'],
    ['label'=>'Active Residents','value'=>$stats['active_residents'],'icon'=>'people','color'=>'info'],
    ['label'=>'Open Maintenance','value'=>$stats['open_maintenance'],'icon'=>'tools','color'=>'danger'],
    ['label'=>'Total Students','value'=>$stats['students'],'icon'=>'person-badge','color'=>'secondary'],
  ] as $stat)
  <div class="col-md-6 col-xl-4 ds-animate-scale-in ds-delay-{{ min($loop->iteration, 6) }}">
    <div class="card ds-stat-card ds-stat-animated h-100">
      <div class="card-body d-flex align-items-center gap-3">
        <div class="rounded-3 bg-{{ $stat['color'] }} bg-opacity-10 p-3 icon-pulse"><i class="bi bi-{{ $stat['icon'] }} fs-4 text-{{ $stat['color'] }}"></i></div>
        <div>
          <div class="text-muted small">{{ $stat['label'] }}</div>
          <div class="fs-3 fw-bold ds-counter" data-count="{{ $stat['value'] }}">0</div>
        </div>
      </div>
    </div>
  </div>
  @endforeach
</div>

{{-- Dorm photo strip --}}
@if($featuredDorms->isNotEmpty())
<div class="mb-4 ds-animate-fade-up ds-delay-2">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h6 class="text-uppercase text-muted small fw-semibold mb-0">Our residences</h6>
    <a href="{{ route('admin.dorms.index') }}" class="btn btn-sm btn-outline-primary">Manage dorms</a>
  </div>
  <div class="row g-3">
    @foreach($featuredDorms as $i => $dorm)
      @php $img = $dorm->preview_images[0] ?? $dorm->displayImageUrl(); @endphp
      <div class="col-md-4 ds-animate-fade-up ds-delay-{{ $i + 3 }}">
        <a href="{{ route('admin.dorms.show', $dorm) }}" class="text-decoration-none d-block ds-dorm-thumb">
          @if($img)<img src="{{ $img }}" alt="{{ $dorm->name }}" loading="lazy">@endif
          <div class="ds-dorm-thumb-caption">
            {{ $dorm->name }} · {{ $dorm->city }}
            <span class="d-block fw-normal opacity-75" style="font-size:.7rem">{{ $dorm->rooms_count }} rooms</span>
          </div>
        </a>
      </div>
    @endforeach
  </div>
</div>
@endif

<div class="row g-4">
  <div class="col-lg-7 ds-animate-fade-up ds-delay-4">
    <div class="card ds-card">
      <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Recent Applications</h5>
        <a href="{{ route('admin.applications.index') }}" class="btn btn-sm btn-outline-primary">View all</a>
      </div>
      <div class="table-responsive">
        <table class="table ds-table mb-0">
          <thead><tr><th>Student</th><th>Number</th><th>Status</th><th></th></tr></thead>
          <tbody>
          @forelse($recentApplications as $app)
            <tr class="ds-table-row">
              <td>{{ $app->student->full_name }}</td>
              <td><code>{{ $app->application_number }}</code></td>
              <td>@include('partials.status-badge', ['status' => $app->status])</td>
              <td><a href="{{ route('admin.applications.show', $app) }}" class="btn btn-sm btn-light">Review</a></td>
            </tr>
          @empty
            <tr><td colspan="4" class="text-muted text-center py-4">No applications yet.</td></tr>
          @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="col-lg-5 ds-animate-fade-up ds-delay-5">
    <div class="card ds-card">
      <div class="card-header bg-white border-0"><h5 class="mb-0">Maintenance Queue</h5></div>
      <ul class="list-group list-group-flush">
        @forelse($recentMaintenance as $req)
          <li class="list-group-item d-flex justify-content-between align-items-start ds-table-row">
            <div>
              <div class="fw-medium">{{ ucfirst($req->issue_type) }}</div>
              <small class="text-muted">{{ $req->room?->dorm?->name }} — Room {{ $req->room?->room_number }}</small>
            </div>
            @include('partials.status-badge', ['status' => $req->status])
          </li>
        @empty
          <li class="list-group-item text-muted">No open requests.</li>
        @endforelse
      </ul>
    </div>
  </div>
</div>
@endsection

@push('styles')
<style>
.icon-pulse { animation: ds-pulse-soft 3s ease-in-out infinite; }
.ds-table-row { animation: ds-fade-up 0.4s ease forwards; opacity: 0; }
.ds-table tbody tr:nth-child(1) { animation-delay: 0.05s; }
.ds-table tbody tr:nth-child(2) { animation-delay: 0.1s; }
.ds-table tbody tr:nth-child(3) { animation-delay: 0.15s; }
.ds-table tbody tr:nth-child(4) { animation-delay: 0.2s; }
.ds-table tbody tr:nth-child(5) { animation-delay: 0.25s; }
.ds-table tbody tr:nth-child(6) { animation-delay: 0.3s; }
.list-group-item.ds-table-row:nth-child(1) { animation-delay: 0.08s; }
.list-group-item.ds-table-row:nth-child(2) { animation-delay: 0.14s; }
.list-group-item.ds-table-row:nth-child(3) { animation-delay: 0.2s; }
.list-group-item.ds-table-row:nth-child(4) { animation-delay: 0.26s; }
.list-group-item.ds-table-row:nth-child(5) { animation-delay: 0.32s; }
</style>
@endpush

@push('scripts')
<script>
(function () {
  const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  document.querySelectorAll('.ds-counter[data-count]').forEach((el, i) => {
    const target = parseInt(el.dataset.count, 10) || 0;
    if (prefersReduced) {
      el.textContent = target;
      return;
    }
    const duration = 900;
    const start = performance.now();
  const step = (now) => {
      const p = Math.min((now - start) / duration, 1);
      const eased = 1 - Math.pow(1 - p, 3);
      el.textContent = Math.round(target * eased);
      if (p < 1) requestAnimationFrame(step);
      else el.classList.add('ds-counted');
    };
    setTimeout(() => requestAnimationFrame(step), 200 + i * 60);
  });
})();
</script>
@endpush
