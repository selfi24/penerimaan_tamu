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
        /* Add custom styles here if needed */
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
                        <h6 class="m-0 font-weight-bold text-primary">Add Account</h6>
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

            <form id="guestForm" action="/submit_form" method="post" onsubmit="return validateForm()">
                @csrf
                <div class="row g-3">
                    <div class="col-12">
                        <div class="form-group">
                        <label for="nama">Nama<span class="small text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama" name="nama"  required>       
                        </div>
                    </div>
                         <div class="col-12">
                        <div class="form-group">
                        <label for="alamat">Alamat<span class="small text-danger">*</span></label>
                            <input type="text" class="form-control" id="alamat" name="alamat" required> 
                        </div>
                    </div>
                    <div class="col-12">
    <div class="form-group">
        <label class="form-control-label" for="opd_id">Tujuan Dinas<span class="small text-danger">*</span></label>
        <select class="form-control" name="opd_id" id="edit-opd" placeholder="Pilih Dinas" required>
            <option value="" disabled selected>Pilih Dinas</option>
            @foreach($opd as $opd)
                <option value="{{ $opd->id }}">
                    {{ $opd->dinas }}
                </option>
            @endforeach
        </select>
    </div>
</div>

                    <div class="col-12">
                        <div class="form-group">
                        <label for="keperluan">Keperluan<span class="small text-danger">*</span></label>
                            <textarea class="form-control" id="keperluan" name="keperluan" style="height: 150px" required></textarea>
                            
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
    
    <!-- Form End -->
    
@include('superadmin.footer')    

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