@extends('layouts.admin')
@section('page_title','Add Room')
@section('content')
<div class="card ds-card"><div class="card-body"><form method="POST" action="{{ route('admin.rooms.store') }}">@csrf @include('admin.rooms._form')<button class="btn btn-primary mt-3">Create</button></form></div></div>
@endsection
