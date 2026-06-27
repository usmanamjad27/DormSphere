@extends('layouts.student')
@section('page_title', 'Welcome, '.$student->first_name)
@section('page_subtitle', 'Your housing portal at a glance')

@section('content')
{{-- Hero with dorm photo --}}
<div class="ds-dashboard-hero mb-4 ds-animate-scale-in">
  <img src="{{ $heroImage }}" alt="{{ $heroDorm?->name ?? 'Student housing' }}">
  <div class="ds-dashboard-hero-overlay">
    <div>
      @if($allocation)
        <span class="badge bg-success mb-2 ds-animate-fade-in">Your home</span>
        <h2 class="h4 mb-1">{{ $allocation->room->dorm->name }}</h2>
        <p class="mb-0 small opacity-75">Room {{ $allocation->room->room_number }} · {{ $allocation->room->dorm->city }}</p>
      @elseif($application)
        <span class="badge bg-warning text-dark mb-2">Application active</span>
        <h2 class="h4 mb-1">{{ $heroDorm?->name ?? 'Housing application' }}</h2>
        <p class="mb-0 small opacity-75">{{ $application->application_number }}</p>
      @else
        <h2 class="h4 mb-1">Find your perfect room</h2>
        <p class="mb-0 small opacity-75">Browse residences and apply in minutes</p>
      @endif
    </div>
  </div>
</div>

<div class="row g-4">
  <div class="col-lg-8">
    <div class="card ds-card overflow-hidden ds-animate-fade-up ds-delay-1">
      @if($heroDorm?->displayImageUrl() && !$allocation)
        <img src="{{ $heroDorm->displayImageUrl() }}" class="ds-status-card-img" alt="">
      @endif
      <div class="card-body">
        @if($allocation)
          <span class="badge bg-success mb-2">Allocated</span>
          <h5 class="fw-bold">{{ $allocation->room->dorm->name }}</h5>
          <p class="mb-1">Room {{ $allocation->room->room_number }} · € {{ number_format($allocation->monthly_rent, 0) }}/month</p>
          <p class="text-muted small">Move-in: {{ $allocation->move_in_date->format('F j, Y') }}</p>
          <a href="{{ route('student.room') }}" class="btn btn-outline-primary btn-sm mt-2">View room details</a>
        @elseif($application)
          <span class="badge bg-warning text-dark mb-2">Application in progress</span>
          <h5 class="fw-bold">Application {{ $application->application_number }}</h5>
          <p>Status: @include('partials.status-badge', ['status' => $application->status])</p>
          @if($application->estimated_monthly_rent)
            <p class="text-muted small">Estimated rent: € {{ number_format($application->estimated_monthly_rent, 0) }}/mo</p>
          @endif
          <a href="{{ route('student.application') }}" class="btn btn-outline-primary btn-sm">Track application</a>
        @else
          <h5 class="fw-bold">Ready to apply?</h5>
          <p class="text-muted">Submit your housing application with photos, documents, and live pricing.</p>
          <a href="{{ route('student.apply') }}" class="btn btn-primary">Apply for housing</a>
        @endif
      </div>
    </div>

    {{-- Featured dorms gallery --}}
    <h6 class="text-uppercase text-muted small fw-semibold mt-2 mb-3 ds-animate-fade-up ds-delay-2">Explore residences</h6>
    <div class="row g-3">
      @foreach($featuredDorms as $i => $dorm)
        @php $img = $dorm->preview_images[0] ?? $dorm->displayImageUrl(); @endphp
        <div class="col-6 col-md-3 ds-animate-fade-up ds-delay-{{ min($i + 2, 6) }}">
          <a href="{{ route('student.apply') }}" class="text-decoration-none d-block ds-dorm-thumb">
            @if($img)
              <img src="{{ $img }}" alt="{{ $dorm->name }}" loading="lazy">
            @else
              <div class="bg-secondary bg-opacity-25 h-100 d-flex align-items-center justify-content-center"><i class="bi bi-building fs-2 text-muted"></i></div>
            @endif
            <div class="ds-dorm-thumb-caption">
              {{ $dorm->name }}
              @if($dorm->distance_to_campus_km)
                <span class="d-block fw-normal opacity-75" style="font-size:.7rem">{{ $dorm->distance_to_campus_km }} km to campus</span>
              @endif
            </div>
          </a>
        </div>
      @endforeach
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card ds-card h-100 ds-animate-fade-up ds-delay-3">
      <div class="card-body">
        <h6 class="text-muted text-uppercase small">Quick links</h6>
        <div class="d-grid gap-2 mt-2">
          <a href="{{ route('student.apply') }}" class="btn btn-light text-start ds-quick-link ds-animate-slide-right ds-delay-3"><i class="bi bi-file-earmark-plus me-2 text-primary"></i>Apply for housing</a>
          <a href="{{ route('student.maintenance.index') }}" class="btn btn-light text-start ds-quick-link"><i class="bi bi-wrench me-2 text-primary"></i>Maintenance</a>
          <a href="{{ route('student.notices') }}" class="btn btn-light text-start ds-quick-link"><i class="bi bi-bell me-2 text-primary"></i>Notices</a>
          <a href="{{ route('student.house-rules') }}" class="btn btn-light text-start ds-quick-link"><i class="bi bi-journal-check me-2 text-primary"></i>House rules</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<style>.ds-animate-slide-right { animation: ds-slide-right 0.5s ease forwards; opacity: 0; }</style>
@endpush
