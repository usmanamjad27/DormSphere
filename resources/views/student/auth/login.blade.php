@extends('layouts.auth')
@section('title','Student Login')
@section('content')
<div class="row justify-content-center">
  <div class="col-md-5">
    <div class="card ds-auth-card">
      <div class="card-body p-4">
        <h4 class="fw-bold mb-1">Welcome back</h4>
        <p class="text-muted small mb-4">Sign in to your student portal</p>
        <form method="POST" action="{{ route('student.login.submit') }}">@csrf
          <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" value="{{ old('email') }}" class="form-control form-control-lg" required autofocus></div>
          <div class="mb-3"><label class="form-label">Password</label><input type="password" name="password" class="form-control form-control-lg" required></div>
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="form-check mb-0"><input type="checkbox" class="form-check-input" name="remember" id="remember"><label class="form-check-label" for="remember">Remember me</label></div>
            <a href="{{ route('password.request') }}" class="small text-decoration-none">Forgot password?</a>
          </div>
          <button class="btn btn-primary btn-lg w-100">Sign in</button>
        </form>
        <p class="text-center mt-3 mb-0 small">No account? <a href="{{ route('student.register') }}">Register here</a></p>
      </div>
    </div>
  </div>
</div>
@endsection
