<!DOCTYPE html>
<html lang="en">

<head>
@include('super.css')
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

/* Button Styles */
.btn-primary {
    background-color: #3399ff;
    color: #fff;
    border-radius: 2px;
    width: 150px;
}

.btn-primary:hover {
    background-color: #000;
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
}

    </style>
</head>
<body>
@include('super.navbar')

@include('super.sidebar')

<div class="container-fluid px-4 py-5">
        <div class="row">
            
            <!-- Account Settings Form -->
            <div class="col-lg-8 order-lg-1">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">My Account</h6>
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
                    <form action="{{ route('profile.update') }}" method="POST">  
                        @csrf
                            

                            <h6 class="heading-small text-muted mb-4">User Information</h6>

                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="name">Username<span class="small text-danger">*</span></label>
                                            <input type="text" id="name" class="form-control" name="name" placeholder="Name" value="{{ old('name', Auth::user()->name) }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="name">Name<span class="small text-danger">*</span></label>
                                            <input type="text" id="username" class="form-control" name="username" placeholder="Name" value="{{ old('username', Auth::user()->username) }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="email">Email<span class="small text-danger">*</span></label>
                                            <input type="email" id="email" class="form-control" name="email" placeholder="example@example.com" value="{{ old('email', Auth::user()->email) }}">
                                        </div>
                                    </div>                                
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="email">Alamat<span class="small text-danger">*</span></label>
                                            <input type="text" id="alamat" class="form-control" name="alamat" placeholder="Jl. Indonesia Raya" value="{{ old('alamat', Auth::user()->alamat) }}">
                                        </div>
                                    </div>
                                <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="email">WhatsApp<span class="small text-danger">*</span></label>
                                            <input type="text" id="whatsapp" class="form-control" name="whatsapp" placeholder="086745454564" value="{{ old('whatsapp', Auth::user()->whatsapp) }}" pattern="\d+" 
                                            title="Please enter a valid WhatsApp number. Only digits are allowed.">
                                        </div>
                                    </div>
                                </div>
                             

                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="current_password">Current Password</label>
                                            <input type="password" id="current_password" class="form-control" name="current_password" placeholder="Current Password">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="new_password">New Password</label>
                                            <input type="password" id="new_password" class="form-control" name="new_password" placeholder="New Password">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="confirm_password">Confirm Password</label>
                                            <input type="password" id="new_password_confirmation" class="form-control" name="new_password_confirmation" placeholder="Confirm Password">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Save Button -->
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col text-center">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@include('super.footer')     
<script>
document.getElementById('whatsapp').addEventListener('input', function (e) {
    let value = e.target.value;
    // Remove non-numeric characters
    e.target.value = value.replace(/\D/g, '');
});
</script>
        
</body>

</html>
