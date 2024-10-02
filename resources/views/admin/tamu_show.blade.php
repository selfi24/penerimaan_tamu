<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.header')
   
</head>
<body>
    @include('admin.navbar')

    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s" style="min-height: 400px;">
            <div class="position-relative h-100">
            <img class="img-fluid position-absolute w-100 h-100" src="{{ asset('storage/' . $tamu->webcamImage) }}" alt="Snapshot" style="object-fit: cover;">
            </div>
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                    <h6 class="section-title bg-white text-start text-primary pe-3">{{ $tamu->created_at->format('Y-m-d') }}</h6>
                   <p class="mb-4">{{ $tamu->keperluan }}</p>
                    
                    
                </div>
            </div>
        </div>
    </div>

    @include('admin.footer')
</body>
</html>




      
               
