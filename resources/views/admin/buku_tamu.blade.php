<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.header')
    
    <style>
.btn-update {
            background-color: #3399ff;
            color: #ffffff;
            border-radius: 50px;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            text-align: center;
            display: inline-block;
            margin-top: 10px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .btn-read {
            background-color: #0066ff;
            color: #ffffff;
            border-radius: 50px;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            text-align: center;
            display: inline-block;
            text-decoration: none;
        }

        .btn-delete {
            background-color: #dc3545;
            color: #ffffff;
            border-radius: 50px;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            text-align: center;
            display: block;
            margin-top: 10px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }

        .btn-group {
            display: flex; /* Menggunakan flexbox untuk sejajar tombol */
            gap: 10px; /* Jarak antara tombol */
            align-items: center; /* Menyelaraskan tombol secara vertikal */
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

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="container-fluid service pb-5">
            <div class="container pb-5">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                    <h4 class="text-primary">Our Services</h4>
                    <h1 class="display-5 mb-4">We Services provided best offer</h1>
                    <p class="mb-0">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Tenetur adipisci facilis cupiditate recusandae aperiam temporibus corporis itaque quis facere, numquam, ad culpa deserunt sint dolorem autem obcaecati, ipsam mollitia hic.
                    </p>
                </div>
                <div class="row g-4">
                @foreach($tamu as $item)
                    <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="service-item">
                            <div class="service-img">
                                <img src="{{ asset('storage/' . $item->webcamImage) }}" class="img-fluid rounded-top w-100" alt="Image of {{ $item->nama }}">
                            </div>
                            <div class="rounded-bottom p-4">
                                
                                <p class="mb-4">
                                    <strong>Keperluan:</strong> {{ $item->keperluan }}
                                </p>
                                <td>
                                <a href="{{ route('tamu_show', $item->id) }}" class="btn btn-read">Read More</a><td>
                                <div class="d-flex gap-2">
                                <form action="" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete">Delete</button>
                                </form>
                                <a href="" class="btn btn-update">Update</a>
                           </div>
                         </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    </div>

    @include('admin.footer')
</body>
</html>


