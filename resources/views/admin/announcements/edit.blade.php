@extends('layouts.admin')
@section('page_title','Edit Announcement')
@section('content')
<div class="card ds-card"><div class="card-body"><form method="POST" action="{{ route('admin.announcements.update',$announcement) }}">@csrf @method('PUT')
  <div class="mb-3"><label class="form-label">Title</label><input name="title" class="form-control" value="{{ $announcement->title }}" required></div>
  <div class="mb-3"><label class="form-label">Body</label><textarea name="body" class="form-control" rows="5" required>{{ $announcement->body }}</textarea></div>
  <div class="mb-3"><label class="form-label">Audience</label><select name="target_audience" class="form-select"><option value="all" @selected($announcement->target_audience==='all')>All</option><option value="specific_dorm" @selected($announcement->target_audience==='specific_dorm')>Specific dorm</option></select></div>
  <div class="mb-3"><label class="form-label">Dorm</label><select name="target_dorm_id" class="form-select"><option value="">—</option>@foreach($dorms as $d)<option value="{{ $d->id }}" @selected($announcement->target_dorm_id==$d->id)>{{ $d->name }}</option>@endforeach</select></div>
  <button class="btn btn-primary">Save</button>
</form></div></div>
@endsection
