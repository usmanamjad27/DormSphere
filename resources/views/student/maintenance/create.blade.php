@extends('layouts.student')
@section('page_title','Report Maintenance Issue')
@section('content')
<div class="card ds-card col-lg-8"><div class="card-body">
  <p class="text-muted">Room: <strong>{{ $room->label() }}</strong></p>
  <form method="POST" action="{{ route('student.maintenance.store') }}">@csrf
    <div class="mb-3"><label class="form-label">Issue type</label><select name="issue_type" class="form-select">@foreach(['plumbing','electrical','furniture','cleaning','internet','heating','other'] as $t)<option value="{{ $t }}">{{ ucfirst($t) }}</option>@endforeach</select></div>
    <div class="mb-3"><label class="form-label">Priority</label><select name="priority" class="form-select"><option value="low">Low</option><option value="medium" selected>Medium</option><option value="high">High</option><option value="urgent">Urgent</option></select></div>
    <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="4" required></textarea></div>
    <button class="btn btn-primary">Submit request</button>
  </form>
</div></div>
@endsection
