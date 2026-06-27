@extends('layouts.admin')
@section('page_title','Application '.$application->application_number)
@section('content')
<div class="row g-4">
  <div class="col-lg-6">
    <div class="card ds-card"><div class="card-body">
      <h5>{{ $application->student->full_name }}</h5>
      <p class="text-muted">{{ $application->student->email }}</p>
      <p>Status: @include('partials.status-badge',['status'=>$application->status])</p>

      @if($application->personalInfo)
        <hr><h6>Personal</h6>
        <p><strong>Nationality:</strong> {{ $application->personalInfo->nationality }}</p>
        <p><strong>Origin:</strong> {{ $application->personalInfo->country_of_origin }}</p>
        <p><strong>Phone:</strong> {{ $application->personalInfo->phone }}</p>
      @endif

      @if($application->housingPref)
        <hr><h6>Housing</h6>
        <p><strong>Dorm:</strong> {{ $application->housingPref->preferredDorm?->name }}</p>
        <p><strong>Room type:</strong> {{ ucfirst(str_replace('_',' ',$application->housingPref->preferred_room_type)) }}</p>
        <p><strong>Move-in:</strong> {{ $application->housingPref->desired_move_in_date?->format('M d, Y') }}</p>
        <p><strong>Requirements:</strong> {{ $application->housingPref->special_requirements ?? '—' }}</p>
      @endif

      @if($application->estimated_monthly_rent)
        <p><strong>Quoted rent:</strong> € {{ number_format($application->estimated_monthly_rent, 0) }}/mo</p>
      @endif

      @foreach($application->documents as $doc)
        <p class="mb-1"><a href="{{ $doc->url() }}" target="_blank" class="btn btn-sm btn-outline-secondary"><i class="bi bi-paperclip"></i> {{ $doc->file_name }}</a></p>
      @endforeach

      @if($application->allocation)
        <hr><p class="mb-0"><strong>Allocated:</strong> {{ $application->allocation->room->label() }}</p>
      @endif
    </div></div>
  </div>
  <div class="col-lg-6">
    <div class="card ds-card"><div class="card-body">
      <h5 class="mb-3">Update application</h5>
      <form method="POST" action="{{ route('admin.applications.update', $application) }}">@csrf @method('PUT')
        <div class="mb-3"><label class="form-label">Status</label>
          <select name="status" class="form-select" required>
            @foreach(['pending','under_review','approved','rejected','waitlisted','withdrawn'] as $s)
              <option value="{{ $s }}" @selected($application->status===$s)>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
            @endforeach
          </select>
        </div>
        <div class="mb-3"><label class="form-label">Assign room (for approval)</label>
          <select name="room_id" class="form-select">
            <option value="">— Select room —</option>
            @foreach($availableRooms as $room)
              <option value="{{ $room->id }}">{{ $room->label() }} — € {{ number_format($room->monthly_rent,0) }}</option>
            @endforeach
          </select>
        </div>
        <div class="mb-3"><label class="form-label">Move-in date</label><input type="date" name="move_in_date" class="form-control" value="{{ date('Y-m-d') }}"></div>
        <button class="btn btn-primary w-100">Save decision</button>
      </form>
    </div></div>
  </div>
</div>
@endsection
