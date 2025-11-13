<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Smart Light Control</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container py-5">
    <div class="text-center mb-5">
      <h1 class="display-5 fw-bold text-primary mb-3">Smart Light Control</h1>
      <p class="lead text-muted">Kontrol 6 lampu secara realtime</p>
    </div>

    <div class="row justify-content-center">
      @foreach ($devices as $device)
        <div class="col-xl-4 col-lg-4 col-md-6 mb-4">
          <div class="card device-card p-4 text-center shadow-lg rounded-4">
            <div class="device-icon mb-3">
              <div class="light-bulb {{ $device->status ? 'on' : 'off' }}">
                <div class="bulb-top"></div>
                <div class="bulb-bottom"></div>
                <div class="filament"></div>
                <div class="glow"></div>
              </div>
            </div>
            
            <h5 class="device-name mb-3 fw-semibold">Lampu {{ $loop->iteration }}</h5>

            <div class="form-check form-switch d-flex justify-content-center mb-3">
              <input 
                class="form-check-input device-switch" 
                type="checkbox"
                role="switch"
                data-id="{{ $device->id }}"
                {{ $device->status ? 'checked' : '' }}>
            </div>

            <div class="status-indicator mt-2">
              <span class="badge status-badge {{ $device->status ? 'bg-success' : 'bg-secondary' }}">
                {{ $device->status ? 'ON' : 'OFF' }}
              </span>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>

  <script>
    document.querySelectorAll('.device-switch').forEach(sw => {
      sw.addEventListener('change', function() {
        const id = this.dataset.id;
        const status = this.checked ? 1 : 0;
        const card = this.closest('.device-card');
        const bulb = card.querySelector('.light-bulb');
        const badge = card.querySelector('.status-badge');

        // Update UI immediately for better UX
        if (status) {
          bulb.classList.remove('off');
          bulb.classList.add('on');
          badge.textContent = 'ON';
          badge.classList.remove('bg-secondary');
          badge.classList.add('bg-success');
        } else {
          bulb.classList.remove('on');
          bulb.classList.add('off');
          badge.textContent = 'OFF';
          badge.classList.remove('bg-success');
          badge.classList.add('bg-secondary');
        }

        // Send request to server
        fetch('{{ route('devices.toggle') }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          body: JSON.stringify({ id, status })
        })
        .then(res => res.json())
        .then(data => {
          if (!data.success) {
            // Revert UI if request failed
            if (status) {
              bulb.classList.remove('on');
              bulb.classList.add('off');
              badge.textContent = 'OFF';
              badge.classList.remove('bg-success');
              badge.classList.add('bg-secondary');
              this.checked = false;
            } else {
              bulb.classList.remove('off');
              bulb.classList.add('on');
              badge.textContent = 'ON';
              badge.classList.remove('bg-secondary');
              badge.classList.add('bg-success');
              this.checked = true;
            }
          }
        })
        .catch(error => {
          console.error('Error:', error);
          // Revert UI on error
          if (status) {
            bulb.classList.remove('on');
            bulb.classList.add('off');
            badge.textContent = 'OFF';
            badge.classList.remove('bg-success');
            badge.classList.add('bg-secondary');
            this.checked = false;
          } else {
            bulb.classList.remove('off');
            bulb.classList.add('on');
            badge.textContent = 'ON';
            badge.classList.remove('bg-secondary');
            badge.classList.add('bg-success');
            this.checked = true;
          }
        });
      });
    });
  </script>
</body>
</html>