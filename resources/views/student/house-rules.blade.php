@extends('layouts.student')
@section('page_title','House Rules')
@section('page_subtitle','Please read and follow these community guidelines')
@section('content')
<div class="accordion" id="rules">
@foreach($rules as $i => $rule)
  <div class="accordion-item border-0 mb-2 shadow-sm rounded-3 overflow-hidden">
    <h2 class="accordion-header"><button class="accordion-button {{ $i ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#rule{{ $rule->id }}">{{ $rule->section_title }}</button></h2>
    <div id="rule{{ $rule->id }}" class="accordion-collapse collapse {{ $i ? '' : 'show' }}" data-bs-parent="#rules"><div class="accordion-body">{{ $rule->content }}</div></div>
  </div>
@endforeach
</div>
@endsection
