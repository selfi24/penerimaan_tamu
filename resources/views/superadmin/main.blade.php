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

                
              </div>
            </div>
        </div>

         