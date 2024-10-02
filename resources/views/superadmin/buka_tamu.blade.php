<!DOCTYPE html>
<html lang="en">
<head>
    @include('superadmin.css')
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

.photo-preview {
    margin: 1rem 0;
}

.photo-preview img {
    max-width: 150px;
    height: auto;
    border: 1px solid #ddd;
    border-radius: 0.25rem;
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
    margin: 5% auto;
    padding: 15px;
    border: 1px solid #888;
    width: 90%;
    max-width: 800px;
    max-height: 80vh;
    overflow-y: auto;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

/* Form Styles */
.form-group {
    margin-bottom: 1rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: bold;
}

.form-control,
select.form-control,
textarea.form-control {
    display: block;
    width: 100%;
    height: 2.5rem;
    padding: 0.5rem;
    font-size: 1rem;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    box-sizing: border-box;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.select-container {
    position: relative;
    display: inline-block;
    width: 100%;
}

.select-container select {
    width: 100%;
    height: 2.5rem;
    padding: 0.5rem;
    padding-right: 2.5rem;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    appearance: none;
    background-color: #fff;
    font-size: 1rem;
    color: #495057;
}

.select-container::after {
    content: '\f078';
    font-family: "Font Awesome 5 Free";
    position: absolute;
    right: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    font-weight: 900;
    color: #495057;
    pointer-events: none;
}

/* Button Styles */
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
    background-color: #0069d9;
    border-color: #0062cc;
}

/* Pagination Styles */
.pagination {
    display: flex;
    justify-content: center;
    margin-top: 1rem;
    padding: 0;
    list-style: none;
}

.pagination .page-item {
    margin: 0 0.1rem;
}

.pagination .page-link {
    padding: 0.5rem 1rem;
    border-radius: 4px;
    color: #007bff;
    text-decoration: none;
    border: 1px solid #ddd;
}

.pagination .page-link:hover {
    background-color: #f8f9fa;
}

.pagination .page-item.active .page-link {
    background-color: #007bff;
    color: #fff;
    border: 1px solid #007bff;
}

.pagination .page-item.disabled .page-link {
    color: #6c757d;
    pointer-events: none;
}

/* Responsive Adjustment */
@media (max-width: 768px) {
    .container-fluid {
        padding-top: 60px;
    }
}
    </style>
</head>
<body>
    @include('superadmin.navbar')
    @include('superadmin.sidebar')

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
                                        <th>Tujuan Dinas</th>
                                        <th>Alamat</th>
                                        <th>Tanggal</th>
                                        <th>Keperluan</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if($tamu->isNotEmpty())
                                    @foreach($tamu as $item)
                                        <tr>
                                            <td>{{ $item->nama }}</td>
                                            <td>{{ $item->opd->dinas }}</td>
                                            <td>{{ $item->alamat }}</td>
                                            <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                            <td>
                                                <a class="bg-teal-300 cursor-pointer rounded p-1 mx-1 text-white" onclick="openModal({{ json_encode($item->keperluan) }})" aria-label="View details">
                                                    <i class="fas fa-eye" style="font-size: 24px; color: black;"></i>
                                                </a>
                                            
                                            <a class="bg-teal-300 cursor-pointer rounded p-1 mx-1 text-white" onclick="openPhotoModal('{{ asset('storage/' . $item->webcamImage) }}')" aria-label="View photo">
                                                    <i class="fas fa-camera" style="font-size: 24px; color: black;"></i>
                                                </a></td>
                                                <td>
    <a class="bg-teal-300 cursor-pointer rounded p-1 mx-1 text-white" aria-label="Edit" href ="{{ route('tamu_edit' , $item->id)  }}">
        <i class="fas fa-edit" style="font-size: 24px; color: blue;"></i>
    </a>
    <form action="{{ route('delete_tamu', $item->id) }}" method="POST" style="display:inline;">
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

                     <!-- Pagination Links -->
    <div class="pagination">
                <ul class="pagination">
                    @foreach ($tamu->links()->elements as $element)
                        @if (is_array($element))
                            @foreach ($element as $number => $link)
                                @if ($number == $tamu->currentPage())
                                    <li class="page-item active">
                                        <span class="page-link">{{ $number }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $link }}">{{ $number }}</a>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                </ul>
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
            <form id="editForm" action="{{ route('update_tamu', $item->id) }}" method="POST">
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
                        <option value="{{ $opd->id }}" {{ old('opd' == $item->opd_id) == $opd->id ? 'selected' : '' }}>
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
    
    @include('superadmin.footer') 
    
    <script type="text/javascript">
        function confirmation(ev) {
            ev.preventDefault();
            const form = ev.target.closest('form');
            const urlToRedirect = form.action;

            swal({
                title: "Apa kamu ingin menghapus ini?",
                text: "Data yang dihapus tidak bisa kembali!",
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
