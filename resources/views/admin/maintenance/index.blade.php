@extends('layouts.admin')
@section('page_title','Maintenance')
@section('content')
<div class="d-flex justify-content-end mb-3"><a href="{{ route('admin.maintenance.create') }}" class="btn btn-primary">New Request</a></div>
<div class="card ds-card"><div class="table-responsive">
<table class="table ds-table mb-0"><thead><tr><th>Issue</th><th>Location</th><th>Priority</th><th>Status</th><th></th></tr></thead>
<tbody>@foreach($requests as $req)
<tr>
  <td>{{ ucfirst($req->issue_type) }}</td>
  <td>{{ $req->room?->label() }}</td>
  <td><span class="badge bg-secondary">{{ ucfirst($req->priority) }}</span></td>
  <td>@include('partials.status-badge',['status'=>$req->status])</td>
  <td>
    <a href="{{ route('admin.maintenance.edit',$req) }}" class="btn btn-sm btn-outline-primary">Manage</a>
    <form action="{{ route('admin.maintenance.destroy', $req) }}" method="POST" class="d-inline-block ms-1" onsubmit="return confirm('Delete this maintenance request?');">
      @csrf
      @method('DELETE')
      <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
    </form>
  </td>
</tr>@endforeach</tbody></table></div>{{ $requests->links() }}</div>
@endsection
