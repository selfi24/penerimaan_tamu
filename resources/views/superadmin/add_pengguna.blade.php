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

                        <form action="{{ route('user.req') }}" method="POST">  
                            @csrf
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="name">Username<span class="small text-danger">*</span></label>
                                            <input type="text" id="name" class="form-control" name="name" placeholder="Username" value="{{ old('name') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="username">Name</label>
                                            <input type="text" id="username" class="form-control" name="username" placeholder="Name" value="{{ old('username') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="email">Email<span class="small text-danger">*</span></label>
                                            <input type="email" id="email" class="form-control" name="email" placeholder="example@example.com" value="{{ old('email') }}">
                                        </div>
                                    </div>                                
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="alamat">Alamat</label>
                                            <input type="text" id="alamat" class="form-control" name="alamat" placeholder="Jl. Indonesia Raya" value="{{ old('alamat') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="opd">Asal Dinas<span class="small text-danger">*</span></label>
                                            <select id="opd" name="opd" class="form-control">
                                                <option value="" disabled selected>Select Dinas</option>
                                                @foreach($opd as $item)
                                                    <option value="{{ $item->id }}">{{ $item->dinas }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="whatsapp">WhatsApp</label>
                                            <input type="text" id="whatsapp" class="form-control" name="whatsapp" placeholder="086745454564" value="{{ old('whatsapp') }}" pattern="\d+" title="Please enter a valid WhatsApp number. Only digits are allowed.">
                                        </div>
                                    </div>                   
                                    <div class="col-lg-4">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="new_password">New Password<span class="small text-danger">*</span></label>
                                            <input type="password" id="new_password" class="form-control" name="new_password" placeholder="New Password">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="new_password_confirmation">Confirm Password<span class="small text-danger">*</span></label>
                                            <input type="password" id="new_password_confirmation" class="form-control" name="new_password_confirmation" placeholder="Confirm Password">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Button Container -->
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col text-center button-container">
                                        <button type="submit" class="btn btn-primary">Add User</button>
                                        <a href="{{ route('pengguna') }}" class="btn btn-danger">Close</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('superadmin.footer')     
    <script>
        document.getElementById('whatsapp').addEventListener('input', function (e) {
            let value = e.target.value;
            // Remove non-numeric characters
            e.target.value = value.replace(/\D/g, '');
        });
    </script>
        
</body>

</html>
