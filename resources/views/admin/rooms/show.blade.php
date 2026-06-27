@extends('layouts.admin')
@section('page_title','Room '.$room->room_number)
@section('content')
<div class="card ds-card"><div class="card-body">
  <h5>{{ $room->dorm->name }} — Room {{ $room->room_number }}</h5>
  <p>{{ $room->description }}</p>
  <p>Rent: € {{ number_format($room->monthly_rent,2) }} · Beds: {{ $room->occupied_beds }}/{{ $room->capacity }}</p>
  @include('partials.status-badge',['status'=>$room->status])
</div></div>
@endsection
