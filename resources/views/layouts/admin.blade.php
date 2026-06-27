@extends('layouts.app')

@section('logout_route', route('admin.logout'))

@section('sidebar')
<nav class="nav flex-column">
  @php $r = request()->route()?->getName(); @endphp
  <a class="nav-link {{ str_starts_with($r ?? '', 'admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
  <a class="nav-link {{ str_starts_with($r ?? '', 'admin.dorms') ? 'active' : '' }}" href="{{ route('admin.dorms.index') }}"><i class="bi bi-buildings me-2"></i> Dorms</a>
  <a class="nav-link {{ str_starts_with($r ?? '', 'admin.rooms') ? 'active' : '' }}" href="{{ route('admin.rooms.index') }}"><i class="bi bi-door-open me-2"></i> Rooms</a>
  <a class="nav-link {{ str_starts_with($r ?? '', 'admin.applications') ? 'active' : '' }}" href="{{ route('admin.applications.index') }}"><i class="bi bi-file-earmark-text me-2"></i> Applications</a>
  <a class="nav-link {{ str_starts_with($r ?? '', 'admin.residents') ? 'active' : '' }}" href="{{ route('admin.residents.index') }}"><i class="bi bi-people me-2"></i> Residents</a>
  <a class="nav-link {{ str_starts_with($r ?? '', 'admin.maintenance') ? 'active' : '' }}" href="{{ route('admin.maintenance.index') }}"><i class="bi bi-tools me-2"></i> Maintenance</a>
  <a class="nav-link {{ str_starts_with($r ?? '', 'admin.announcements') ? 'active' : '' }}" href="{{ route('admin.announcements.index') }}"><i class="bi bi-megaphone me-2"></i> Announcements</a>
  <a class="nav-link {{ str_starts_with($r ?? '', 'admin.house-rules') ? 'active' : '' }}" href="{{ route('admin.house-rules.index') }}"><i class="bi bi-journal-text me-2"></i> House Rules</a>
  <a class="nav-link {{ str_starts_with($r ?? '', 'admin.reports') ? 'active' : '' }}" href="{{ route('admin.reports') }}"><i class="bi bi-bar-chart me-2"></i> Reports</a>
  <a class="nav-link {{ str_starts_with($r ?? '', 'admin.profile') ? 'active' : '' }}" href="{{ route('admin.profile') }}"><i class="bi bi-person-circle me-2"></i> Profile</a>
</nav>
@endsection

@section('mobile_nav')
  <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
  <li><a class="dropdown-item" href="{{ route('admin.dorms.index') }}">Dorms</a></li>
  <li><a class="dropdown-item" href="{{ route('admin.applications.index') }}">Applications</a></li>
  <li><a class="dropdown-item" href="{{ route('admin.maintenance.index') }}">Maintenance</a></li>
@endsection
