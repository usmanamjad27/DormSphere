@extends('layouts.admin')
@section('page_title', $dorm->name)
@section('content')
<div class="row g-4">
  <div class="col-lg-5">
    <div class="card ds-card"><div class="card-body">
      @if($dorm->displayImageUrl())
        <img src="{{ $dorm->displayImageUrl() }}" alt="{{ $dorm->name }}" class="img-fluid rounded-3 mb-3" style="max-height:200px;width:100%;object-fit:cover">
      @endif
      <h5 class="fw-bold">{{ $dorm->name }}</h5>
      @if($dorm->nearby_university)
        <p class="small text-muted"><i class="bi bi-building"></i> {{ $dorm->nearby_university }}</p>
      @endif
      @if($dorm->distance_to_campus_km)
        <p class="small text-muted"><i class="bi bi-geo-alt"></i> {{ $dorm->distance_to_campus_km }} km from campus</p>
      @endif
      @if($dorm->capacity)
        <p class="small text-muted"><i class="bi bi-people"></i> Capacity: {{ number_format($dorm->capacity) }}</p>
      @endif
      <p class="text-muted mb-2">{{ $dorm->address }}, {{ $dorm->postal_code }} {{ $dorm->city }}</p>
      @include('partials.status-badge', ['status' => $dorm->status])
      <p class="mt-3">{{ $dorm->description }}</p>
      @if($dorm->typical_room_types)
        <div class="d-flex flex-wrap gap-1 mt-2">@foreach($dorm->typical_room_types as $type)<span class="badge bg-light text-dark">{{ $type }}</span>@endforeach</div>
      @endif
      @if($dorm->amenities)
        <div class="d-flex flex-wrap gap-1 mt-2">@foreach($dorm->amenities as $a)<span class="badge bg-light text-dark">{{ $a }}</span>@endforeach</div>
      @endif
      @if($dorm->extra_details)
        <div class="mt-3">
          <h6 class="small text-uppercase text-muted mb-2">Additional details</h6>
          <div class="row g-2">
            @foreach($dorm->extra_details as $key => $value)
              <div class="col-12 col-md-6">
                <strong>{{ ucwords(str_replace(['_','-'], ' ', $key)) }}:</strong>
                <div class="text-muted">{{ $value }}</div>
              </div>
            @endforeach
          </div>
        </div>
      @endif
    </div></div>
  </div>
  <div class="col-lg-7">
    <div class="card ds-card"><div class="card-header bg-white"><h5 class="mb-0">Rooms</h5></div>
      <ul class="list-group list-group-flush">
        @forelse($dorm->rooms as $room)
          <li class="list-group-item d-flex justify-content-between">
            <span>Room {{ $room->room_number }} — {{ ucfirst(str_replace('_',' ',$room->room_type)) }}</span>
            <span>€ {{ number_format($room->monthly_rent, 0) }} @include('partials.status-badge', ['status'=>$room->status])</span>
          </li>
        @empty
          <li class="list-group-item text-muted">No rooms in this dorm.</li>
        @endforelse
      </ul>
    </div>
  </div>
</div>
@endsection
