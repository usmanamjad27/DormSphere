@extends('layouts.app')

@section('logout_route', route('student.logout'))

@section('sidebar')
<nav class="nav flex-column">
  @php $r = request()->route()?->getName(); @endphp
  <a class="nav-link {{ $r === 'student.dashboard' ? 'active' : '' }}" href="{{ route('student.dashboard') }}"><i class="bi bi-house me-2"></i> Dashboard</a>
  <a class="nav-link {{ in_array($r, ['student.apply','student.application']) ? 'active' : '' }}" href="{{ route('student.application') }}"><i class="bi bi-file-earmark-plus me-2"></i> My Application</a>
  <a class="nav-link {{ $r === 'student.room' ? 'active' : '' }}" href="{{ route('student.room') }}"><i class="bi bi-door-closed me-2"></i> My Room</a>
  <a class="nav-link {{ str_starts_with($r ?? '', 'student.maintenance') ? 'active' : '' }}" href="{{ route('student.maintenance.index') }}"><i class="bi bi-wrench me-2"></i> Maintenance</a>
  <a class="nav-link {{ $r === 'student.notices' ? 'active' : '' }}" href="{{ route('student.notices') }}"><i class="bi bi-bell me-2"></i> Notices</a>
  <a class="nav-link {{ $r === 'student.house-rules' ? 'active' : '' }}" href="{{ route('student.house-rules') }}"><i class="bi bi-journal-check me-2"></i> House Rules</a>
  <a class="nav-link {{ str_starts_with($r ?? '', 'student.profile') ? 'active' : '' }}" href="{{ route('student.profile') }}"><i class="bi bi-person me-2"></i> Profile</a>
</nav>
@endsection

@section('mobile_nav')
  <li><a class="dropdown-item" href="{{ route('student.dashboard') }}">Dashboard</a></li>
  <li><a class="dropdown-item" href="{{ route('student.application') }}">Application</a></li>
  <li><a class="dropdown-item" href="{{ route('student.maintenance.index') }}">Maintenance</a></li>
@endsection
