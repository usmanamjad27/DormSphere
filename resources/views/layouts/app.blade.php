<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name')) — DormSphere</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/dormsphere.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
<div class="d-flex ds-layout">
  <aside class="ds-sidebar p-3 d-none d-lg-block">
    <a href="{{ route('home') }}" class="text-white text-decoration-none d-flex align-items-center gap-2 mb-4 px-2">
      <span class="fs-4"><i class="bi bi-building"></i></span>
      <span class="ds-navbar-brand fs-5">DormSphere</span>
    </a>
    @yield('sidebar')
    <div class="mt-auto pt-4 border-top border-secondary">
      <form method="POST" action="@yield('logout_route')">
        @csrf
        <button class="btn btn-outline-light btn-sm w-100"><i class="bi bi-box-arrow-right me-1"></i> Sign out</button>
      </form>
    </div>
  </aside>

  <div class="ds-main w-100">
    <nav class="navbar navbar-light bg-white border-bottom d-lg-none mb-3 rounded-3 shadow-sm">
      <div class="container-fluid">
        <span class="navbar-brand mb-0 h6"><i class="bi bi-building text-primary"></i> DormSphere</span>
        <div class="dropdown">
          <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">Menu</button>
          <ul class="dropdown-menu dropdown-menu-end">
            @yield('mobile_nav')
            <li><hr class="dropdown-divider"></li>
            <li>
              <form method="POST" action="@yield('logout_route')">@csrf
                <button class="dropdown-item">Sign out</button>
              </form>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    @include('partials.alerts')

    <div class="ds-main-content">
    <div class="ds-page-header">
      <h1>@yield('page_title')</h1>
      @hasSection('page_subtitle')
        <p class="text-muted mb-0">@yield('page_subtitle')</p>
      @endif
    </div>

    @yield('content')
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
