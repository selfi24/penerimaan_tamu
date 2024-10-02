<script>
    // Fungsi untuk format tanggal dalam format 'dd MMM yyyy'
    function formatDate(date) {
        const options = { day: '2-digit', month: 'short', year: 'numeric' };
        return date.toLocaleDateString('en-US', options);
    }

    // Fungsi untuk mengupdate teks tanggal di button
    function updateDate() {
        const now = new Date();
        const formattedDate = formatDate(now);
        const dateElement = document.getElementById('currentDate');
        dateElement.textContent = `Today (${formattedDate})`;
    }

    // Jalankan updateDate saat halaman dimuat
    document.addEventListener('DOMContentLoaded', updateDate);
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <h3 class="font-weight-bold">Selamat Datang {{ Auth::user()->name }} di Website Penerimaan Tamu</h3>
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
                <div class="col-md-6 mb-4 stretch-card transparent">
                  <div class="card card-tale">
                    <div class="card-body">
                      <p class="mb-4">Total Pengguna</p>
                      <p class="fs-30 mb-2">{{$users}}</p>
                    </div>
                  </div>
                </div>
                
                <div class="col-md-6 mb-4 stretch-card transparent">
                  <div class="card card-dark-blue">
                    <div class="card-body">
                      <p class="mb-4">Total Admin</p>
                      <p class="fs-30 mb-2">{{$admin}}</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 mb-4 stretch-card transparent">
                  <div class="card card-light-blue">
                    <div class="card-body">
                      <p class="mb-4">Total OPD</p>
                      <p class="fs-30 mb-2">{{$opd}}</p>
                    </div>
                  </div>
                </div>
                
                <div class="col-md-6 mb-4 stretch-card transparent">
                  <div class="card card-dark-blue">
                    <div class="card-body">
                      <p class="mb-4">Total Data Tamu</p>
                      <p class="fs-30 mb-2">{{$tamu}}</p>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card tale-bg">
                <div class="card-people mt-auto">
                  <img src="images/dashboard/people.svg" alt="people">
                  <div class="weather-info">
                    <div class="d-flex">
                      <div>
                        <h2 class="mb-0 font-weight-normal"><i class="icon-sun mr-2"></i>31<sup>C</sup></h2>
                      </div>
                      <div class="ml-2">
                        <h4 class="location font-weight-normal">Bangalore</h4>
                        <h6 class="font-weight-normal">India</h6>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 grid-margin transparent">
              <div class="row">
                <div class="col-md-6 mb-4 stretch-card transparent">
                  <div class="card card-tale">
                    <div class="card-body">
                      <p class="mb-4">Today’s Bookings</p>
                      <p class="fs-30 mb-2">4006</p>
                      <p>10.00% (30 days)</p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 mb-4 stretch-card transparent">
                  <div class="card card-dark-blue">
                    <div class="card-body">
                      <p class="mb-4">Total Bookings</p>
                      <p class="fs-30 mb-2">61344</p>
                      <p>22.00% (30 days)</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                  <div class="card card-light-blue">
                    <div class="card-body">
                      <p class="mb-4">Number of Meetings</p>
                      <p class="fs-30 mb-2">34040</p>
                      <p>2.00% (30 days)</p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 stretch-card transparent">
                  <div class="card card-light-danger">
                    <div class="card-body">
                      <p class="mb-4">Number of Clients</p>
                      <p class="fs-30 mb-2">47033</p>
                      <p>0.22% (30 days)</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <p class="card-title">Asal Dinas Report</p>
                    <a href="#" class="text-info">View all</a>
                </div>
                <p class="font-weight-500">This chart shows the total entries by each Asal Dinas.</p>
                <canvas id="dinas-chart" style="max-width: 600px; height: 400px;"></canvas>
            </div>
        </div>
    </div>
</div>


          <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Diagram Total Tamu</h4>
                <canvas id="userAreaPieChart" style="max-width: 600px; height: 400px;"></canvas>
            </div>
        </div>
    </div>
</div>
        
</div>
            </div>
        </div>
        <!-- content-wrapper ends -->
                
              </div>
            </div>
        </div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const labels = @json($labels);
        const data = @json($counts);

        var ctxAreaPie = document.getElementById('userAreaPieChart').getContext('2d');
        new Chart(ctxAreaPie, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Diagram Total Tamu',
                    data: data,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(153, 102, 255, 0.6)',
                        'rgba(255, 159, 64, 0.6)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                aspectRatio: 1.5 // Adjust as needed
            }
        });
    });
</script>

              
        <script>
    document.addEventListener('DOMContentLoaded', function () {
        const labels = @json($labels);
        const counts = @json($counts);
        const chartColors = @json($chartColors);

        console.log(counts); // Check the data values

        const ctx = document.getElementById('dinas-chart').getContext('2d');
        const dinasChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Count of Tamu Entries by Dinas',
                    data: counts,
                    backgroundColor: chartColors,
                    borderColor: chartColors.map(color => color.replace('0.6', '1')),
                    borderWidth: 1,
                    barPercentage: 0.5 // Move barPercentage here
                }]
            },
            options: {
                scales: {
                    y: {
                      min: 0,
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Count'
                        },
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Dinas'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    }
                }
            }
        });
    });
</script>