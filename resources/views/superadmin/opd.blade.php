<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Department</title>
    @include('superadmin.css')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
        }

        /* Form Container */
        .form-container {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 2rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 800px;
            margin-bottom: 2rem;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 1rem;
        }

        .form-actions {
            margin-top: 1rem;
        }

        .btn {
            padding: 0.5rem 1rem;
            border-radius: 4px;
            text-align: center;
        }

        .btn-primary {
            background-color: #007bff;
            color: #fff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        /* Category Label */
        .cat_label {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin: 0.5rem 0 2rem;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 2rem;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            text-align: center;
        }

        /* Button Styles */
        .btn-info {
            background-color: #17a2b8;
            color: #fff;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
        }

        .btn-danger {
            background-color: #dc3545;
            color: #fff;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
        }

        .btn-info:hover, .btn-danger:hover {
            opacity: 0.8;
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
            border: 1px solid #ddd; /* Add border to enhance visibility */
        }

        .pagination .page-link:hover {
            background-color: #f8f9fa;
        }

        .pagination .page-item.active .page-link {
            background-color: #007bff;
            color: #fff;
            border: 1px solid #007bff; /* Match border color with active background */
        }

        .pagination .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
        }
    </style>
</head>

<body>
    @include('superadmin.navbar')
    @include('superadmin.sidebar')

    <div class="container-fluid">
        <div class="form-container">
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                </div>
            @endif

            <h1 class="cat_label">Tambah Dinas</h1>

            <form action="{{ url('add_dinas') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="opd">Asal Dinas</label>
                    <input type="text" id="opd" name="opd" class="form-control" required>
                </div>
                <div class="form-actions">
                    <input class="btn btn-primary" type="submit" value="Tambah">
                </div>
            </form>
        </div>

        <div class="form-container">
            <div class="div_center">
                @if(session()->has('success'))
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                        {{ session()->get('success') }}
                    </div>
                @endif
            </div>
            <h1 class="cat_label">Daftar Dinas</h1>
            <table>
                <thead>
                    <tr>
                        <th>Kategori</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($opds as $opd)
                    <tr>
                        <td>{{ $opd->dinas }}</td>
                        <td>
                            <button class="btn btn-info" data-toggle="modal" data-target="#editModal" data-id="{{ $opd->id }}" data-dinas="{{ $opd->dinas }}">Update</button>
                            <a onclick="confirmation(event, '{{ url('opd_delete/' . $opd->id) }}')" class="btn btn-danger" href="#">Hapus</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="pagination">
    <ul class="pagination">
        @if ($opds->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link">Previous</span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $opds->previousPageUrl() }}">Previous</a>
            </li>
        @endif

        @foreach ($opds->getUrlRange(1, $opds->lastPage()) as $number => $url)
            @if ($number == $opds->currentPage())
                <li class="page-item active">
                    <span class="page-link">{{ $number }}</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $url }}">{{ $number }}</a>
                </li>
            @endif
        @endforeach

        @if ($opds->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $opds->nextPageUrl() }}">Next</a>
            </li>
        @else
            <li class="page-item disabled">
                <span class="page-link">Next</span>
            </li>
        @endif
    </ul>
            </div>

    @include('superadmin.footer')

    <!-- Modal HTML -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Dinas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="modalDinas">Asal Dinas</label>
                            <input type="text" id="modalDinas" name="dinas" class="form-control" required>
                        </div>
                        <input type="hidden" id="modalId" name="id">
                        <div class="form-actions">
                            <input class="btn btn-primary" type="submit" value="Update">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Update JavaScript/jQuery for Modal -->
    <script type="text/javascript">
        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var id = button.data('id'); // Extract info from data-* attributes
            var dinas = button.data('dinas');
            
            var modal = $(this);
            modal.find('#modalId').val(id);
            modal.find('#modalDinas').val(dinas);
            modal.find('#editForm').attr('action', '/opd/update/' + id);
        });

        function confirmation(ev, url) {
            ev.preventDefault();

            swal({
                title: "Apa kamu ingin menghapus ini?",
                text: "Data yang dihapus tidak bisa kembali!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    window.location.href = url;
                }
            });
        }
    </script>

</body>

</html>
