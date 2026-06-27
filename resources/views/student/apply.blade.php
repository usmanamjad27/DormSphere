@extends('layouts.student')
@section('page_title', 'Apply for Housing')
@section('page_subtitle', 'Upload documents, view dorm photos, and see live pricing')

@push('styles')
<style>
  .dorm-gallery { border-radius: 1rem; overflow: hidden; background: #0f172a; min-height: 220px; }
  .dorm-gallery img { width: 100%; height: 220px; object-fit: cover; }
  .price-panel { background: linear-gradient(135deg, #312e81, #4f46e5); color: #fff; border-radius: 1rem; }
  .price-panel .amount { font-size: 2rem; font-weight: 700; }
  .google-badge { font-size: .7rem; opacity: .85; }
</style>
@endpush

@section('content')
<div class="row g-4">
  <div class="col-lg-7">
    <div class="card ds-card">
      <div class="card-body">
        <form method="POST" action="{{ route('student.apply.submit') }}" enctype="multipart/form-data" id="apply-form">@csrf

          <h6 class="text-uppercase text-muted small fw-semibold mb-3">Housing preferences</h6>
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label">Select university</label>
              <select id="university-select" class="form-select">
                <option value="">All universities</option>
                @foreach($universities as $university)
                  <option value="{{ $university }}">{{ $university }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Preferred dorm</label>
              <select name="preferred_dorm_id" id="dorm-select" class="form-select" required>
                @foreach($dorms as $dorm)
                  @php
                    $distanceLabel = $dorm->distance_to_campus_km
                      ? ' · '.$dorm->distance_to_campus_km.' km to campus'
                      : '';
                  @endphp
                  <option value="{{ $dorm->id }}" data-university="{{ $dorm->nearby_university }}" data-distance="{{ $dorm->distance_to_campus_km }}" @selected($loop->first)>
                    {{ $dorm->name }} — {{ $dorm->city }} ({{ $dorm->rooms_count }} rooms{{ $distanceLabel }})
                  </option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Preferred room type</label>
            <select name="room_type" id="room-type-select" class="form-select" required>
              @foreach(['single','double','triple','shared_flat','family_apartment'] as $t)
                <option value="{{ $t }}">{{ ucfirst(str_replace('_', ' ', $t)) }}</option>
              @endforeach
            </select>
          </div>

          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label">Room required from</label>
              <input type="date" name="desired_move_in_date" class="form-control" value="{{ old('desired_move_in_date', now()->addMonth()->format('Y-m-d')) }}" min="{{ date('Y-m-d') }}" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Contract duration</label>
              <select name="contract_duration" class="form-select" required>
                @foreach(['1_semester'=>'1 Semester','2_semesters'=>'2 Semesters','1_year'=>'1 Year','2_years'=>'2 Years','indefinite'=>'Indefinite'] as $val => $label)
                  <option value="{{ $val }}" @selected(old('contract_duration')===$val)>{{ $label }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Max distance to campus (km)</label>
            <input type="number" name="preferred_max_distance_km" class="form-control" step="0.1" min="0" max="50" placeholder="e.g. 2.5" value="{{ old('preferred_max_distance_km') }}">
            <div class="form-text">How far you are willing to live from your university campus.</div>
          </div>

          <hr>
          <h6 class="text-uppercase text-muted small fw-semibold mb-3">Personal details</h6>
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label">Nationality</label>
              <input name="nationality" class="form-control" value="{{ old('nationality', $student->nationality) }}" required placeholder="e.g. Swiss">
            </div>
            <div class="col-md-6">
              <label class="form-label">Country of origin</label>
              <input name="country_of_origin" class="form-control" value="{{ old('country_of_origin', $student->country_of_origin) }}" required placeholder="e.g. Switzerland">
            </div>
            <div class="col-md-6">
              <label class="form-label">Phone</label>
              <input name="phone" class="form-control" value="{{ old('phone', $student->phone) }}" placeholder="+41 79 000 0000">
            </div>
            <div class="col-md-6">
              <label class="form-label">Home city</label>
              <input name="home_city" class="form-control" value="{{ old('home_city') }}">
            </div>
            <div class="col-12">
              <label class="form-label">Home address</label>
              <input name="home_address" class="form-control" value="{{ old('home_address') }}" placeholder="Street and number">
            </div>
            <div class="col-md-6">
              <label class="form-label">Postal code</label>
              <input name="postal_code" class="form-control" value="{{ old('postal_code') }}">
            </div>
            <div class="col-md-6">
              <label class="form-label">Home country</label>
              <input name="home_country" class="form-control" value="{{ old('home_country') }}">
            </div>
          </div>

          <hr>
          <h6 class="text-uppercase text-muted small fw-semibold mb-3">Documents</h6>
          <div class="mb-3">
            <label class="form-label">Admission letter <span class="text-danger">*</span></label>
            <input type="file" name="admission_letter" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
            <div class="form-text">PDF or image, max 5 MB. University admission / enrollment confirmation.</div>
          </div>

          <div class="mb-4">
            <label class="form-label">Additional notes</label>
            <textarea name="notes" class="form-control" rows="3" placeholder="Accessibility needs, roommate preferences, etc.">{{ old('notes') }}</textarea>
          </div>

          <button type="submit" class="btn btn-primary btn-lg"><i class="bi bi-send me-1"></i> Submit application</button>
        </form>
      </div>
    </div>
  </div>

  <div class="col-lg-5">
    <div class="dorm-gallery mb-3 position-relative" id="dorm-gallery">
      <img src="" alt="Dorm preview" id="gallery-main" class="d-none">
      <div id="gallery-placeholder" class="d-flex align-items-center justify-content-center text-white-50 p-5">
        <span><i class="bi bi-image fs-1 d-block text-center mb-2"></i>Loading dorm photos…</span>
      </div>
    </div>
    <div class="d-flex gap-2 mb-3 flex-wrap" id="gallery-thumbs"></div>
    <p class="small google-badge text-muted mb-3" id="google-source">
      <i class="bi bi-google"></i> Photos from Google Places when API key is configured; otherwise illustrative images.
      <a href="#" target="_blank" rel="noopener" id="maps-link" class="ms-1 d-none">View on Google Maps</a>
    </p>

    <div id="dorm-meta" class="card ds-card mb-3 d-none">
      <div class="card-body small">
        <p class="mb-1" id="dorm-address"></p>
        <p class="mb-0 text-muted" id="dorm-distance"></p>
        <div id="dorm-extra-details" class="mt-2 text-muted small"></div>
      </div>
    </div>

    <div class="price-panel p-4" id="price-panel">
      <div class="small text-white-50 mb-1">Estimated monthly rent</div>
      <div class="amount" id="price-amount">€ —</div>
      <div class="row g-2 mt-3 small">
        <div class="col-6"><span class="text-white-50">Deposit (2 months)</span><br><strong id="price-deposit">—</strong></div>
        <div class="col-6"><span class="text-white-50">6-month estimate</span><br><strong id="price-semester">—</strong></div>
        <div class="col-12 mt-2"><span class="text-white-50">Available rooms (this type)</span><br><strong id="price-available">—</strong></div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
  const universitySelect = document.getElementById('university-select');
  const dormSelect = document.getElementById('dorm-select');
  const roomSelect = document.getElementById('room-type-select');
  const galleryMain = document.getElementById('gallery-main');
  const galleryPlaceholder = document.getElementById('gallery-placeholder');
  const thumbs = document.getElementById('gallery-thumbs');
  const mapsLink = document.getElementById('maps-link');
  const dormMeta = document.getElementById('dorm-meta');
  function formatEuro(n) {
    return '€ ' + Number(n).toLocaleString('de-DE', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
  }

  function setMainImage(url) {
    galleryMain.src = url;
    galleryMain.classList.remove('d-none');
    galleryPlaceholder.classList.add('d-none');
  }

  function loadGallery(dormId) {
    galleryPlaceholder.classList.remove('d-none');
    galleryMain.classList.add('d-none');
    thumbs.innerHTML = '';

    fetch(`/student/apply/dorms/${dormId}/preview`, {
      headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
    })
      .then(r => r.json())
      .then(data => {
        const images = data.images || [];
        if (images.length) {
          setMainImage(images[0]);
          images.forEach((url, i) => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'btn p-0 border-0 rounded overflow-hidden';
            btn.style.width = '72px';
            btn.style.height = '48px';
            btn.innerHTML = `<img src="${url}" alt="" style="width:100%;height:100%;object-fit:cover">`;
            btn.onclick = () => setMainImage(url);
            thumbs.appendChild(btn);
          });
        } else {
          galleryPlaceholder.innerHTML = '<span class="text-white-50">No photos available</span>';
        }

        document.getElementById('dorm-address').textContent = data.address + ', ' + data.city;
        const dist = data.distance_to_campus_km;
        const university = data.nearby_university ? `University: ${data.nearby_university}` : '';
        const capacity = data.capacity ? `Capacity: ${data.capacity}` : '';
        document.getElementById('dorm-distance').textContent = [
          university,
          capacity,
          dist ? `Distance: ${dist} km` : ''
        ].filter(Boolean).join(' · ');
        const extraDetails = data.extra_details || {};
        const detailsItems = Object.entries(extraDetails).map(([key, value]) => {
          return `<div><strong>${key.replace(/[_-]/g, ' ').replace(/\b\w/g, c => c.toUpperCase())}:</strong> ${value}</div>`;
        });
        document.getElementById('dorm-extra-details').innerHTML = detailsItems.join('');
        dormMeta.classList.remove('d-none');

        if (data.google_maps_url) {
          mapsLink.href = data.google_maps_url;
          mapsLink.classList.remove('d-none');
        }
      })
      .catch(() => {
        galleryPlaceholder.textContent = 'Could not load photos.';
      });
  }

  function loadPrice() {
    const params = new URLSearchParams({
      dorm_id: dormSelect.value,
      room_type: roomSelect.value
    });
    fetch(`/student/apply/estimate-price?${params}`, {
      headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
    })
      .then(r => r.json())
      .then(p => {
        document.getElementById('price-amount').textContent = formatEuro(p.monthly_rent);
        document.getElementById('price-deposit').textContent = formatEuro(p.deposit);
        document.getElementById('price-semester').textContent = formatEuro(p.semester_estimate);
        document.getElementById('price-available').textContent = p.available_rooms + ' room(s)';
      });
  }

  function filterDorms() {
    const selectedUniversity = universitySelect.value;
    const options = Array.from(dormSelect.options);

    options.forEach(option => {
      const university = option.dataset.university || '';
      option.hidden = selectedUniversity && university !== selectedUniversity;
    });

    const visible = options.filter(option => !option.hidden);
    if (visible.length > 0) {
      dormSelect.value = visible[0].value;
    }
  }

  function refresh() {
    filterDorms();
    loadGallery(dormSelect.value);
    loadPrice();
  }

  universitySelect.addEventListener('change', refresh);
  dormSelect.addEventListener('change', refresh);
  roomSelect.addEventListener('change', loadPrice);
  refresh();
})();
</script>
@endpush
