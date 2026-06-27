@extends('layouts.admin')
@section('page_title','House Rules')
@section('content')
<div class="d-flex justify-content-end mb-3"><a href="{{ route('admin.house-rules.create') }}" class="btn btn-primary">Add Rule</a></div>
<div class="list-group">@foreach($rules as $rule)
  <div class="list-group-item d-flex justify-content-between align-items-start">
    <div><h6 class="mb-1">{{ $rule->section_title }}</h6><p class="mb-0 small text-muted">{{ Str::limit($rule->content, 120) }}</p></div>
    <div class="d-flex gap-2">
      <a href="{{ route('admin.house-rules.edit',$rule) }}" class="btn btn-sm btn-outline-primary">Edit</a>
      <form action="{{ route('admin.house-rules.destroy', $rule) }}" method="POST" onsubmit="return confirm('Delete this rule?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
      </form>
    </div>
  </div>
@endforeach</div>
{{ $rules->links() }}
@endsection
