<div class="row g-3">
  <div class="col-md-6"><label class="form-label">Name</label><input name="name" class="form-control" value="{{ old('name', $dorm->name ?? '') }}" required></div>
  <div class="col-md-6"><label class="form-label">Status</label>
    <select name="status" class="form-select" required>
      @foreach(['active','inactive'] as $s)<option value="{{ $s }}" @selected(old('status', $dorm->status ?? 'active')===$s)>{{ ucfirst($s) }}</option>@endforeach
    </select>
  </div>
  <div class="col-12"><label class="form-label">Address</label><input name="address" class="form-control" value="{{ old('address', $dorm->address ?? '') }}" required></div>
  <div class="col-md-4"><label class="form-label">City</label><input name="city" class="form-control" value="{{ old('city', $dorm->city ?? '') }}" required></div>
  <div class="col-md-4"><label class="form-label">Postal Code</label><input name="postal_code" class="form-control" value="{{ old('postal_code', $dorm->postal_code ?? '') }}" required></div>
  <div class="col-md-4"><label class="form-label">Total Floors</label><input type="number" name="total_floors" class="form-control" value="{{ old('total_floors', $dorm->total_floors ?? 1) }}" min="1" required></div>
  <div class="col-md-4"><label class="form-label">Nearby University</label><input name="nearby_university" class="form-control" value="{{ old('nearby_university', $dorm->nearby_university ?? '') }}"></div>
  <div class="col-md-4"><label class="form-label">Distance to university (km)</label><input type="number" step="0.1" name="distance_to_campus_km" class="form-control" value="{{ old('distance_to_campus_km', $dorm->distance_to_campus_km ?? '') }}"></div>
  <div class="col-md-4"><label class="form-label">Capacity (rooms/places)</label><input type="number" name="capacity" class="form-control" value="{{ old('capacity', $dorm->capacity ?? '') }}" min="0"></div>
  <div class="col-12"><label class="form-label">Typical room types</label><input name="typical_room_types" class="form-control" value="{{ old('typical_room_types', isset($dorm) && $dorm->typical_room_types ? implode(', ', $dorm->typical_room_types) : '') }}" placeholder="Single rooms, WGs, Apartments"></div>
  <div class="col-md-6"><label class="form-label">Monthly rent range</label><input name="extra_details[monthly_rent_range]" class="form-control" value="{{ old('extra_details.monthly_rent_range', $dorm->extra_details['monthly_rent_range'] ?? '') }}" placeholder="€250-€450"></div>
  <div class="col-md-6"><label class="form-label">Deposit amount</label><input name="extra_details[deposit_amount]" class="form-control" value="{{ old('extra_details.deposit_amount', $dorm->extra_details['deposit_amount'] ?? '') }}" placeholder="€300-€800"></div>
  <div class="col-md-4"><label class="form-label">Furnished / unfurnished</label><input name="extra_details[furnished]" class="form-control" value="{{ old('extra_details.furnished', $dorm->extra_details['furnished'] ?? '') }}" placeholder="Furnished / Unfurnished / Mixed"></div>
  <div class="col-md-4"><label class="form-label">Bathroom</label><input name="extra_details[bathroom]" class="form-control" value="{{ old('extra_details.bathroom', $dorm->extra_details['bathroom'] ?? '') }}" placeholder="Private / Shared"></div>
  <div class="col-md-4"><label class="form-label">Kitchen</label><input name="extra_details[kitchen]" class="form-control" value="{{ old('extra_details.kitchen', $dorm->extra_details['kitchen'] ?? '') }}" placeholder="Private / Shared"></div>
  <div class="col-md-4"><label class="form-label">Internet included</label><input name="extra_details[internet_included]" class="form-control" value="{{ old('extra_details.internet_included', $dorm->extra_details['internet_included'] ?? '') }}" placeholder="Yes / No"></div>
  <div class="col-md-4"><label class="form-label">Utilities included</label><input name="extra_details[utilities_included]" class="form-control" value="{{ old('extra_details.utilities_included', $dorm->extra_details['utilities_included'] ?? '') }}" placeholder="Yes / No"></div>
  <div class="col-md-4"><label class="form-label">Laundry facilities</label><input name="extra_details[laundry_facilities]" class="form-control" value="{{ old('extra_details.laundry_facilities', $dorm->extra_details['laundry_facilities'] ?? '') }}" placeholder="On-site laundry"></div>
  <div class="col-md-4"><label class="form-label">Bike parking</label><input name="extra_details[bike_parking]" class="form-control" value="{{ old('extra_details.bike_parking', $dorm->extra_details['bike_parking'] ?? '') }}" placeholder="Yes / No"></div>
  <div class="col-md-4"><label class="form-label">Waiting list duration</label><input name="extra_details[waiting_list_duration]" class="form-control" value="{{ old('extra_details.waiting_list_duration', $dorm->extra_details['waiting_list_duration'] ?? '') }}" placeholder="3-6 months"></div>
  <div class="col-md-4"><label class="form-label">Application opening month</label><input name="extra_details[application_opening_month]" class="form-control" value="{{ old('extra_details.application_opening_month', $dorm->extra_details['application_opening_month'] ?? '') }}" placeholder="March"></div>
  <div class="col-md-4"><label class="form-label">Maximum rental duration</label><input name="extra_details[maximum_rental_duration]" class="form-control" value="{{ old('extra_details.maximum_rental_duration', $dorm->extra_details['maximum_rental_duration'] ?? '') }}" placeholder="24 months"></div>
  <div class="col-md-4"><label class="form-label">Public transport connection</label><input name="extra_details[public_transport_connection]" class="form-control" value="{{ old('extra_details.public_transport_connection', $dorm->extra_details['public_transport_connection'] ?? '') }}" placeholder="Good tram/bus connections"></div>
  <div class="col-md-4"><label class="form-label">International student quota</label><input name="extra_details[international_student_quota]" class="form-control" value="{{ old('extra_details.international_student_quota', $dorm->extra_details['international_student_quota'] ?? '') }}" placeholder="Varies"></div>
  <div class="col-md-4"><label class="form-label">Guest policy</label><input name="extra_details[guest_policy]" class="form-control" value="{{ old('extra_details.guest_policy', $dorm->extra_details['guest_policy'] ?? '') }}" placeholder="Guests allowed with notice"></div>
  <div class="col-12"><label class="form-label">Contract cancellation period</label><input name="extra_details[contract_cancellation_period]" class="form-control" value="{{ old('extra_details.contract_cancellation_period', $dorm->extra_details['contract_cancellation_period'] ?? '') }}" placeholder="1 month"></div>
  <div class="col-12"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="3">{{ old('description', $dorm->description ?? '') }}</textarea></div>
  <div class="col-12"><label class="form-label">Cover image URL <small class="text-muted">(or upload below)</small></label><input name="cover_image_url" class="form-control" value="{{ old('cover_image_url', $dorm->cover_image_url ?? '') }}" placeholder="https://..."></div>
  <div class="col-12"><label class="form-label">Upload cover photo</label><input type="file" name="cover_photo_file" class="form-control" accept="image/*"></div>
  <div class="col-12"><label class="form-label">Amenities <small class="text-muted">(comma-separated)</small></label>
    <input name="amenities" class="form-control" value="{{ old('amenities', isset($dorm) ? implode(', ', $dorm->amenities ?? []) : '') }}">
  </div>
  @php
    $roomPricingValue = old('room_type_pricing');
    if ($roomPricingValue === null && isset($dorm) && $dorm->room_type_pricing) {
      $roomPricingValue = collect($dorm->room_type_pricing)->map(fn($price, $type) => "{$type}:{$price}")->join(', ');
    }
  @endphp
  <div class="col-12"><label class="form-label">Room type pricing</label>
    <textarea name="room_type_pricing" class="form-control font-monospace small" rows="2" placeholder="single:950, double:720">{{ $roomPricingValue }}</textarea>
    <div class="form-text">Enter pricing as plain text type:value pairs, separated by commas or new lines (single:950, double:720).</div>
  </div>
</div>
