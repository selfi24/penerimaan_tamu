<!DOCTYPE html>
<html lang="en">
<head>
    @include('super.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert@2"></script>

    <title>Guest List</title>
    
    <style>
  /* General Styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    color: #495057;
    margin: 0;
    padding: 0;
}

.container-fluid {
    padding: 20px;
    padding-top: 40px;
}

.card {
    border: 1px solid #ddd;
    border-radius: 0.5rem;
    background-color: #fff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.card-body {
    padding: 20px;
}

.card-title {
    font-size: 1.5rem;
    margin-bottom: 1rem;
    text-align: center;
}

/* Alerts */
.alert {
    padding: 10px 20px;
    border-radius: 0.25rem;
    margin-bottom: 1rem;
}

.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
}

.close {
    color: #aaa;
    float: right;
    font-size: 1.25rem;
    font-weight: bold;
    cursor: pointer;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
}

/* Table Styles */
.table {
    width: 100%;
    margin-bottom: 1rem;
    background-color: #fff;
    border-collapse: collapse;
}

.table th,
.table td {
    padding: 0.75rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
}

.table th {
    text-align: left;
    background-color: #f8f9fa;
}

.table img {
    border-radius: 50%;
    width: 50px;
    height: 50px;
}

/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
    transition: opacity 0.3s ease;
    opacity: 0;
}

.modal.show {
    display: block;
    opacity: 1;
}

.modal-content {
    background-color: #fefefe;
    margin: 10% auto;
    padding: 15px;
    border: 1px solid #888;
    width: 50%;
    max-width: 600px;
    max-height: 80vh;
    overflow-y: auto;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    word-wrap: break-word;
}

.modal-content img {
    width: 100%; /* Ensure the image fits the modal width */
    height: auto; /* Maintain aspect ratio */
}

.close {
    color: #aaa;
    float: right;
    font-size: 1.75rem;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

/* Styling for all form groups */
.form-group {
    margin-bottom: 1rem; /* Space between form groups */
}

.form-group label {
    display: block; /* Ensure label is a block element */
    margin-bottom: 0.5rem; /* Space between label and input */
    font-weight: bold;
}

/* Unified styling for input, select, and textarea */
.form-control,
select.form-control,
textarea.form-control {
    display: block;
    width: 100%; /* Full width */
    height: 2.5rem; /* Consistent height for inputs and selects */
    padding: 0.5rem; /* Padding inside the input */
    font-size: 1rem;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    box-sizing: border-box; /* Include padding and border in element's width and height */
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

/* Styling for select to match input */
select.form-control {
    height: auto; /* Ensure consistent height */
    padding-right: 2.5rem; /* Space for dropdown arrow */
    -webkit-appearance: none; /* Remove default styling in WebKit browsers */
    -moz-appearance: none; /* Remove default styling in Firefox */
    appearance: none; /* Remove default styling */
}

/* Styling for textarea */
textarea.form-control {
    min-height: 2.5rem; /* Minimum height */
    resize: vertical; /* Allow vertical resizing */
}

.form-control:focus {
    border-color: #80bdff;
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.25);
}

/* Optional: Add custom styling to remove browser default styling from select */
select.form-control {
    background-color: #fff;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
}

/* Styling for select to include custom dropdown arrow */
.select-container {
    position: relative;
    display: inline-block;
    width: 100%;
}

.select-container select {
    width: 100%;
    height: 2.5rem;
    padding: 0.5rem;
    padding-right: 2.5rem; /* Space for the arrow */
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    appearance: none; /* Remove default styling */
    background-color: #fff;
    font-size: 1rem;
    color: #495057;
}

/* Placeholder style */
.select-container select option:first-child {
    color:  rgba(0, 0, 0, 0.5);/* Make the placeholder text transparent */
    background-color: transparent;  /* Background color of the select */
}

.select-container::after {
    content: '\f078'; /* Unicode for FontAwesome down arrow */
    font-family: "Font Awesome 5 Free"; /* Use Font Awesome 5 Free */
    position: absolute;
    right: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    font-weight: 900; /* Make sure the arrow is bold */
    color: #495057; /* Color of the arrow */
    pointer-events: none; /* Do not allow clicking on the arrow */
}
/* Transparent placeholder */
.select-container option:first-child {
    color: rgba(0, 0, 0, 0.3); /* Light color for placeholder */
}
.btn {
    display: inline-block;
    font-weight: 400;
    color: #212529;
    text-align: center;
    vertical-align: middle;
    user-select: none;
    background-color: transparent;
    border: 1px solid transparent;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: 0.25rem;
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.btn-primary {
    color: #fff;
    background-color: #007bff;
    border-color: #007bff;
}

.btn-primary:hover {
    color: #fff;
    background-color: #0069d9;
    border-color: #0062cc;
}

.bg-teal-300 {
    background-color: #4fd1c5;
}

.cursor-pointer {
    cursor: pointer;
}

.rounded {
    border-radius: 0.25rem;
}

/* Responsive Table */
.table-responsive {
    overflow-x: auto;
}

/* Responsive Adjustment */
@media (max-width: 768px) {
    .container-fluid {
        padding-top: 60px; /* Adjust based on the height of your navbar on smaller screens */
    }
}
    </style>
</head>
<body>
    @include('super.navbar')
    @include('super.sidebar')

    <div class="container-fluid">
        <!-- Guest List Table Start -->
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">List Tamu</h4>
                        <p class="card-description">List of all guests with their details</p>         
                        <div class="div_center">
                        @if(session()->has('message'))
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                        {{ session()->get('message') }}
                        </div>
                        @endif
                    </div>

                    <div class="div_center">
                        @if(session()->has('success'))
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                        {{ session()->get('success') }}
                        </div>
                        @endif
                    </div> 

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Asal Dinas</th>
                                        <th>Alamat</th>
                                        <th>Keperluan</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if($tamu->isNotEmpty())
                                    @foreach($tamu as $item)
                                        <tr>
                                            <td>{{ $item->nama }}</td>
                                            <td>{{ $item->opd }}</td>
                                            <td>{{ $item->alamat }}</td>
                                            <td>
                                                <a class="bg-teal-300 cursor-pointer rounded p-1 mx-1 text-white" onclick="openModal({{ json_encode($item->keperluan) }})" aria-label="View details">
                                                    <i class="fas fa-eye" style="font-size: 24px; color: black;"></i>
                                                </a>
                                            
                                            <a class="bg-teal-300 cursor-pointer rounded p-1 mx-1 text-white" onclick="openPhotoModal('{{ asset('storage/' . $item->webcamImage) }}')" aria-label="View photo">
                                                    <i class="fas fa-camera" style="font-size: 24px; color: black;"></i>
                                                </a></td>
                                                <td>
    <a class="bg-teal-300 cursor-pointer rounded p-1 mx-1 text-white" aria-label="Edit" onclick="editGuest({{ json_encode($item) }})">
        <i class="fas fa-edit" style="font-size: 24px; color: blue;"></i>
    </a>
    <form action="{{ route('delete', $item->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="bg-teal-300 cursor-pointer rounded p-1 mx-1 text-red-500" aria-label="Delete" style="border: none; background: none;" onclick="confirmation(event)">
            <i class="fas fa-trash" style="font-size: 24px; color: red;"></i>
        </button>
    </form>
</td>

                                        </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                    <td colspan="6" class="text-center">Data tamu tidak ditemukan.</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <!-- Modal HTML -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <div id="modal-body">
                <!-- Content will be inserted here -->
            </div>
        </div>
    </div>
<!-- Edit Guest Modal HTML -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEditModal()">&times;</span>
        <div id="modal-body">
            <!-- Form content here -->
            <form id="editForm" action="" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="edit-id">
                <div class="form-group">
                    <label for="edit-nama">Nama</label>
                    <input type="text" name="nama" id="edit-nama" class="form-control" required>
                </div>
                <div class="form-group">
                <label for="edit-opd">Asal Dinas</label>
                <div class="select-container">
                <select class="form-control" name="opd" id="edit-opd" required aria-label="Floating label select example">
                    <option value="" disabled selected>Pilih Dinas</option>
                    @foreach($opd as $opd)
                        <option value="{{ $opd->dinas }}">
                            {{ $opd->dinas }}
                        </option>
                    @endforeach
                    </select>
                     </div>
                </div>
                <div class="form-group">
                    <label for="edit-alamat">Alamat</label>
                    <input type="text" name="alamat" id="edit-alamat" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="edit-keperluan">Keperluan</label>
                    <textarea name="keperluan" id="edit-keperluan" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="edit-photo">Foto</label>
                    <input type="file" name="photo" id="edit-photo" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Update Tamu</button>
            </form>
        </div>
    </div>
</div>


<!-- Details Modal HTML -->
<div id="detailsModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeDetailsModal()">&times;</span>
        <div id="details-modal-body">
            <!-- Content will be inserted here -->
        </div>
    </div>
</div>

<!-- Photo Modal HTML -->
<div id="photoModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closePhotoModal()">&times;</span>
            <div id="photo-modal-body">
                <!-- Photo will be inserted here -->
            </div>
        </div>
    </div>

<script>
// Function to open the edit modal with guest data
// Function to open the edit modal with guest data
function editGuest(guest) {
    document.getElementById('edit-id').value = guest.id;
    document.getElementById('edit-nama').value = guest.nama;
    document.getElementById('edit-opd').value = guest.opd;
    document.getElementById('edit-alamat').value = guest.alamat;
    document.getElementById('edit-keperluan').value = guest.keperluan;

    // Update the form action URL
    document.getElementById('editForm').action = `/tamu/${guest.id}`;

    const modal = document.getElementById('editModal');
    modal.classList.add('show');
}

// Function to close the edit modal
function closeEditModal() {
    document.getElementById('editModal').classList.remove('show');
}

// Function to open the details modal
function openModal(keperluan) {
    const modal = document.getElementById('detailsModal');
    document.getElementById('details-modal-body').innerHTML = `<p>${keperluan}</p>`;
    modal.classList.add('show');
}

// Function to close the details modal
function closeDetailsModal() {
    document.getElementById('detailsModal').classList.remove('show');
}

// Function to open the photo modal with the photo URL
function openPhotoModal(photoUrl) {
    const modal = document.getElementById('photoModal');
    document.getElementById('photo-modal-body').innerHTML = `
        <img src="${photoUrl}" alt="Guest Photo" style="width: 100%; height: auto;">
    `;
    modal.classList.add('show');
}

// Function to close the photo modal
function closePhotoModal() {
    document.getElementById('photoModal').classList.remove('show');
}

// Close modals when clicking outside of them
window.onclick = function(event) {
    if (event.target === document.getElementById('editModal')) {
        closeEditModal();
    }
    if (event.target === document.getElementById('detailsModal')) {
        closeDetailsModal();
    }
    if (event.target === document.getElementById('photoModal')) {
        closePhotoModal();
    }
}
</script>
    
    @include('super.footer') 
    
    <script type="text/javascript">
        function confirmation(ev) {
            ev.preventDefault();
            const form = ev.target.closest('form');
            const urlToRedirect = form.action;

            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this profile!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    form.submit();
                }
            });
        }
    </script>
</body>
</html>
