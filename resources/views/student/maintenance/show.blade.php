@extends('layouts.student')
@section('page_title', 'Maintenance Request')
@section('content')
<div class="card ds-card col-lg-8"><div class="card-body">
  <p class="text-muted small">{{ $request->created_at->format('F j, Y g:i A') }}</p>
  <h5 class="fw-bold">{{ ucfirst($request->issue_type) }}</h5>
  <p>{{ $request->room?->label() }}</p>
  <p>@include('partials.status-badge', ['status' => $request->status])</p>
  <hr>
  <p>{{ $request->description }}</p>
  <a href="{{ route('student.maintenance.index') }}" class="btn btn-outline-secondary btn-sm mt-2">Back to list</a>
</div></div>
@endsection
