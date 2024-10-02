<!DOCTYPE html>
<html lang="en">
<head>

@include('admin.header')
<style>
     .light-background {
    background-color: #f5fbff; 
        }
        </style>

</head>
<body>
    
@include('admin.navbar')
    
    <!-- Page Title -->
    <div class="page-title light-background">
      <div class="container">
        <h1>Contact Us</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="/">Home</a></li>
            <li class="current">Contact Us</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

<!-- Contact Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Contact Us</h6>
            <h1 class="display-5 mb-3" style="font-size: 1.2rem; color: gray;">Untuk Informasi Lebih Lanjut</h1>
        </div>

        <div class="row">
            
            <div class="col-lg-4">
                <div class="mb-4 wow fadeInUp" data-wow-delay="0.1s">
                    <h5 class="text-primary">Office</h5>
                    <p>Gedung OPD Bersama, Jl. Kartini No.1, Panggang I, Panggang, Kec. Jepara, Kabupaten Jepara, Jawa Tengah</p>
                </div>
                <div class="mb-4 wow fadeInUp" data-wow-delay="0.2s">
                    <h5 class="text-primary">Whatsapp</h5>
                    <p>08990167365</p>
                </div>
                <div class="wow fadeInUp" data-wow-delay="0.3s">
                    <h5 class="text-primary">Email</h5>
                    <p>info@example.com</p>
                </div>
            </div>

            <div class="col-lg-8 mb-4" data-aos="fade-up" data-aos-delay="100">
                <iframe style="border:0; width: 100%; height: 270px;" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3963.4447694390656!2d110.6651682!3d-6.5915097!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e711f0321765631%3A0x79188af8cb42f959!2sDinas%20Komunikasi%20dan%20Informatika%20(DISKOMINFO)%20Kabupaten%20Jepara!5e0!3m2!1sen!2sid!4v1724138452523!5m2!1sen!2sid" 
                frameborder="0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div><!-- End Google Maps -->

        </div>
    </div>
</div>
<!-- Contact End -->

    @include('admin.footer')
    

  
</body>

</html>