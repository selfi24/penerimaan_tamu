
<!DOCTYPE html>
<html lang="en">
<head>
    @include('superadmin.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert@2"></script>

    <title>Management User</title>
    
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
    margin: 5% auto; /* Adjust top and bottom margins to center the modal */
    padding: 15px;
    border: 1px solid #888;
    width: 90%; /* Increase width to make the modal wider */
    max-width: 800px; /* Set a maximum width for larger screens */
    max-height: 80vh; /* Maintain the height for large content */
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
    color: #fff;
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
                        <h4 class="card-title">Data Admin</h4>
                        <a href="{{ route('add_user') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah
                        </a>
                       
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
                                <th>Username</th>
                                <th>Email</th>
                                <th>WhatsApp</th>
                                <th>Alamat</th>
                                <th>Asal Dinas</th>
                                <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if($users->isNotEmpty())
                                    @foreach($users as $user)
                                        <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->whatsapp }}</td>
                                <td>{{ $user->alamat }}</td>
                                <td>{{ $user->opd->dinas}}</td>
                                            <td>
                                                
                                            <a class="bg-teal-300 cursor-pointer rounded p-1 mx-1 text-white" aria-label="Edit" href="{{ route('edit_admin', $user->id) }}">
    <i class="fas fa-edit" style="font-size: 24px; color: blue;"></i>
</a>

    <form action="{{ route('users.destroy', $user->id) }}}" method="POST" style="display:inline;">
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

                    <div class="pagination">
    <ul class="pagination">
        @if ($users->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link">Previous</span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $users->previousPageUrl() }}">Previous</a>
            </li>
        @endif

        @foreach ($users->getUrlRange(1, $users->lastPage()) as $number => $url)
            @if ($number == $users->currentPage())
                <li class="page-item active">
                    <span class="page-link">{{ $number }}</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $url }}">{{ $number }}</a>
                </li>
            @endif
        @endforeach

        @if ($users->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $users->nextPageUrl() }}">Next</a>
            </li>
        @else
            <li class="page-item disabled">
                <span class="page-link">Next</span>
            </li>
        @endif
    </ul>
            </div>

                </div>
            </div>
        </div>
    </div>


    <!-- Modal HTML -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="modalId" name="id">

                    <div class="form-group">
                        <label for="modalName">Username</label>
                        <input type="text" id="modalName" name="name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="modalUsername">Nama</label>
                        <input type="text" id="modalUsername" name="username" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="modalEmail">Email</label>
                        <input type="email" id="modalEmail" name="email" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="modalWhatsapp">WhatsApp</label>
                        <input type="text" id="modalWhatsapp" name="whatsapp" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="modalAddress">Alamat</label>
                        <input type="text" id="modalAddress" name="alamat" class="form-control" required>
                    </div>

                    <select id="modalOpd" name="opd_id" class="form-control" required>
    <option value="" disabled selected>Select Dinas</option>
    @foreach($opd as $opdOption)
        <option value="{{ $opdOption->id }}">{{ $opdOption->dinas }}</option>
    @endforeach
</select>


                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
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
<script>
   function editUser(user) {
    // Populate modal fields with user data
    document.getElementById('modalId').value = user.id;
    document.getElementById('modalName').value = user.name;
    document.getElementById('modalUsername').value = user.username;
    document.getElementById('modalEmail').value = user.email;
    document.getElementById('modalWhatsapp').value = user.whatsapp;
    document.getElementById('modalAddress').value = user.alamat;
    
    // Set the form action URL
    document.getElementById('editForm').action = `/users/${user.id}`;

    // Populate the OPD dropdown and set the selected value
    const opdSelect = document.getElementById('modalOpd');
    opdSelect.value = user.opd_id; // Ensure this value matches an option in the dropdown

    // Show the modal
    const modal = document.getElementById('editModal');
    modal.classList.add('show');
}

        
    

    
// Function to close the edit modal
function closeEditModal() {
    document.getElementById('editModal').classList.remove('show');
}


// Close modals when clicking outside of them
window.onclick = function(event) {
    if (event.target === document.getElementById('editModal')) {
        closeEditModal();
    }

    
    };
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
