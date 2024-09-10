<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.header')
   <style>
    .btn-back {
            background-color: #3399ff;
            color: #ffffff;
            border-radius: 50px;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            text-align: center;
            display: block;
            text-decoration: none;
        }
        </style>
</head>
<body>
    @include('admin.navbar')

    <!-- Header Start -->
    <div class="container-fluid bg-primary py-5 mb-5 page-header">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white animated slideInDown">Courses</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                            <li class="breadcrumb-item"><a class="text-white" href="#">Pages</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Courses</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
        <h6 class="section-title bg-white text-center text-primary px-3">ENTRY TAMU</h6>
        <h1 class="mb-5">Data Penerimaan Tamu</h1>
    </div>

    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s" style="min-height: 400px;">
            <div class="position-relative h-100">
            <img class="img-fluid position-absolute w-100 h-100" src="{{ asset('storage/' . $tamu->webcamImage) }}" alt="Snapshot" style="object-fit: cover;">
            </div>
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                    <h6 class="section-title bg-white text-start text-primary pe-3">Entry Tamu</h6>
                    <p class="mb-4"><strong>Nama:</strong> {{ $tamu->nama }}</p>
                    <p class="mb-4"><strong>Alamat:</strong> {{ $tamu->alamat }}</p>
                    <p class="mb-4"><strong>Asal Dinas:</strong> {{ $tamu->asal }}</p>
                    <p class="mb-4"><strong>Keperluan:</strong> {{ $tamu->keperluan }}</p>
                    
                    <a href="{{ route('buku_tamu') }}" class="btn btn-back">Back</a>
                  

                </div>
            </div>
        </div>
    </div>

    @include('admin.footer')
</body>
</html>




      
               
