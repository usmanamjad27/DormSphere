@extends('layouts.admin')
@section('page_title','My Profile')
@section('content')
<div class="card ds-card col-lg-8"><div class="card-body">
<form method="POST" action="{{ route('admin.profile.update') }}">@csrf @method('PUT')
  <div class="mb-3"><label class="form-label">Full name</label><input name="full_name" class="form-control" value="{{ old('full_name',$admin->full_name) }}" required></div>
  <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ old('email',$admin->email) }}"></div>
  <div class="mb-3"><label class="form-label">Phone</label><input name="phone" class="form-control" value="{{ old('phone',$admin->phone) }}"></div>
  <hr>
  <div class="mb-3"><label class="form-label">New password</label><input type="password" name="password" class="form-control"></div>
  <div class="mb-3"><label class="form-label">Confirm password</label><input type="password" name="password_confirmation" class="form-control"></div>
  <button class="btn btn-primary">Update profile</button>
</form>
<p class="small text-muted mt-3 mb-0">Username: <strong>{{ $admin->username }}</strong> (cannot be changed here)</p>
</div></div>
@endsection
