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
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card tale-bg">
                <div class="card-people mt-auto">
                  <img src="images/dashboard/people.svg" alt="people">
                  <div class="weather-info">
                    <div class="d-flex">
                     
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
                    <p class="mb-4">Total OPD</p>
                    <p class="fs-30 mb-2">{{$opd}}</p>
                      <p></p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 mb-4 stretch-card transparent">
                  <div class="card card-dark-blue">
                    <div class="card-body">
                    <p class="mb-4">Total Admin</p>
                    <p class="fs-30 mb-2">{{$admin}}
                      <p></p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 mb-4 mb-lg-0 stretch-card transparent">
                  <div class="card card-light-blue">
                    <div class="card-body">
                    <p class="mb-4">Total Data Tamu</p>
                    <p class="fs-30 mb-2">{{$tamu}}</p>
                      <p></p>
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
                    <p class="card-title">Chart Jumlah Tamu</p>
                    <a href="{{ route('buka_tamu') }}" class="text-info">View all</a>
                </div>
                <p class="font-weight-500">Menampilkan jumlah tamu yang masuk berdasarkan OPD.</p>
                <canvas id="dinas-chart" width="350" height="150"></canvas> <!-- Canvas untuk bar chart -->
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <p class="card-title">Diagram OPD</p>
                    <a href="{{ route('opd') }}" class="text-info">View all</a>
                </div>
                <p class="font-weight-500">Menampilkan OPD yang ada di Kabupaten Jepara</p>
                <canvas id="opdPieChart" width="350" height="150"></canvas>
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
        const labels = @json($labels); // Nama OPD (Dinas)
        const counts = @json($counts); // Jumlah tamu untuk setiap OPD
        const chartColors = @json($chartColors); // Warna tetap untuk setiap OPD

        const ctxDinas = document.getElementById('dinas-chart').getContext('2d');

        new Chart(ctxDinas, {
            type: 'bar', // Bar chart
            data: {
                labels: labels,
                datasets: [{
                    data: counts, // Jumlah tamu berdasarkan OPD
                    backgroundColor: chartColors, // Menggunakan warna yang telah ditetapkan
                    borderColor: chartColors, // Warna border sesuai dengan warna masing-masing
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top', // Menampilkan legend di atas chart
                    },
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Dinas' // Label sumbu X
                        }
                    },
                    y: {
                        min: 0, // Menetapkan minimum pada sumbu Y (mulai dari 0)
                        beginAtZero: true, // Mulai dari angka 0
                        title: {
                            display: true,
                            text: 'Jumlah Tamu' // Label sumbu Y
                        },
                        ticks: {
                            // Membulatkan angka dan menghindari desimal
                            stepSize: 1, // Menampilkan angka dalam kelipatan 1 (2, 3, 4, dst.)
                            callback: function(value) {
                                return value % 1 === 0 ? value : ''; // Menampilkan hanya angka bulat
                            }
                        }
                    }
                }
            }
        });
    });
</script>
              
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const opdLabels = @json($opdLabels);
    const opdCounts = @json($opdCounts);
    const opdColors = @json($opdColors);

    const ctxOpdPie = document.getElementById('opdPieChart').getContext('2d');
    new Chart(ctxOpdPie, {
        type: 'pie', // Change 'pie' to 'doughnut' if needed
        data: {
            labels: opdLabels,
            datasets: [{
                data: opdCounts,
                backgroundColor: opdColors,
                borderColor: '#ffffff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'right',
                },
            },
        },
    });
});
</script>