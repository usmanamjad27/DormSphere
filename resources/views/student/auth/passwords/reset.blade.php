@extends('layouts.auth')
@section('title','Create new password')
@section('content')
<div class="row justify-content-center">
  <div class="col-md-5">
    <div class="card ds-auth-card">
      <div class="card-body p-4">
        <h4 class="fw-bold mb-1">Create a new password</h4>
        <p class="text-muted small mb-4">Choose a secure password for your student account.</p>
        <form method="POST" action="{{ route('password.update') }}">@csrf
          <input type="hidden" name="token" value="{{ $token }}">
          <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" value="{{ old('email', $email) }}" class="form-control form-control-lg" required autofocus></div>
          <div class="mb-3"><label class="form-label">New password</label><input type="password" name="password" class="form-control form-control-lg" required></div>
          <div class="mb-3"><label class="form-label">Confirm password</label><input type="password" name="password_confirmation" class="form-control form-control-lg" required></div>
          <button class="btn btn-primary btn-lg w-100">Save new password</button>
        </form>
        <p class="text-center mt-3 mb-0 small">Back to <a href="{{ route('student.login') }}">Sign in</a></p>
      </div>
    </div>
  </div>
</div>
@endsection
