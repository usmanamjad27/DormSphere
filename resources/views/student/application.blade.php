@extends('layouts.student')
@section('page_title', 'My Application')

@section('content')
@if(!$application)
  <div class="card ds-card"><div class="card-body text-center py-5">
    <p class="text-muted mb-3">You have not submitted an application yet.</p>
    <a href="{{ route('student.apply') }}" class="btn btn-primary">Start application</a>
  </div></div>
@elseif(in_array($application->status, ['rejected', 'withdrawn']))
  <div class="card ds-card"><div class="card-body text-center py-5">
    <h5 class="fw-bold mb-3">{{ $application->status === 'rejected' ? 'Application rejected' : 'Application withdrawn' }}</h5>
    <p class="text-muted mb-4">Your application was {{ $application->status }} on {{ $application->submitted_at?->format('F j, Y') }}.</p>
    <a href="{{ route('student.apply') }}" class="btn btn-primary">Apply again</a>
  </div></div>
@else
  <div class="row g-4">
    <div class="col-lg-8">
      <div class="card ds-card"><div class="card-body">
        <div class="d-flex justify-content-between align-items-start mb-3">
          <div>
            <h5 class="fw-bold mb-1">{{ $application->application_number }}</h5>
            <div class="d-flex gap-2 align-items-center">
              @include('partials.status-badge', ['status' => $application->status])
              @if($application->status === 'under_review')
                <span class="small text-muted"><i class="bi bi-info-circle"></i> Under review</span>
              @elseif($application->status === 'waitlisted')
                <span class="small text-muted"><i class="bi bi-info-circle"></i> Waitlisted</span>
              @endif
            </div>
          </div>
          @if($application->status === 'pending')
            <form method="POST" action="{{ route('student.application.withdraw') }}" onsubmit="return confirm('Withdraw this application? You will need to start over if you want to apply again.')">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn-outline-danger btn-sm">Withdraw application</button>
            </form>
          @elseif(in_array($application->status, ['under_review', 'waitlisted']))
            <span class="small text-muted"><i class="bi bi-lock"></i> Cannot withdraw during review</span>
          @endif
        </div>
        <p class="text-muted">Submitted {{ $application->submitted_at?->format('F j, Y \a\t g:i A') }}</p>

        @if($application->housingPref)
          <hr>
          <h6 class="fw-semibold">Housing</h6>
          <p><strong>Dorm:</strong> {{ $application->housingPref->preferredDorm?->name ?? '—' }}</p>
          <p><strong>Room type:</strong> {{ ucfirst(str_replace('_',' ', $application->housingPref->preferred_room_type)) }}</p>
          <p><strong>Move-in:</strong> {{ $application->housingPref->desired_move_in_date?->format('F j, Y') }}</p>
          <p><strong>Contract:</strong> {{ str_replace('_', ' ', $application->housingPref->contract_duration) }}</p>
        @endif

        @if($application->personalInfo)
          <hr>
          <h6 class="fw-semibold">Personal</h6>
          <p><strong>Nationality:</strong> {{ $application->personalInfo->nationality }}</p>
          <p><strong>Country of origin:</strong> {{ $application->personalInfo->country_of_origin }}</p>
        @endif

        @if($application->estimated_monthly_rent)
          <hr>
          <p class="mb-0"><strong>Estimated rent:</strong> € {{ number_format($application->estimated_monthly_rent, 0) }} / month</p>
        @endif

        @if($application->allocation)
          <div class="alert alert-success mt-3 mb-0">
            <i class="bi bi-check-circle me-1"></i> Assigned to <strong>{{ $application->allocation->room->label() }}</strong>
          </div>
        @endif
      </div></div>
    </div>

    <div class="col-lg-4">
      @if($application->documents->isNotEmpty())
        <div class="card ds-card"><div class="card-body">
          <h6 class="fw-semibold mb-3">Uploaded documents</h6>
          @foreach($application->documents as $doc)
            <div class="d-flex align-items-center gap-2 mb-2">
              <i class="bi bi-file-earmark-pdf text-danger"></i>
              <div class="small flex-grow-1 text-truncate">{{ $doc->file_name }}</div>
              <a href="{{ $doc->url() }}" target="_blank" class="btn btn-sm btn-outline-primary">View</a>
            </div>
          @endforeach
        </div></div>
      @endif
    </div>
  </div>
@endif
@endsection
