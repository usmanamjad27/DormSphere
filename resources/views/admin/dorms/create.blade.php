@extends('layouts.admin')
@section('page_title', 'Add Dorm')
@section('content')
<div class="card ds-card"><div class="card-body">
  <form method="POST" action="{{ route('admin.dorms.store') }}" enctype="multipart/form-data">@csrf
    @include('admin.dorms._form')
    <div class="mt-4"><button class="btn btn-primary">Create Dorm</button></div>
  </form>
</div></div>
@endsection
