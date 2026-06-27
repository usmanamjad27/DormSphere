<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DormSphere — Smart Student Housing Allocation</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/dormsphere.css') }}" rel="stylesheet">
    <style>
      .ds-hero {
        min-height: 100vh;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        position: relative;
        color: #fff;
      }
      .ds-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: rgba(15, 23, 42, 0.65);
      }
      .ds-hero-content {
        position: relative;
        z-index: 1;
      }
    </style>
</head>
<body>
<nav class="navbar navbar-dark navbar-expand-lg position-absolute w-100" style="z-index:10;background:transparent;">
  <div class="container">
    <a class="navbar-brand fw-bold" href="#"><i class="bi bi-building me-2"></i>DormSphere</a>
    <div class="d-flex gap-2">
      <a href="{{ route('student.login') }}" class="btn btn-outline-light btn-sm">Student Login</a>
      <a href="{{ route('admin.login') }}" class="btn btn-light btn-sm text-dark">Admin Portal</a>
    </div>
  </div>
</nav>

<section class="ds-hero d-flex align-items-center" style="background-image: linear-gradient(rgba(15,23,42,0.45), rgba(15,23,42,0.45)), url('{{ $heroImage ?? 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=1600&q=80' }}');">
  <div class="container ds-hero-content py-5">
    <div class="row align-items-center g-5">
      <div class="col-lg-7">
        <span class="badge bg-white bg-opacity-10 text-white mb-3 px-3 py-2">Swiss student residences</span>
        <h1 class="display-4 fw-bold mb-4">Allocate rooms smarter.<br>Live better on campus.</h1>
        <p class="lead text-white-50 mb-4">DormSphere streamlines housing applications, room assignments, maintenance, and resident communications — all in one professional platform.</p>
        <div class="d-flex flex-wrap gap-3">
          <a href="{{ route('student.register') }}" class="btn btn-light btn-lg px-4 text-dark fw-semibold">Apply for Housing</a>
          <a href="{{ route('student.login') }}" class="btn btn-outline-light btn-lg px-4">Student Sign In</a>
        </div>
      </div>
      <div class="col-lg-5">
        <div class="card ds-card border-0 bg-white bg-opacity-10 text-white p-4">
          <h5 class="fw-semibold mb-3"><i class="bi bi-stars text-warning me-2"></i>Platform highlights</h5>
          <ul class="list-unstyled mb-0">
            <li class="mb-3"><i class="bi bi-check-circle-fill text-success me-2"></i>Online applications &amp; status tracking</li>
            <li class="mb-3"><i class="bi bi-check-circle-fill text-success me-2"></i>Real-time room availability</li>
            <li class="mb-3"><i class="bi bi-check-circle-fill text-success me-2"></i>Maintenance request portal</li>
            <li><i class="bi bi-check-circle-fill text-success me-2"></i>Announcements &amp; house rules</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="py-5 bg-white">
  <div class="container py-4">
    <div class="row g-4 text-center">
      <div class="col-md-4">
        <div class="p-4">
          <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex p-3 mb-3"><i class="bi bi-file-earmark-check fs-2 text-primary"></i></div>
          <h5>Easy Applications</h5>
          <p class="text-muted mb-0">Students submit preferences and track approval from one dashboard.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="p-4">
          <div class="rounded-circle bg-success bg-opacity-10 d-inline-flex p-3 mb-3"><i class="bi bi-grid-3x3-gap fs-2 text-success"></i></div>
          <h5>Admin Control</h5>
          <p class="text-muted mb-0">Manage dorms, rooms, residents, and allocations with clarity.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="p-4">
          <div class="rounded-circle bg-info bg-opacity-10 d-inline-flex p-3 mb-3"><i class="bi bi-tools fs-2 text-info"></i></div>
          <h5>Operations</h5>
          <p class="text-muted mb-0">Maintenance workflows and notices keep communities informed.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<footer class="py-4 bg-dark text-white-50 text-center small">
  &copy; {{ date('Y') }} DormSphere. Student housing allocation system.
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
