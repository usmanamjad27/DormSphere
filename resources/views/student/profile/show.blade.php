@extends('layouts.student')
@section('page_title','My Profile')
@section('content')
<div class="card ds-card col-lg-8"><div class="card-body">
<form method="POST" action="{{ route('student.profile.update') }}">@csrf @method('PUT')
  <div class="row g-3">
    <div class="col-md-6"><label class="form-label">First name</label><input name="first_name" class="form-control" value="{{ old('first_name',$student->first_name) }}" required></div>
    <div class="col-md-6"><label class="form-label">Last name</label><input name="last_name" class="form-control" value="{{ old('last_name',$student->last_name) }}" required></div>
    <div class="col-md-6"><label class="form-label">Email</label><input class="form-control" value="{{ $student->email }}" disabled></div>
    <div class="col-md-6"><label class="form-label">Phone</label><input name="phone" class="form-control" value="{{ old('phone',$student->phone) }}"></div>
    <div class="col-md-6"><label class="form-label">Date of birth</label><input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth',$student->date_of_birth?->format('Y-m-d')) }}"></div>
    <div class="col-md-6"><label class="form-label">Gender</label><select name="gender" class="form-select">@foreach(['male','female','prefer_not_to_say'] as $g)<option value="{{ $g }}" @selected(old('gender',$student->gender)===$g)>{{ ucfirst(str_replace('_',' ',$g)) }}</option>@endforeach</select></div>
    <div class="col-12"><label class="form-label">Nationality</label><input name="nationality" class="form-control" value="{{ old('nationality',$student->nationality) }}"></div>
  </div>
  <hr>
  <div class="mb-3"><label class="form-label">New password</label><input type="password" name="password" class="form-control"></div>
  <div class="mb-3"><label class="form-label">Confirm password</label><input type="password" name="password_confirmation" class="form-control"></div>
  <button class="btn btn-primary">Save changes</button>
</form>
</div></div>
@endsection
