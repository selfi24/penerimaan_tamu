<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.header')
    <style>
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

    <!-- Form Start -->
    <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
        <h6 class="section-title bg-white text-center text-primary px-3">ENTRY TAMU</h6>
        <h1 class="mb-5">Masukkan Data Penerimaan Tamu</h1>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-10">
            <form id="guestForm" action="/submit" method="post" onsubmit="return validateForm()">
                @csrf
                <div class="row g-3">
                    <div class="col-12">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Your Name" required>
                            <label for="nama">Nama</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Your Adress" required>
                            <label for="alamat">Alamat Dinas</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="asal" name="asal" placeholder="Asal dinas" required>
                            <label for="asal">Asal Dinas</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="Leave a message here" id="keperluan" name="keperluan" style="height: 150px" required></textarea>
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
                    <input type="hidden" id="webcamImage" name="webcamImage">
                    <div class="col-12">
                        <button class="btn btn-primary w-100 py-3" type="submit">Send Message</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Form End -->

    @include('admin.footer')

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
