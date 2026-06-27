@extends('layouts.admin')
@section('page_title','New Maintenance Request')
@section('content')
<div class="card ds-card"><div class="card-body"><form method="POST" action="{{ route('admin.maintenance.store') }}">@csrf
  <div class="mb-3"><label class="form-label">Room</label><select name="room_id" class="form-select" required>@foreach($rooms as $r)<option value="{{ $r->id }}">{{ $r->label() }}</option>@endforeach</select></div>
  <div class="mb-3"><label class="form-label">Issue type</label><select name="issue_type" class="form-select">@foreach(['plumbing','electrical','furniture','cleaning','internet','heating','other'] as $t)<option value="{{ $t }}">{{ ucfirst($t) }}</option>@endforeach</select></div>
  <div class="mb-3"><label class="form-label">Priority</label><select name="priority" class="form-select">@foreach(['low','medium','high','urgent'] as $p)<option value="{{ $p }}">{{ ucfirst($p) }}</option>@endforeach</select></div>
  <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="4" required></textarea></div>
  <button class="btn btn-primary">Submit</button>
</form></div></div>
@endsection
