@extends('layouts.admin')
@section('page_title','Residents')
@section('page_subtitle','Students with active room allocations')
@section('content')
<div class="card ds-card"><div class="table-responsive">
<table class="table ds-table mb-0"><thead><tr><th>Student</th><th>Room</th><th>Move-in</th><th>Rent</th><th></th></tr></thead>
<tbody>@forelse($residents as $r)
<tr>
  <td>{{ $r->student->full_name }}</td>
  <td>{{ $r->room->label() }}</td>
  <td>{{ $r->move_in_date->format('M d, Y') }}</td>
  <td>€ {{ number_format($r->monthly_rent,0) }}</td>
  <td><a href="{{ route('admin.residents.show',$r) }}" class="btn btn-sm btn-light">Details</a></td>
</tr>@empty<tr><td colspan="5" class="text-center text-muted py-4">No active residents.</td></tr>@endforelse</tbody>
</table></div>{{ $residents->links() }}</div>
@endsection
