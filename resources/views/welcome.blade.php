<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Monitoring DHT22 Sensor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>

    <style>
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }

      body {
        background: #0f172a;
        color: #e2e8f0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        min-height: 100vh;
        padding: 2rem 0;
      }

      .container {
        max-width: 1400px;
      }

      /* Header */
      .header {
        text-align: center;
        margin-bottom: 3rem;
        animation: slideDown 0.6s ease-out;
      }

      .header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        color: #f1f5f9;
        margin-bottom: 0.5rem;
        letter-spacing: -0.5px;
      }

      .header .subtitle {
        font-size: 1rem;
        color: #94a3b8;
      }

      /* Metric Cards */
      .metric-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
      }

      .metric-card {
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
        animation: fadeInUp 0.6s ease-out forwards;
        opacity: 0;
      }

      .metric-card:nth-child(1) { animation-delay: 0.1s; }
      .metric-card:nth-child(2) { animation-delay: 0.2s; }
      .metric-card:nth-child(3) { animation-delay: 0.3s; }

      .metric-card:hover {
        border-color: #475569;
        background: #334155;
        transform: translateY(-4px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
      }

      .metric-card .label {
        font-size: 0.9rem;
        color: #cbd5e1;
        margin-bottom: 0.5rem;
        font-weight: 500;
      }

      .metric-card .icon {
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
      }

      .metric-card .value {
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0.5rem 0;
        letter-spacing: -1px;
      }

      .metric-card.temp .icon {
        color: #ef4444;
      }

      .metric-card.temp .value {
        color: #ef4444;
      }

      .metric-card.humidity .icon {
        color: #3b82f6;
      }

      .metric-card.humidity .value {
        color: #3b82f6;
      }

      .metric-card.status .icon {
        color: #10b981;
      }

      .metric-card.status .value {
        color: #10b981;
        font-size: 1.2rem;
      }

      /* Charts Section */
      .charts-section {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 2rem;
        margin-bottom: 2rem;
      }

      .chart-card {
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 12px;
        padding: 2rem;
        animation: fadeInUp 0.6s ease-out forwards;
        opacity: 0;
        animation-delay: 0.4s;
      }

      .chart-card:hover {
        border-color: #475569;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
      }

      .chart-card h5 {
        font-size: 1.1rem;
        color: #f1f5f9;
        margin-bottom: 1.5rem;
        font-weight: 600;
      }

      .chart-container {
        position: relative;
        height: 300px;
      }

      /* Settings Card */
      .settings-card {
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 12px;
        padding: 2rem;
        animation: fadeInUp 0.6s ease-out forwards;
        opacity: 0;
        animation-delay: 0.5s;
      }

      .settings-card:hover {
        border-color: #475569;
      }

      .settings-card h3 {
        font-size: 1.3rem;
        color: #f1f5f9;
        margin-bottom: 1.5rem;
        font-weight: 600;
      }

      .form-group {
        margin-bottom: 1.5rem;
      }

      .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        color: #cbd5e1;
        font-weight: 500;
        font-size: 0.95rem;
      }

      .form-group input {
        width: 100%;
        padding: 0.75rem 1rem;
        background: #0f172a;
        border: 1px solid #475569;
        border-radius: 8px;
        color: #f1f5f9;
        font-size: 1rem;
        transition: all 0.3s ease;
      }

      .form-group input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        background: #1e293b;
      }

      .btn-submit {
        background: #3b82f6;
        color: white;
        padding: 0.75rem 2rem;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 1rem;
      }

      .btn-submit:hover {
        background: #2563eb;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.3);
      }

      .btn-submit:active {
        transform: translateY(0);
      }

      /* Footer */
      footer {
        text-align: center;
        color: #64748b;
        margin-top: 4rem;
        padding-top: 2rem;
        border-top: 1px solid #334155;
        font-size: 0.9rem;
      }

      /* Animations */
      @keyframes slideDown {
        from {
          opacity: 0;
          transform: translateY(-20px);
        }
        to {
          opacity: 1;
          transform: translateY(0);
        }
      }

      @keyframes fadeInUp {
        from {
          opacity: 0;
          transform: translateY(20px);
        }
        to {
          opacity: 1;
          transform: translateY(0);
        }
      }

      @keyframes slideIn {
        from {
          opacity: 0;
          transform: translateX(-20px);
        }
        to {
          opacity: 1;
          transform: translateX(0);
        }
      }

      @keyframes pulse {
        0%, 100% {
          opacity: 1;
        }
        50% {
          opacity: 0.7;
        }
      }

      .status-indicator {
        display: inline-block;
        width: 12px;
        height: 12px;
        background: #10b981;
        border-radius: 50%;
        animation: pulse 2s infinite;
        margin-right: 0.5rem;
      }

      /* Modal Pop-up Styles */
      .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.6);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
      }

      .modal-overlay.active {
        opacity: 1;
        visibility: visible;
      }

      .modal-content {
        background: #1e293b;
        border: 2px solid #334155;
        border-radius: 12px;
        padding: 2rem;
        max-width: 400px;
        width: 90%;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        transform: scale(0.8);
        animation: modalScale 0.3s ease-out forwards;
      }

      @keyframes modalScale {
        from {
          opacity: 0;
          transform: scale(0.8);
        }
        to {
          opacity: 1;
          transform: scale(1);
        }
      }

      .modal-header {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
        gap: 0.75rem;
      }

      .modal-header i {
        font-size: 1.5rem;
        color: #10b981;
      }

      .modal-header h5 {
        margin: 0;
        color: #f1f5f9;
        font-size: 1.2rem;
        font-weight: 600;
      }

      .modal-body {
        color: #cbd5e1;
        margin-bottom: 1.5rem;
        font-size: 0.95rem;
        line-height: 1.5;
      }

      .modal-footer {
        display: flex;
        gap: 0.75rem;
        justify-content: flex-end;
      }

      .btn-modal {
        padding: 0.6rem 1.2rem;
        border: none;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        font-size: 0.9rem;
        transition: all 0.2s ease;
      }

      .btn-close-modal {
        background: none;
        border: none;
        color: #94a3b8;
        cursor: pointer;
        font-size: 1.2rem;
        padding: 0;
        flex-shrink: 0;
        transition: color 0.2s ease;
      }

      .btn-close-modal:hover {
        color: #f1f5f9;
      }

      .btn-confirm-modal {
        background: #3b82f6;
        color: white;
      }

      .btn-confirm-modal:hover {
        background: #2563eb;
        transform: translateY(-2px);
      }

      /* Persistent Top Notification Styles */
      .notification-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 2000;
        display: flex;
        flex-direction: column;
        gap: 10px;
        max-width: 400px;
      }

      .notification {
        background: #1e293b;
        border: 2px solid #10b981;
        border-radius: 8px;
        padding: 1rem 1.5rem;
        color: #f1f5f9;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
        animation: slideInRight 0.4s ease-out, slideOutRight 0.4s ease-out 4.5s forwards;
      }

      .notification i {
        font-size: 1.3rem;
        color: #10b981;
        flex-shrink: 0;
      }

      .notification-content {
        flex: 1;
      }

      .notification-title {
        font-weight: 600;
        margin-bottom: 0.25rem;
      }

      .notification-message {
        font-size: 0.9rem;
        color: #cbd5e1;
      }

      .notification-close {
        background: none;
        border: none;
        color: #94a3b8;
        cursor: pointer;
        font-size: 1.2rem;
        padding: 0;
        flex-shrink: 0;
        transition: color 0.2s ease;
      }

      .notification-close:hover {
        color: #f1f5f9;
      }

      @keyframes slideInRight {
        from {
          opacity: 0;
          transform: translateX(400px);
        }
        to {
          opacity: 1;
          transform: translateX(0);
        }
      }

      @keyframes slideOutRight {
        from {
          opacity: 1;
          transform: translateX(0);
        }
        to {
          opacity: 0;
          transform: translateX(400px);
        }
      }

      /* Responsive */
      @media (max-width: 768px) {
        .header h1 {
          font-size: 1.8rem;
        }

        .charts-section {
          grid-template-columns: 1fr;
        }

        .metric-cards {
          gap: 1rem;
        }
      }
    </style>
  </head>

  <body>
    <!-- Notification Container -->
    <div class="notification-container" id="notificationContainer"></div>

    <div class="container">
      <!-- Header -->
      <div class="header">
        <h1>🌡️ Sensor Monitoring</h1>
        <p class="subtitle">Real-time DHT22 Temperature & Humidity Dashboard</p>
      </div>

      <!-- Metric Cards -->
      <div class="metric-cards">
        <div class="metric-card temp">
          <div class="label">Temperature</div>
          <div class="icon"><i class="fas fa-thermometer-half"></i></div>
          <div class="value"><span id="temperature">--</span>°C</div>
          <small style="color: #64748b;">Celcius</small>
        </div>

        <div class="metric-card humidity">
          <div class="label">Humidity</div>
          <div class="icon"><i class="fas fa-droplet"></i></div>
          <div class="value"><span id="humidity">--</span>%</div>
          <small style="color: #64748b;">Relative</small>
        </div>

        <div class="metric-card status">
          <div class="label">Status</div>
          <div class="icon"><i class="fas fa-circle-check"></i></div>
          <div class="value"><span class="status-indicator"></span>Active</div>
          <small style="color: #64748b;">Connected</small>
        </div>
      </div>

      <!-- Charts -->
      <div class="charts-section">
        <div class="chart-card">
          <h5><i class="fas fa-chart-line" style="color: #ef4444; margin-right: 0.5rem;"></i>Temperature Trend</h5>
          <div class="chart-container">
            <canvas id="temperatureChart"></canvas>
          </div>
        </div>

        <div class="chart-card">
          <h5><i class="fas fa-chart-line" style="color: #3b82f6; margin-right: 0.5rem;"></i>Humidity Trend</h5>
          <div class="chart-container">
            <canvas id="humidityChart"></canvas>
          </div>
        </div>
      </div>

      <!-- Settings -->
      <div class="settings-card">
        <h3>⚙️ Temperature Threshold Settings</h3>
        <form action="/update-setting" method="POST">
          @csrf
          <div class="form-group">
            <label for="threshold_temp">Temperature Limit (°C)</label>
            <input type="number" id="threshold_temp" step="0.1" name="threshold_temp" value="{{ $setting->threshold_temp ?? 30 }}" required>
          </div>
          <button type="submit" class="btn-submit">
            <i class="fas fa-save" style="margin-right: 0.5rem;"></i>Save Settings
          </button>
        </form>
      </div>

      <!-- Footer -->
      <footer>
        <p>🚀 DHT22 Monitoring Dashboard © 2025 | Real-time Data Monitoring System</p>
      </footer>
    </div>

    <!-- Modal Overlay -->
    <div class="modal-overlay" id="modalOverlay">
      <div class="modal-content">
        <div class="modal-header">
          <i class="fas fa-info-circle"></i>
          <h5>Information</h5>
        </div>
        <div class="modal-body">
          This is a modal pop-up example. You can customize its content as needed.
        </div>
        <div class="modal-footer">
          <button class="btn-modal btn-close-modal" onclick="closeModal()">Close</button>
          <button class="btn-modal btn-confirm-modal" onclick="confirmModal()">Confirm</button>
        </div>
      </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
      // Chart instances
      let tempChart, humidityChart;
      let tempData = [], humidityData = [], timeLabels = [];

      // Initialize Charts
      function initCharts() {
        const chartOptions = {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false
            }
          },
          scales: {
            y: {
              beginAtZero: false,
              grid: {
                color: 'rgba(148, 163, 184, 0.1)'
              },
              ticks: {
                color: '#94a3b8'
              }
            },
            x: {
              grid: {
                display: false
              },
              ticks: {
                color: '#94a3b8'
              }
            }
          }
        };

        // Temperature Chart
        const tempCtx = document.getElementById('temperatureChart').getContext('2d');
        tempChart = new Chart(tempCtx, {
          type: 'line',
          data: {
            labels: timeLabels,
            datasets: [{
              label: 'Temperature (°C)',
              data: tempData,
              borderColor: '#ef4444',
              backgroundColor: 'rgba(239, 68, 68, 0.1)',
              borderWidth: 2,
              fill: true,
              tension: 0.4,
              pointRadius: 4,
              pointBackgroundColor: '#ef4444',
              pointBorderColor: '#1e293b',
              pointBorderWidth: 2,
              pointHoverRadius: 6,
              segment: {
                borderCapStyle: 'round'
              }
            }]
          },
          options: chartOptions
        });

        // Humidity Chart
        const humidityCtx = document.getElementById('humidityChart').getContext('2d');
        humidityChart = new Chart(humidityCtx, {
          type: 'line',
          data: {
            labels: timeLabels,
            datasets: [{
              label: 'Humidity (%)',
              data: humidityData,
              borderColor: '#3b82f6',
              backgroundColor: 'rgba(59, 130, 246, 0.1)',
              borderWidth: 2,
              fill: true,
              tension: 0.4,
              pointRadius: 4,
              pointBackgroundColor: '#3b82f6',
              pointBorderColor: '#1e293b',
              pointBorderWidth: 2,
              pointHoverRadius: 6,
              segment: {
                borderCapStyle: 'round'
              }
            }]
          },
          options: chartOptions
        });
      }

      // Get sensor data
      function getData() {
        $.ajax({
          type: "GET",
          url: "/get-data",
          success: function (response) {
            // Update metric cards with animation
            const tempElement = document.getElementById("temperature");
            const humidityElement = document.getElementById("humidity");
            
            animateValue(tempElement, response.temperature);
            animateValue(humidityElement, response.humidity);

            // Add data to charts (keep only last 20 data points)
            const now = new Date();
            const timeLabel = now.getHours().toString().padStart(2, '0') + ':' + 
                            now.getMinutes().toString().padStart(2, '0') + ':' +
                            now.getSeconds().toString().padStart(2, '0');
            
            tempData.push(response.temperature);
            humidityData.push(response.humidity);
            timeLabels.push(timeLabel);

            if (tempData.length > 20) {
              tempData.shift();
              humidityData.shift();
              timeLabels.shift();
            }

            // Update charts
            if (tempChart) {
              tempChart.data.labels = timeLabels;
              tempChart.data.datasets[0].data = tempData;
              tempChart.update('none');
            }
            if (humidityChart) {
              humidityChart.data.labels = timeLabels;
              humidityChart.data.datasets[0].data = humidityData;
              humidityChart.update('none');
            }

            // Show notification if there's a message
            if (response.message) {
              showNotification(response.message);
            }
          },
          error: function () {
            console.log("Error fetching data");
          }
        });
      }

      // Animate number change
      function animateValue(element, newValue) {
        const currentValue = parseFloat(element.textContent) || 0;
        const difference = newValue - currentValue;
        const steps = 10;
        const stepValue = difference / steps;
        let currentStep = 0;

        const interval = setInterval(() => {
          currentStep++;
          const animatedValue = (currentValue + stepValue * currentStep).toFixed(1);
          element.textContent = animatedValue;

          if (currentStep >= steps) {
            element.textContent = newValue.toFixed(1);
            clearInterval(interval);
          }
        }, 30);
      }

      // Modal functions
      function openModal() {
        const modalOverlay = document.getElementById("modalOverlay");
        modalOverlay.classList.add("active");
      }

      function closeModal() {
        const modalOverlay = document.getElementById("modalOverlay");
        modalOverlay.classList.remove("active");
      }

      function confirmModal() {
        // Add your confirmation logic here
        closeModal();
      }

      function showSuccessModal() {
        const container = document.getElementById('notificationContainer');
        const notification = document.createElement('div');
        notification.className = 'notification';
        notification.innerHTML = `
          <i class="fas fa-check-circle"></i>
          <div class="notification-content">
            <div class="notification-title">Success!</div>
            <div class="notification-message">Settings saved successfully!</div>
          </div>
          <button class="notification-close" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
          </button>
        `;
        container.appendChild(notification);

        // Auto remove after 5 seconds
        setTimeout(() => {
          if (notification.parentElement) {
            notification.remove();
          }
        }, 5000);
      }

      function closeSuccessModal() {
        // No longer needed as notification auto-dismisses
      }

      // Notification functions
      function showNotification(message) {
        const notificationContainer = document.getElementById('notificationContainer');
        const notification = document.createElement('div');
        notification.classList.add('notification');

        const icon = document.createElement('i');
        icon.classList.add('fas', 'fa-info-circle');

        const content = document.createElement('div');
        content.classList.add('notification-content');

        const title = document.createElement('div');
        title.classList.add('notification-title');
        title.textContent = 'Notification';

        const msg = document.createElement('div');
        msg.classList.add('notification-message');
        msg.textContent = message;

        const closeBtn = document.createElement('button');
        closeBtn.classList.add('notification-close');
        closeBtn.innerHTML = '&times;';
        closeBtn.onclick = function() {
          notificationContainer.removeChild(notification);
        };

        content.appendChild(title);
        content.appendChild(msg);
        notification.appendChild(icon);
        notification.appendChild(content);
        notification.appendChild(closeBtn);
        notificationContainer.appendChild(notification);
      }

      $(document).ready(function () {
        // Initialize charts
        initCharts();

        // Get data immediately
        getData();

        // Get data every 2 seconds
        setInterval(getData, 2000);

        // Handle form submission to show success modal
        $('form').on('submit', function(e) {
          // Let the form submit normally
          // Modal will show based on session success
        });

        @if(session('success'))
          showSuccessModal();
        @endif
      });
    </script>
  </body>
</html>
