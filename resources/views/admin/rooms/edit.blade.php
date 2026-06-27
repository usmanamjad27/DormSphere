@extends('layouts.admin')
@section('page_title','Edit Room')
@section('content')
<div class="card ds-card"><div class="card-body"><form method="POST" action="{{ route('admin.rooms.update',$room) }}">@csrf @method('PUT') @include('admin.rooms._form')<button class="btn btn-primary mt-3">Save</button></form></div></div>
@endsection
