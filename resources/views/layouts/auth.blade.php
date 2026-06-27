<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name')) — DormSphere</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/dormsphere.css') }}" rel="stylesheet">
</head>
<body class="ds-auth-wrap" @if(!empty($bgImage)) style="background-image: linear-gradient(rgba(15, 23, 42, 0.7), rgba(15, 23, 42, 0.7)), url('{{ $bgImage }}'); background-size: cover; background-position: center; background-repeat: no-repeat;" @endif>
<div class="container">
    <div class="text-center mb-4">
        <a href="{{ route('home') }}" class="text-white text-decoration-none">
            <span class="fs-2"><i class="bi bi-building"></i></span>
            <span class="d-block fs-3 fw-bold ds-navbar-brand">DormSphere</span>
            <small class="text-white-50">Student housing allocation platform</small>
        </a>
    </div>
    @include('partials.alerts')
    @yield('content')
    <p class="text-center mt-4 mb-0">
        <a href="{{ route('home') }}" class="text-white-50 small text-decoration-none"><i class="bi bi-arrow-left"></i> Back to home</a>
    </p>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
