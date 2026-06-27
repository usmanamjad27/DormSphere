@extends('layouts.admin')
@section('page_title', 'Rooms')
@section('page_subtitle', 'Room inventory across all dorms')
@section('content')
<div class="d-flex justify-content-end mb-3"><a href="{{ route('admin.rooms.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Add Room</a></div>
<div class="card ds-card"><div class="table-responsive">
<table class="table ds-table mb-0"><thead><tr><th>Dorm</th><th>Room</th><th>Type</th><th>Rent</th><th>Beds</th><th>Status</th><th></th></tr></thead>
<tbody>
@foreach($rooms as $room)
<tr>
  <td>{{ $room->dorm->name }}</td><td>{{ $room->room_number }}</td>
  <td>{{ ucfirst(str_replace('_',' ',$room->room_type)) }}</td>
  <td>€ {{ number_format($room->monthly_rent, 0) }}</td>
  <td>{{ $room->occupied_beds }}/{{ $room->capacity }}</td>
  <td>@include('partials.status-badge',['status'=>$room->status])</td>
  <td class="text-end">
    <a href="{{ route('admin.rooms.edit',$room) }}" class="btn btn-sm btn-outline-primary">Edit</a>
    <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST" class="d-inline-block ms-1" onsubmit="return confirm('Delete this room?');">
      @csrf
      @method('DELETE')
      <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
    </form>
  </td>
</tr>
@endforeach
</tbody></table></div>{{ $rooms->links() }}</div>
@endsection
