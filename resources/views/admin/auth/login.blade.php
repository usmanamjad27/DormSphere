@extends('layouts.auth')
@section('title','Admin Login')
@section('content')
<div class="row justify-content-center">
  <div class="col-md-5">
    <div class="card ds-auth-card">
      <div class="card-body p-4">
        <h4 class="fw-bold mb-1">Admin portal</h4>
        <p class="text-muted small mb-4">Sign in to manage dorms and allocations</p>
        <form method="POST" action="{{ route('admin.login.submit') }}">@csrf
          <div class="mb-3"><label class="form-label">Username</label><input name="username" value="{{ old('username') }}" class="form-control form-control-lg" required autofocus></div>
          <div class="mb-3"><label class="form-label">Password</label><input type="password" name="password" class="form-control form-control-lg" required></div>
          <div class="form-check mb-3"><input type="checkbox" class="form-check-input" name="remember" id="remember"><label class="form-check-label" for="remember">Remember me</label></div>
          <button class="btn btn-primary btn-lg w-100">Sign in</button>
        </form>
        <p class="text-center mt-3 mb-0 small text-muted">Demo: <code>admin</code> / <code>Admin@1234</code></p>
        <p class="text-center mb-0 mt-2 small"><a href="mailto:support@example.com" class="text-decoration-none text-white-50">Forgot admin password? Contact support</a></p>
      </div>
    </div>
  </div>
</div>
@endsection
