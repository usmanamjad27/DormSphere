@php
  $map = [
    'pending' => 'ds-badge-pending',
    'under_review' => 'ds-badge-review',
    'approved' => 'ds-badge-approved',
    'rejected' => 'ds-badge-rejected',
    'waitlisted' => 'ds-badge-review',
    'withdrawn' => 'bg-secondary text-white',
    'open' => 'ds-badge-pending',
    'in_progress' => 'ds-badge-review',
    'resolved' => 'ds-badge-approved',
    'closed' => 'bg-secondary text-white',
    'available' => 'ds-badge-approved',
    'occupied' => 'ds-badge-review',
    'maintenance' => 'ds-badge-pending',
    'active' => 'ds-badge-approved',
    'inactive' => 'bg-secondary text-white',
  ];
  $class = $map[$status] ?? 'bg-light text-dark';
@endphp
<span class="badge rounded-pill {{ $class }}">{{ str_replace('_', ' ', ucfirst($status)) }}</span>
