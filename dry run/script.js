// Example: Create a simple bar chart using Chart.js
const ctx = document.getElementById('analytics-chart').getContext('2d');
const chart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
    datasets: [{
      label: 'Deliveries',
      data: [200, 400, 300, 500, 450],
      backgroundColor: '#ff8c42',
    }]
  },
  options: {
    responsive: true,
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
});
