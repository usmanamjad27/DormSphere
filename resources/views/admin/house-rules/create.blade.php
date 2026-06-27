@extends('layouts.admin')
@section('page_title','Add House Rule')
@section('content')
<div class="card ds-card"><div class="card-body"><form method="POST" action="{{ route('admin.house-rules.store') }}">@csrf
  <div class="mb-3"><label class="form-label">Section title</label><input name="section_title" class="form-control" required></div>
  <div class="mb-3"><label class="form-label">Content</label><textarea name="content" class="form-control" rows="4" required></textarea></div>
  <div class="mb-3"><label class="form-label">Sort order</label><input type="number" name="sort_order" class="form-control" value="0"></div>
  <div class="form-check mb-3"><input type="checkbox" name="is_active" value="1" class="form-check-input" id="active" checked><label class="form-check-label" for="active">Active</label></div>
  <button class="btn btn-primary">Save</button>
</form></div></div>
@endsection
