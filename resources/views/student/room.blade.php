@extends('layouts.student')
@section('page_title', 'My Room')

@section('content')
@if(!$allocation)
  <div class="alert alert-info">You do not have an active room allocation yet. Check your <a href="{{ route('student.application') }}">application status</a>.</div>
@else
  <div class="card ds-card"><div class="card-body">
    <h4 class="fw-bold">{{ $allocation->room->dorm->name }}</h4>
    <p class="text-muted">{{ $allocation->room->dorm->address }}, {{ $allocation->room->dorm->postal_code }} {{ $allocation->room->dorm->city }}</p>
    <div class="row g-3 mt-2">
      <div class="col-sm-6"><div class="p-3 bg-light rounded-3"><div class="small text-muted">Room</div><div class="fw-semibold">{{ $allocation->room->room_number }} ({{ ucfirst(str_replace('_',' ',$allocation->room->room_type)) }})</div></div></div>
      <div class="col-sm-6"><div class="p-3 bg-light rounded-3"><div class="small text-muted">Monthly rent</div><div class="fw-semibold">€ {{ number_format($allocation->monthly_rent, 2) }}</div></div></div>
      <div class="col-sm-6"><div class="p-3 bg-light rounded-3"><div class="small text-muted">Move-in</div><div class="fw-semibold">{{ $allocation->move_in_date->format('M d, Y') }}</div></div></div>
      <div class="col-sm-6"><div class="p-3 bg-light rounded-3"><div class="small text-muted">Deposit</div><div class="fw-semibold">€ {{ number_format($allocation->deposit_amount, 2) }}</div></div></div>
    </div>
  </div></div>
@endif
@endsection
