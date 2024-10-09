<!DOCTYPE html>
<html lang="en">

<head>
@include('admin.header')
<style>
    /* General Styles */
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        min-height: 100vh; /* Ensure body takes full height */
    }
    

    .content {
    flex: 1; /* Allow content area to grow */
    display: flex; /* Use flexbox */
    justify-content: center; /* Center horizontally */
    align-items: center; /* Center vertically */
    padding: 40px; /* Increase padding */

}

.card {
    max-width: 1200px; /* Increase max-width for more space */
    width: 100%; /* Allow it to be responsive */
}


    /* Title and Section Styles */
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

    /* Button Styles */
    .btnn {
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

    .btnn-primary {
        background-color: #06BBCC;
    }

    .btn:hover {
        opacity: 0.9;
    }

    .btn.w-100 {
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
@include('admin.navbar')
      
<div class="container-fluid px-4 py-5 content">
    <div class="row">
        <!-- Account Settings Form -->
        <div class="col-lg-8 order-lg-1">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Add Account</h6>
                </div>
                <div class="card-body">
                @if (session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
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

                    <form id="guestForm" action="/submit-form1" method="post" onsubmit="return validateForm()">
                        @csrf
                        <div class="row g-3">
                          
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
                                            <input type="text" id="dinas" class="form-control" name="dinas" placeholder="Dinas Komunikasi" value="{{ old('alamat') }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                    <div class="form-group">
        <label class="form-control-label" for="opd_id">Tujuan Dinas<span class="small text-danger">*</span></label>
        <select class="form-control" name="opd_id" id="edit-opd" placeholder="Pilih Dinas">
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
                                <button class="btnn btnn-primary w-100 py-3" type="submit">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

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
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                context.drawImage(video, 0, 0, canvas.width, canvas.height);
                const imageData = canvas.toDataURL('image/png');
                snapshot.src = imageData;
                snapshot.style.display = 'block';
                webcamImage.value = imageData;
            } else {
                errorMessage.textContent = 'No video stream available.';
            }
        }

        // Function to refresh the webcam feed
        function refreshPhoto() {
            snapshot.src = '';
            snapshot.style.display = 'none';
            webcamImage.value = '';
        }

        startWebcam();
        captureButton.addEventListener('click', captureImage);
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
