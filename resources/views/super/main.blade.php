<script>
    // Date formatting function
    function formatDate(date) {
        const options = { day: '2-digit', month: 'short', year: 'numeric' };
        return date.toLocaleDateString('en-US', options);
    }

    // Function to update date on button
    function updateDate() {
        const now = new Date();
        const formattedDate = formatDate(now);
        const dateElement = document.getElementById('currentDate');
        dateElement.textContent = `Today (${formattedDate})`;
    }

    // Run updateDate when the page loads
    document.addEventListener('DOMContentLoaded', updateDate);
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Selamat Datang <span style="color: #700c96;">{{ Auth::user()->name }}</span> di Website Penerimaan Tamu</h3>
                    </div>
                    <div class="col-12 col-xl-4">
                        <div class="justify-content-end d-flex">
                            <div class="btn btn-sm btn-light bg-white" id="currentDateButton">
                                <i class="mdi mdi-calendar"></i> <span id="currentDate">Today</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin transparent">
                <div class="row">
                    <div class="col-md-12 mb-4 stretch-card transparent">
                        <div class="card card-light-blue">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <p class="mb-0">Total Entry Tamu</p>
                                <i class="fas fa-chart-pie fa-3x text-white"></i>
                            </div>
                            <p class="fs-30 mb-4" style="margin-left: 30px;">{{ $tamu }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Data tamu per bulan pada {{ $selectedOpd }}</h4>
                        <label for="yearSelect">Pilih Tahun:</label>
                        <select id="yearSelect" onchange="updateChart()">
                            @foreach ($years as $yearOption)
                                <option value="{{ $yearOption }}" {{ $yearOption == $year ? 'selected' : '' }}>{{ $yearOption }}</option>
                            @endforeach
                        </select>

                        <canvas id="guestChart" width="350" height="150"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let totals = @json($totals);
    let months = @json($months);

    function updateChart() {
    const selectedYear = document.getElementById('yearSelect').value;

    // Fetch new data based on the selected year
    fetch(`/api/guest-data?year=${selectedYear}`)
        .then(response => response.json())
        .then(data => {
            // Update totals and months from response
            totals = data.totals;
            months = data.months;

            // Redraw the chart with new data
            drawChart();
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
}


function drawChart() {
    const ctx = document.getElementById('guestChart').getContext('2d');
    ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height); // Hapus grafik sebelumnya

    const guestChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: months,
            datasets: [{
                label: 'Jumlah tamu',
                data: totals,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah tamu'
                    }
                },
                x: {
                    title: {
                        display: true,
                        
                    }
                }
            }
        }
    });
}

    // Initialize the chart
    drawChart();
</script>

