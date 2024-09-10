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

        .col-lg-6, .col-md-8, .col-sm-10 {
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

        .btn {
            display: inline-block;
            padding: 0.5rem 1rem;
            font-size: 1rem;
            border: none;
            border-radius: 0.25rem;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            transition: background-color 0.2s ease;
        }

        .btn-secondary {
            background-color: #6c757d;
        }

        .btn-primary {
            background-color: #007bff;
        }

        .btn:hover {
            opacity: 0.9;
        }

        /* Form Submit Button */
        .btn-primary.w-100 {
            width: 100%;
            padding: 0.75rem;
            font-size: 1.25rem;
        }
        /* Custom Styles for the Heading */
    .card-title {
        font-size: 1.5rem; /* 3% of viewport width */
    font-weight: bold;
    color: #007bff;
    text-align: center;
    margin-bottom: 1rem;
    }
    
    </style>
</head>
<body>
@include('super.navbar')

@include('super.sidebar')

<!-- Form Start -->


    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-10">
        <h4 class="card-title text-primary">INPUT DATA TAMU</h4>
        <div class="div_center">
            @if(session()->has('message'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    {{ session()->get('message') }}
                </div>
            @endif
        </div>
            <form id="guestForm" action="/submit-form" method="post" onsubmit="return validateForm()">
                @csrf
                <div class="row g-3">
                    <div class="col-12">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="nama" name="nama"  required>
                            <label for="nama">Nama</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="alamat" name="alamat" required>
                            <label for="alamat">Alamat</label>
                        </div>
                    </div>
                <div class="col-12">
                <div class="form-floating">
                <label for="opd">Asal Dinas</label>
                <select class="form-control" name="opd" id="edit-opd" required>
                    <option value="" disabled selected>Pilih Dinas</option>
                    @foreach($opd as $opd)
                        <option value="{{ $opd->dinas }}">
                            {{ $opd->dinas }}
                        </option>
                    @endforeach
                    </select>
                     </div>
                </div>
                    <div class="col-12">
                        <div class="form-floating">
                            <textarea class="form-control" id="keperluan" name="keperluan" style="height: 150px" required></textarea>
                            <label for="keperluan">Keperluan</label>
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