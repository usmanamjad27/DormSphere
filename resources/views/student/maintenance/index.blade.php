@extends('layouts.student')
@section('page_title','Maintenance Requests')
@section('content')
<div class="d-flex justify-content-end mb-3"><a href="{{ route('student.maintenance.create') }}" class="btn btn-primary">Report issue</a></div>
@forelse($requests as $req)
<div class="card ds-card mb-3"><div class="card-body d-flex justify-content-between align-items-center">
  <div><strong>{{ ucfirst($req->issue_type) }}</strong><br><small class="text-muted">{{ $req->room?->label() }} · {{ $req->created_at->format('M d, Y') }}</small></div>
  <div class="d-flex align-items-center gap-2">
    @include('partials.status-badge',['status'=>$req->status])
    <a href="{{ route('student.maintenance.show', $req) }}" class="btn btn-sm btn-outline-primary">View</a>
    <form action="{{ route('student.maintenance.destroy', $req) }}" method="POST" onsubmit="return confirm('Delete this request?');">
      @csrf
      @method('DELETE')
      <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
    </form>
  </div>
</div></div>
@empty
<div class="text-muted">No maintenance requests yet.</div>
@endforelse
{{ $requests->links() }}
@endsection
