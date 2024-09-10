<!DOCTYPE html>
<html lang="en">
<head>
@include('admin.header')
    
</head>
<body>
    @include('admin.navbar')

    <!-- Header Start -->
    <div class="container-fluid bg-primary py-5 mb-5 page-header">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white animated slideInDown">Edit Guest Book</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                            <li class="breadcrumb-item"><a class="text-white" href="#">Pages</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Edit Tamu</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <!-- Update Form Start -->
    <div class="container">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h4>Entry Tamu</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('tamu_update', $tamu->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" id="nama" name="nama" class="form-control" value="{{ old('nama', $tamu->nama) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" id="alamat" name="alamat" class="form-control" value="{{ old('alamat', $tamu->alamat) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="asal" class="form-label">Asal Dinas</label>
                        <input type="text" id="asal" name="asal" class="form-control" value="{{ old('asal', $tamu->asal) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="keperluan" class="form-label">Keperluan</label>
                        <textarea id="keperluan" name="keperluan" class="form-control" rows="3" required>{{ old('keperluan', $tamu->keperluan) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="webcamImage" class="form-label">Upload Image</label>
                        <input type="file" id="webcamImage" name="webcamImage" class="form-control">
                        @if($tamu->webcamImage)
                            <img src="{{ asset('storage/' . $tamu->webcamImage) }}" alt="Current Image" class="img-fluid mt-3" style="max-width: 200px;">
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('buku_tamu') }}" class="btn btn-secondary">Back</a>
                </form>
            </div>
        </div>
    </div>
    <!-- Update Form End -->

    
    @include('admin.footer')
    
</body>
</html>
