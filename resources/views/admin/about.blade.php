<style>
    .rounded-card {
            border-radius: 25px; /* Rounded corners */
            overflow: hidden; /* Ensure content respects the rounded corners */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Optional shadow */
        }
        </style>
<!-- Service Start -->
<div class="content d-flex flex-column flex-column-fluid">
    <!-- begin::SECTION 2 -->
    <div class="bg-custom-section mb-5" style="margin-top: 50px;">
    <div class="container py-10">
            <div class="row w-100"> 
                <div class="text-center service-header wow fadeInUp" data-wow-delay="0.2s">
<h6 class="section-title bg-white text-center text-primary px-3">Jadwal Tamu</h6>
        <h1 class="display-5 mb-3" style="font-size: 1.2rem; color: gray;">Jadwal Tamu yang datang berkunjung</h1>
</div>

                 <!-- Gallery Items -->
                 @foreach($tamu as $item)
                        <div class="col-lg-3 col-sm-6 my-3">
                            <div class="card rounded-card h-100">
                                <div class="card-body p-0">
                                    <div class="service-img">
                                        <img src="{{ asset('storage/' . $item->webcamImage) }}" class="img-fluid card-img" alt="{{ $item->keperluan }}">
                                    </div>
                                    <div class="text-gray-800 p-3">
                                        <small class="fw-bold fs-8 text-date">{{ $item->created_at->format('Y-m-d') }}</small>
                                        <div class="fs-6 lh-base mt-1 substrTitle2Line text-wrap text-description">
                                            {{ Str::words($item->keperluan, 25, '...') }}
                                        </div>
                                        <a href="{{ route('tamu_show', $item->id) }}">
                                            <span class="text-primary fs-8 mt-0 pt-0">selengkapnya..</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                
            </div>
        </div>
    </div>
    <!-- end::SECTION 2 -->
