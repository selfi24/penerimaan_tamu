<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.header')
    <style>
        .rounded-card {
            border-radius: 25px; /* Rounded corners */
            overflow: hidden; /* Ensure content respects the rounded corners */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Optional shadow */
        }
        .card-img {
            height: 200px; /* Fixed height for images */
            width: 100%; 
            object-fit: cover; /* Cover the entire area */
        }
        .text-date {
            color: #00b7eb; /* Blue color for the date */
            margin-bottom: 5px; /* Space below the date */
        }
        .text-description {
            color: gray; /* Gray color for description */
        }
        .service-header {
            max-width: 800px; /* Limit the width */
            margin: auto; /* Center the header */
            margin-top: 50px; /* Increased space above the header */
        }
        .pagination {
    display: flex;
    justify-content: center;
        }

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
        <h1>Galeri Tamu</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="/">Home</a></li>
            <li class="current">Galeri Tamu</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Service Start -->
    <div class="content d-flex flex-column flex-column-fluid">
        <div class="container-fluid service pb-5">
            <div class="container pb-5">
                <div class="text-center service-header wow fadeInUp" data-wow-delay="0.2s">
                <h6 class="section-title bg-white text-center text-primary px-3">Galeri Tamu</h6>
                    <h1 class="display-5 mb-3" style="font-size: 1.2rem; color: gray;">Daftar Tamu yang datang berkunjung</h1>
                </div>

                <div class="row">
                    @foreach($tamu as $item)
                        <div class="col-lg-4 col-sm-6 my-3">
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
                <div class="pagination">
    <ul class="pagination">
        @if ($tamu->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link">Previous</span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $tamu->previousPageUrl() }}">Previous</a>
            </li>
        @endif

        @foreach ($tamu->getUrlRange(1, $tamu->lastPage()) as $number => $url)
            @if ($number == $tamu->currentPage())
                <li class="page-item active">
                    <span class="page-link">{{ $number }}</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $url }}">{{ $number }}</a>
                </li>
            @endif
        @endforeach

        @if ($tamu->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $tamu->nextPageUrl() }}">Next</a>
            </li>
        @else
            <li class="page-item disabled">
                <span class="page-link">Next</span>
            </li>
        @endif
    </ul>
            </div>
        </div>
    </div>
    <!-- Service End -->
    

    
    @include('admin.footer')
</body>
</html>
