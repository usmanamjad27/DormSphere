@extends('layouts.auth')
@section('title','Reset password')
@section('content')
<div class="row justify-content-center">
  <div class="col-md-5">
    <div class="card ds-auth-card">
      <div class="card-body p-4">
        <h4 class="fw-bold mb-1">Reset your password</h4>
        <p class="text-muted small mb-4">Enter your email address and we will send you a link to reset your password.</p>
        <form method="POST" action="{{ route('password.email') }}">@csrf
          <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" value="{{ old('email') }}" class="form-control form-control-lg" required autofocus></div>
          <button class="btn btn-primary btn-lg w-100">Send reset link</button>
        </form>
        <p class="text-center mt-3 mb-0 small">Remembered your password? <a href="{{ route('student.login') }}">Sign in</a></p>
      </div>
    </div>
  </div>
</div>
@endsection
