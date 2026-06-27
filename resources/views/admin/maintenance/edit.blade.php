@extends('layouts.admin')
@section('page_title','Manage Request')
@section('content')
<div class="card ds-card"><div class="card-body">
  <p class="text-muted">{{ $request->room?->label() }} · {{ $request->description }}</p>
  <form method="POST" action="{{ route('admin.maintenance.update',$request) }}">@csrf @method('PUT')
    <div class="mb-3"><label class="form-label">Status</label><select name="status" class="form-select">@foreach(['open','in_progress','resolved','closed'] as $s)<option value="{{ $s }}" @selected($request->status===$s)>{{ ucfirst(str_replace('_',' ',$s)) }}</option>@endforeach</select></div>
    <div class="mb-3"><label class="form-label">Priority</label><select name="priority" class="form-select">@foreach(['low','medium','high','urgent'] as $p)<option value="{{ $p }}" @selected($request->priority===$p)>{{ ucfirst($p) }}</option>@endforeach</select></div>
    <div class="mb-3"><label class="form-label">Assigned to</label><input name="assigned_to" class="form-control" value="{{ old('assigned_to',$request->assigned_to) }}"></div>
    <button class="btn btn-primary">Update</button>
  </form>
</div></div>
@endsection
