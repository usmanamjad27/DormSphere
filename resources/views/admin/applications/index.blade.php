@extends('layouts.admin')
@section('page_title','Applications')
@section('content')
<form class="row g-2 mb-3" method="GET">
  <div class="col-auto"><select name="status" class="form-select" onchange="this.form.submit()">
    <option value="">All statuses</option>
    @foreach(['pending','under_review','approved','rejected','waitlisted','withdrawn'] as $s)
      <option value="{{ $s }}" @selected(request('status')===$s)>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
    @endforeach
  </select></div>
</form>
<div class="card ds-card"><div class="table-responsive">
<table class="table ds-table mb-0"><thead><tr><th>#</th><th>Student</th><th>Submitted</th><th>Status</th><th></th></tr></thead>
<tbody>@foreach($applications as $app)
<tr>
  <td><code>{{ $app->application_number }}</code></td>
  <td>{{ $app->student->full_name }}</td>
  <td>{{ $app->submitted_at?->format('M d, Y') ?? '—' }}</td>
  <td>@include('partials.status-badge',['status'=>$app->status])</td>
  <td><a href="{{ route('admin.applications.show',$app) }}" class="btn btn-sm btn-primary">Review</a></td>
</tr>@endforeach</tbody></table></div>{{ $applications->links() }}</div>
@endsection
