<div class="row g-3">
  <div class="col-md-6"><label class="form-label">Dorm</label>
    <select name="dorm_id" class="form-select" required>@foreach($dorms as $d)<option value="{{ $d->id }}" @selected(old('dorm_id',$room->dorm_id??'')==$d->id)>{{ $d->name }}</option>@endforeach</select>
  </div>
  <div class="col-md-3"><label class="form-label">Room Number</label><input name="room_number" class="form-control" value="{{ old('room_number',$room->room_number??'') }}" required></div>
  <div class="col-md-3"><label class="form-label">Floor</label><input type="number" name="floor" class="form-control" value="{{ old('floor',$room->floor??0) }}"></div>
  <div class="col-md-4"><label class="form-label">Type</label>
    <select name="room_type" class="form-select">@foreach(['single','double','triple','shared_flat','family_apartment'] as $t)<option value="{{ $t }}" @selected(old('room_type',$room->room_type??'single')===$t)>{{ ucfirst(str_replace('_',' ',$t)) }}</option>@endforeach</select>
  </div>
  <div class="col-md-2"><label class="form-label">Capacity</label><input type="number" name="capacity" class="form-control" value="{{ old('capacity',$room->capacity??1) }}" min="1"></div>
  @isset($room)
  <div class="col-md-2"><label class="form-label">Occupied</label><input type="number" name="occupied_beds" class="form-control" value="{{ old('occupied_beds',$room->occupied_beds) }}"></div>
  @endisset
  <div class="col-md-3"><label class="form-label">Monthly Rent (€)</label><input type="number" step="0.01" name="monthly_rent" class="form-control" value="{{ old('monthly_rent',$room->monthly_rent??0) }}"></div>
  <div class="col-md-3"><label class="form-label">Size (m²)</label><input type="number" step="0.01" name="size_sqm" class="form-control" value="{{ old('size_sqm',$room->size_sqm??'') }}"></div>
  <div class="col-md-4"><label class="form-label">Status</label>
    <select name="status" class="form-select">@foreach(['available','occupied','maintenance','reserved'] as $s)<option value="{{ $s }}" @selected(old('status',$room->status??'available')===$s)>{{ ucfirst($s) }}</option>@endforeach</select>
  </div>
  <div class="col-12"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="2">{{ old('description',$room->description??'') }}</textarea></div>
</div>
