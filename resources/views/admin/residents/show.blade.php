@extends('layouts.admin')
@section('page_title','Resident Details')
@section('content')
<div class="card ds-card"><div class="card-body">
  <h5>{{ $allocation->student->full_name }}</h5>
  <p>{{ $allocation->room->label() }}</p>
  <p>Monthly rent: € {{ number_format($allocation->monthly_rent,2) }} · Deposit: € {{ number_format($allocation->deposit_amount,2) }}</p>
  <p>Move-in: {{ $allocation->move_in_date->format('F j, Y') }}</p>
</div></div>
@endsection
