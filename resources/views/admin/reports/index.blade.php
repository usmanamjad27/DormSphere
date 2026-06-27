@extends('layouts.admin')
@section('page_title','Reports')
@section('page_subtitle','Occupancy and operational insights')
@section('content')
<div class="row g-4 mb-4">
  <div class="col-md-4"><div class="card ds-stat-card"><div class="card-body text-center"><div class="display-6 fw-bold text-primary">{{ $report['occupancy_rate'] }}%</div><div class="text-muted">Bed occupancy</div></div></div></div>
  <div class="col-md-4"><div class="card ds-stat-card"><div class="card-body text-center"><div class="display-6 fw-bold text-success">€ {{ number_format($report['monthly_rent_total'],0) }}</div><div class="text-muted">Monthly rent (active)</div></div></div></div>
</div>
<div class="row g-4">
  <div class="col-md-6"><div class="card ds-card"><div class="card-header bg-white"><h6 class="mb-0">Applications by status</h6></div><ul class="list-group list-group-flush">@forelse($report['applications_by_status'] as $status=>$total)<li class="list-group-item d-flex justify-content-between"><span>{{ ucfirst(str_replace('_',' ',$status)) }}</span><strong>{{ $total }}</strong></li>@empty<li class="list-group-item text-muted">No data</li>@endforelse</ul></div></div>
  <div class="col-md-6"><div class="card ds-card"><div class="card-header bg-white"><h6 class="mb-0">Dorms overview</h6></div><ul class="list-group list-group-flush">@foreach($report['dorms_overview'] as $d)<li class="list-group-item d-flex justify-content-between"><span>{{ $d->name }}</span><span>{{ $d->available_rooms_count }}/{{ $d->rooms_count }} available</span></li>@endforeach</ul></div></div>
</div>
@endsection
