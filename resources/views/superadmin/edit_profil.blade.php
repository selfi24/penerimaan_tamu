<!DOCTYPE html>
<html lang="en">

<head>
    @include('superadmin.css')
    

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   
    <style >
        /* Tambahkan gaya CSS untuk membuat foto profil berbentuk lingkaran dan menempatkannya di tengah */
       

        .form-container {
            margin-top: 20px;
        }

        .form-group label {
            font-weight: bold;
        }
    </style>
    <title>Update Profile</title>
</head>

<body>
    @include('superadmin.navbar')
    @include('superadmin.sidebar')

    

    <div class="container-fluid">
        <div class="row">

        
            <!-- Update Profile Section -->
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-primary">Update Profile</h4>

                    <div class="div_center">
                        @if(session()->has('message'))
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                        {{ session()->get('message') }}
                        </div>
                        @endif
                    </div>

                    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                    
                        <p class="card-description">
                            Update your profile information below.
                        </p>


                        <form action="{{ route('update_profil') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="username">Name</label>
                                <input type="text" class="form-control" id="username" name="username" value="{{ old('username', $user->username) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="name">Username</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="whatsapp">WhatsApp</label>
                                <input type="text" class="form-control" id="whatsapp" name="whatsapp" value="{{ old('whatsapp', $user->whatsapp) }}" pattern="\d+" title="Please enter a valid WhatsApp number. Only digits are allowed." required>
                            </div>
                            <div class="form-group">
                                <label for="alamat">Address</label>
                                <input type="text" class="form-control" id="alamat" name="alamat" value="{{ old('alamat', $user->alamat) }}" required>
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
                            
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>

                        <!-- Delete Profile Form -->
                        <form action="{{ route('destroy_profil') }}" method="POST" style="margin-top: 20px;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger" onclick="confirmation(event)">Delete Profile</button>
                         </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

        

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
<script>
document.getElementById('whatsapp').addEventListener('input', function (e) {
    let value = e.target.value;
    // Remove non-numeric characters
    e.target.value = value.replace(/\D/g, '');
});
</script>

</body>

</html>
