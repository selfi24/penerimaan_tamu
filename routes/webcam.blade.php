<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webcam Capture</title>
    <style>
        #video {
            width: 100%;
            height: auto;
            border: 1px solid black;
        }
        #canvas {
            display: none;
        }
        #snapshot {
            width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <h1>Webcam Capture</h1>
    <video id="video" autoplay></video>
    <button id="capture">Capture</button>
    <canvas id="canvas"></canvas>
    <img id="snapshot" src="" alt="Snapshot" />

    <script>
        // Access the webcam
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(function(stream) {
                document.getElementById('video').srcObject = stream;
            })
            .catch(function(error) {
                console.error('Error accessing webcam: ', error);
            });

        document.getElementById('capture').addEventListener('click', function() {
            let video = document.getElementById('video');
            let canvas = document.getElementById('canvas');
            let context = canvas.getContext('2d');
            let snapshot = document.getElementById('snapshot');

            // Set canvas dimensions to video dimensions
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;

            // Draw video frame to canvas
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            // Get image data from canvas and set it to the image element
            snapshot.src = canvas.toDataURL('image/png');

            // Send image data to the server
            fetch('/upload', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ image: canvas.toDataURL('image/png') })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Success:', data);
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</body>
</html>
