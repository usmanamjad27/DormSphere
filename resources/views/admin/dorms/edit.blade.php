@extends('layouts.admin')
@section('page_title', 'Edit Dorm')
@section('content')
<div class="card ds-card"><div class="card-body">
  <form method="POST" action="{{ route('admin.dorms.update', $dorm) }}" enctype="multipart/form-data">@csrf @method('PUT')
    @include('admin.dorms._form')
    <div class="mt-4"><button class="btn btn-primary">Save Changes</button></div>
  </form>
</div></div>
@endsection
