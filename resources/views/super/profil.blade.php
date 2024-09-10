<!DOCTYPE html>
<html lang="en">

<head>
    @include('super.css')
    

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
    @include('super.navbar')
    @include('super.sidebar')

    

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
                    
                        <p class="card-description">
                            Update your profile information below.
                        </p>


                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="{{ old('username', $user->username) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="whatsapp">WhatsApp</label>
                                <input type="text" class="form-control" id="whatsapp" name="whatsapp" value="{{ old('whatsapp', $user->whatsapp) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="alamat">Address</label>
                                <input type="text" class="form-control" id="alamat" name="alamat" value="{{ old('alamat', $user->alamat) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="usertype">User Level</label>
                                <input type="text" class="form-control" id="usertype" name="usertype" value="{{ old('usertype', $user->usertype) }}" required>
                            </div>
                            
                            

                            <div class="form-group">
                                <label for="edit-opd">Asal Dinas</label>
                                <select class="form-control" name="opd" id="edit-opd" required aria-label="Asal Dinas">
                                    <option value="" disabled selected>Pilih Dinas</option>
                                    @foreach($opd as $dinas)
                                    <option value="{{ $dinas->dinas }}" {{ old('opd', $user->opd) == $dinas->dinas ? 'selected' : '' }}>
                                    {{ $dinas->dinas }}
                                    </option> 
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>

                        <!-- Delete Profile Form -->
                        <form action="{{ route('profile.destroy') }}" method="POST" style="margin-top: 20px;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger" onclick="confirmation(event)">Delete Profile</button>
                         </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

        

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
