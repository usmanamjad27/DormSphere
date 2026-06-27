@extends('layouts.admin')
@section('page_title', 'Dorms')
@section('page_subtitle', 'Manage residence buildings')

@section('content')
<div class="d-flex justify-content-between mb-3">
  <span></span>
  <a href="{{ route('admin.dorms.create') }}" class="btn ds-btn-primary btn-primary"><i class="bi bi-plus-lg me-1"></i> Add Dorm</a>
</div>
<div class="card ds-card">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-striped table-hover ds-table mb-0">
        <thead><tr><th>Name</th><th>City</th><th>Rooms</th><th>Status</th><th></th></tr></thead>
        <tbody>
      @forelse($dorms as $dorm)
        <tr>
          <td class="fw-medium">{{ $dorm->name }}</td>
          <td>{{ $dorm->city }}</td>
          <td>{{ $dorm->rooms_count }}</td>
          <td>@include('partials.status-badge', ['status' => $dorm->status])</td>
          <td class="text-end">
            <a href="{{ route('admin.dorms.show', $dorm) }}" class="btn btn-sm btn-light">View</a>
            <a href="{{ route('admin.dorms.edit', $dorm) }}" class="btn btn-sm btn-outline-primary">Edit</a>
            <form action="{{ route('admin.dorms.destroy', $dorm) }}" method="POST" class="d-inline-block ms-1" onsubmit="return confirm('Delete this dorm?');">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="5" class="text-center text-muted py-4">No dorms yet.</td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
