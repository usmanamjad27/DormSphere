@extends('layouts.student')
@section('page_title','Notices & Announcements')
@section('content')
@forelse($announcements as $a)
<div class="card ds-card mb-3"><div class="card-body">
  <h5 class="fw-bold">{{ $a->title }}</h5>
  <p class="small text-muted mb-2">{{ $a->publish_date?->format('F j, Y') }}</p>
  <p class="mb-0">{{ $a->body }}</p>
</div></div>
@empty
<p class="text-muted">No announcements at this time.</p>
@endforelse
{{ $announcements->links() }}
@endsection
