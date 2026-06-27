@extends('layouts.auth')
@section('title','Student Register')
@section('content')
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card ds-auth-card">
      <div class="card-body p-4">
        <h4 class="fw-bold mb-1">Create account</h4>
        <p class="text-muted small mb-4">Register to apply for student housing</p>
        <form method="POST" action="{{ route('student.register.submit') }}">@csrf
          <div class="row g-3">
            <div class="col-md-6"><label class="form-label">First name</label><input name="first_name" value="{{ old('first_name') }}" class="form-control" required></div>
            <div class="col-md-6"><label class="form-label">Last name</label><input name="last_name" value="{{ old('last_name') }}" class="form-control" required></div>
            <div class="col-12"><label class="form-label">Email</label><input type="email" name="email" value="{{ old('email') }}" class="form-control" required></div>
            <div class="col-md-6"><label class="form-label">Password</label><input type="password" name="password" class="form-control" required></div>
            <div class="col-md-6"><label class="form-label">Confirm password</label><input type="password" name="password_confirmation" class="form-control" required></div>
          </div>
          <button class="btn btn-primary btn-lg w-100 mt-4">Create account</button>
        </form>
        <p class="text-center mt-3 mb-0 small">Already registered? <a href="{{ route('student.login') }}">Sign in</a></p>
      </div>
    </div>
  </div>
</div>
@endsection
