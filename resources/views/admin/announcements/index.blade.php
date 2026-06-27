@extends('layouts.admin')
@section('page_title','Announcements')
@section('content')
<div class="d-flex justify-content-end mb-3"><a href="{{ route('admin.announcements.create') }}" class="btn btn-primary">New Announcement</a></div>
@foreach($announcements as $a)
<div class="card ds-card mb-3"><div class="card-body d-flex justify-content-between">
  <div><h5 class="mb-1">{{ $a->title }}</h5><p class="text-muted small mb-0">{{ $a->publish_date?->format('M d, Y') }} · {{ $a->target_audience === 'all' ? 'All residents' : $a->targetDorm?->name }}</p></div>
  <div class="d-flex gap-2">
    <a href="{{ route('admin.announcements.edit',$a) }}" class="btn btn-sm btn-outline-primary">Edit</a>
    <form action="{{ route('admin.announcements.destroy', $a) }}" method="POST" onsubmit="return confirm('Delete this announcement?');">
      @csrf
      @method('DELETE')
      <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
    </form>
  </div>
</div></div>
@endforeach
{{ $announcements->links() }}
@endsection
