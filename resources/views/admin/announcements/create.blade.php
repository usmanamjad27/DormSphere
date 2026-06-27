@extends('layouts.admin')
@section('page_title','New Announcement')
@section('content')
<div class="card ds-card"><div class="card-body"><form method="POST" action="{{ route('admin.announcements.store') }}">@csrf
  <div class="mb-3"><label class="form-label">Title</label><input name="title" class="form-control" required></div>
  <div class="mb-3"><label class="form-label">Body</label><textarea name="body" class="form-control" rows="5" required></textarea></div>
  <div class="mb-3"><label class="form-label">Audience</label><select name="target_audience" class="form-select"><option value="all">All</option><option value="specific_dorm">Specific dorm</option></select></div>
  <div class="mb-3"><label class="form-label">Dorm (optional)</label><select name="target_dorm_id" class="form-select"><option value="">—</option>@foreach($dorms as $d)<option value="{{ $d->id }}">{{ $d->name }}</option>@endforeach</select></div>
  <button class="btn btn-primary">Publish</button>
</form></div></div>
@endsection
