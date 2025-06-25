<a href="appointments.php" class="back-btn">← Back to Dashboard</a>

<h1>Appointment Insights</h1>

<div class="charts">
  <div class="chart-card">
    <h3 style="color:#6a1b9a;">Solved vs Pending</h3>
    <canvas id="solvedPendingChart"></canvas>
  </div>
  <div class="chart-card">
    <h3 style="color:#6a1b9a;">Monthly Appointments</h3>
    <canvas id="monthlyChart"></canvas>
  </div>
</div>

<!-- Style -->
<style>
  .back-btn {
    display: inline-block;
    margin-bottom: 20px;
    padding: 10px 20px;
    background-color: #6a1b9a;
    color: white;
    text-decoration: none;
    border-radius: 6px;
  }

  .back-btn:hover {
    background-color: #4a148c;
  }

  .charts {
    display: flex;
    flex-direction: column;
    gap: 30px;
    margin-top: 10px;
  }

  .chart-card {
    background: #fff;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 0 10px rgba(0,0,0,0.05);
    width: 500px; /* slightly bigger */
  }

  canvas {
    width: 100% !important;
    height: 250px !important;
  }

  h1 {
    color: #4a148c;
    margin-bottom: 20px;
  }
</style>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  new Chart(document.getElementById("solvedPendingChart"), {
    type: 'bar',
    data: {
      labels: ['Solved', 'Pending'],
      datasets: [{
        label: 'Appointments',
        data: [40, 15],
        backgroundColor: ['#53c4e0', '#e480c7']
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false
    }
  });

  new Chart(document.getElementById("monthlyChart"), {
    type: 'line',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
      datasets: [{
        label: 'Appointments',
        data: [5, 8, 10, 9, 14, 10],
        borderColor: '#8548aa',
        backgroundColor: 'rgba(133, 72, 170, 0.1)',
        tension: 0.4,
        fill: true
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false
    }
  });
</script>
