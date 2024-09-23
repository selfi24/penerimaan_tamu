<!DOCTYPE html>
<html lang="en">

<head>
    @include('superadmin.css')
    <style>
        /* Card Styling */
        .card {
            border-radius: 0;
            box-shadow: 0px 4px 8px 0px #757575;
            margin-bottom: 1rem;
        }

        /* Ensure Card Body Takes Full Height */
        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* Form Styles */
        select.form-control {
            padding: 8px 10px;
            border: 1px solid lightgrey;
            border-radius: 2px;
            margin-bottom: 15px;
            width: 100%;
            box-sizing: border-box;
            color: #2C3E50;
            font-size: 14px;
            letter-spacing: 1px;
        }

        select.form-control:focus {
            box-shadow: none;
            border-color: #304FFE;
            outline-width: 0;
        }

        /* Button Styles */
        .btn-primary {
            background-color: #3399ff;
            color: #fff;
            border-radius: 2px;
            width: 150px;
            margin-right: 10px; /* Space between buttons */
        }

        .btn-primary:hover {
            background-color: #000;
            cursor: pointer;
        }

        .btn-danger {
            background-color: #dc3545;
            color: #fff;
            border-radius: 2px;
            width: 150px;
        }

        .btn-danger:hover {
            background-color: #c82333;
            cursor: pointer;
        }

        /* Alerts */
        .alert {
            border-radius: 0;
            margin-bottom: 1rem;
        }

        .alert-success {
            border-left: 4px solid #28a745;
        }

        .alert-danger {
            border-left: 4px solid #dc3545;
        }

        /* Card Profile Stats */
        .card-profile-stats {
            text-align: center;
        }

        .card-profile-stats .heading {
            display: block;
            font-size: 1.25rem;
            font-weight: bold;
        }

        .card-profile-stats .description {
            display: block;
            font-size: 0.875rem;
            color: #6c757d;
        }

        /* Webcam Section */
        .webcam-section {
            text-align: center;
        }

        #video {
            border: 1px solid black;
            width: 100%;
            height: auto;
        }

        #snapshot {
            width: 100%;
            height: auto;
            display: none; /* Hide snapshot by default */
        }

        #error-message {
            color: red;
        }

        /* Footer */
        .bg-blue {
            color: #fff;
            background-color: #3399ff;
        }

        .bg-blue .container {
            text-align: center;
            padding: 1rem 0;
        }

        .bg-blue .container small {
            margin: 0;
        }

        /* Responsive Design */
        @media screen and (max-width: 991px) {
            .card-profile-stats {
                margin-top: 1rem;
            }

            select.form-control {
                font-size: 13px; /* Adjust font size on small screens */
            }
        }

        /* Button Container Styling */
        .button-container {
            display: flex;
            justify-content: center;
            gap: 10px; /* Space between buttons */
        }

        /* Existing Image Styling */
        .existing-image img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>

<body>
    @include('superadmin.navbar')
    @include('superadmin.sidebar')

    <div class="container-fluid px-4 py-5">
        <div class="row">
            <!-- Account Settings Form -->
            <div class="col-lg-8 order-lg-1">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Edit Tamu</h6>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger border-left-danger" role="alert">
                                <ul class="pl-4 my-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('update_tamu', $tamu->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <fieldset>
                                <div class="pl-lg-4">
                                    <div class="form-group">
                                        <label for="nama">Name</label>
                                        <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', $tamu->nama) }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="opd_id">Asal Dinas</label>
                                        <select id="opd_id" name="opd_id" class="form-control">
                                            <option value="" disabled>Select Dinas</option>
                                            @foreach($opd as $item)
                                                <option value="{{ $item->id }}" {{ old('opd_id', $tamu->opd_id) == $item->id ? 'selected' : '' }}>
                                                    {{ $item->dinas }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="alamat">Alamat</label>
                                        <input type="text" name="alamat" id="alamat" class="form-control" value="{{ old('alamat', $tamu->alamat) }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="keperluan">Keperluan</label>
                                        <textarea name="keperluan" id="keperluan" class="form-control" rows="4" required>{{ old('keperluan', $tamu->keperluan) }}</textarea>
                                    </div>

                                    <div class="form-group existing-image">
                                        <h5>Existing Image</h5>
                                        <img src="{{ asset('storage/' . $tamu->webcamImage) }}" alt="Existing Image" id="existingImage">
                                    </div>

                                    <!-- File Input for Webcam Image -->
                                    <div class="form-group">
                                        <label for="webcamImage">Upload New Image</label>
                                        <input type="file" name="webcamImage" id="webcamImage" class="form-control">
                                    </div>

                                    <!-- Button Container -->
                                    <div class="pl-lg-4">
                                        <div class="row">
                                            <div class="col text-center button-container">
                                                <button type="submit" class="btn btn-primary">Edit Tamu</button>
                                                <a href="{{ route('buka_tamu') }}" class="btn btn-danger">Close</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('superadmin.footer')   
      
</body>

</html>
