<!DOCTYPE html>
<html lang="en">

<head>
    @include('super.css')
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Centered Title Section */
        .text-center {
            text-align: center;
        }

        .section-title {
            background-color: white;
            color: #007bff;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
        }

        /* Form Container */
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0;
        }

        .col-lg-6,
        .col-md-8,
        .col-sm-10 {
            padding: 0.5rem;
        }

        /* Form Floating Labels */
        .form-floating {
            position: relative;
            margin-bottom: 1rem;
        }

        .form-floating label {
            position: absolute;
            top: 0;
            left: 0;
            padding: 0.75rem;
            font-size: 0.875rem;
            color: #6c757d;
            transition: 0.2s ease-in-out;
        }

        .form-control {
            padding: 1rem;
            border-radius: 0.25rem;
            border: 1px solid #ced4da;
        }

        .form-floating .form-control:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .form-floating .form-control:not(:placeholder-shown) {
            padding-top: calc(1.5rem + 0.75rem);
            padding-bottom: calc(0.75rem + 0.75rem);
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
        .form-control {
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

        .form-control:focus {
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
        }

        .btn-primary:hover {
            background-color: #000;
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
        }
    </style>
</head>

<body>
    @include('super.navbar')

    @include('super.sidebar')

    <!-- Form Start -->
    <div class="container-fluid px-4 py-5">
        <div class="row">
            <!-- Account Settings Form -->
            <div class="col-lg-8 order-lg-1">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Entry Tamu</h6>
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

                        <form id="guestForm" action="/submit-form" method="post" onsubmit="return validateForm()">
                            @csrf

                            <h6 class="heading-small text-muted mb-4">Masukkan Data Tamu</h6>

                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="nama">Nama<span class="small text-danger">*</span></label>
                                            <input type="text" id="nama" class="form-control" name="nama" placeholder="Nama" value="{{ old('nama') }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="alamat">Alamat<span class="small text-danger">*</span></label>
                                            <input type="text" id="alamat" class="form-control" name="alamat" placeholder="Jl. Indonesia Raya" value="{{ old('alamat') }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="dinas">Asal Dinas<span class> (Opsional)</span></label>
                                            <input type="text" id="dinas" class="form-control" name="dinas" placeholder="Dinas Komunikasi" value="{{ old('dinas') }}">
                                        </div>
                                    </div>

<div class="col-lg-6">
    <div class="form-group">
        <label class="form-control-label" for="opd_address">Tujuan Dinas<span class="small text-danger">*</span></label>
        <input type="text" id="opd_address" class="form-control" name="opd_address" 
               value="{{ $authUser->opd_id ? $opd->find($authUser->opd_id)->dinas : '' }}" 
               readonly required>
          </div>
    <input type="hidden" name="opd_id" value="{{ $authUser->opd_id }}">
</div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-control-label" for="keperluan">Keperluan<span class="small text-danger">*</span></label>
                                            <input type="text" id="keperluan" class="form-control" name="keperluan" placeholder="Acara apa yang sedang berlangsung" value="{{ old('keperluan') }}">
                                        </div>
                                    </div>

                                    <div class="col-6 webcam-section">
                                        <video id="video" autoplay></video>
                                        <button type="button" id="capture" class="btn btn-secondary mt-3">Capture Photo</button>
                                        <button type="button" id="refresh" class="btn btn-secondary mt-3">Refresh Photo</button>
                                        <canvas id="canvas" style="display: none;"></canvas>
                                        <img id="snapshot" src="" alt="Snapshot" class="mt-3" />
                                        <div id="error-message" class="mt-3"></div>
                                    </div>
                                    <input type="hidden" id="webcamImage" name="webcamImage" required>
                                    <div class="col-12">
                                        <button class="btn btn-primary w-100 py-3" type="submit">Send Message</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Form End -->

                @include('super.footer')

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const video = document.getElementById('video');
                        const canvas = document.getElementById('canvas');
                        const context = canvas.getContext('2d');
                        const snapshot = document.getElementById('snapshot');
                        const webcamImage = document.getElementById('webcamImage');
                        const errorMessage = document.getElementById('error-message');
                        const captureButton = document.getElementById('capture');
                        const refreshButton = document.getElementById('refresh');

                        // Function to start webcam
                        function startWebcam() {
                            navigator.mediaDevices.getUserMedia({ video: true })
                                .then(function (stream) {
                                    video.srcObject = stream;
                                    video.play();
                                })
                                .catch(function (error) {
                                    errorMessage.textContent = 'Error accessing webcam: ' + error.message;
                                    console.error('Error accessing webcam: ', error);
                                });
                        }

                        // Function to capture image from webcam
                        function captureImage() {
                            if (video.srcObject) {
                                // Set canvas dimensions to video dimensions
                                canvas.width = video.videoWidth;
                                canvas.height = video.videoHeight;

                                // Draw video frame to canvas
                                context.drawImage(video, 0, 0, canvas.width, canvas.height);

                                // Get image data from canvas
                                const imageData = canvas.toDataURL('image/png');
                                snapshot.src = imageData;
                                snapshot.style.display = 'block';

                                // Set hidden input value to image data URL
                                webcamImage.value = imageData;
                            } else {
                                errorMessage.textContent = 'No video stream available.';
                            }
                        }

                        // Function to refresh the webcam feed
                        function refreshPhoto() {
                            snapshot.src = ''; // Clear the current snapshot
                            snapshot.style.display = 'none'; // Hide the snapshot
                            webcamImage.value = ''; // Clear the hidden input
                        }

                        // Start the webcam when the page loads
                        startWebcam();

                        // Capture photo on button click
                        captureButton.addEventListener('click', captureImage);

                        // Refresh photo on button click
                        refreshButton.addEventListener('click', refreshPhoto);
                    });

                    // Validate the form to ensure webcam image has been captured
                    function validateForm() {
                        const webcamImage = document.getElementById('webcamImage').value;
                        if (!webcamImage) {
                            alert('Please capture a photo using the webcam.');
                            return false; // Prevent form submission
                        }
                        return true; // Allow form submission
                    }
                </script>
</body>

</html>
