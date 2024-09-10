<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.header')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   
    <style>
        body, ul {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            margin-top: 0;
            font-size: 24px;
            color: #333;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            border: 1px solid transparent;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }

        .user-profile {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            background: #fff;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .user-profile h3 {
            margin-top: 0;
            font-size: 20px;
            color: #333;
        }

        .user-profile p {
            margin: 10px 0;
            font-size: 16px;
            line-height: 1.6;
        }

        .user-profile p strong {
            display: inline-block;
            width: 150px;
            font-weight: bold;
            color: #333;
        }

        .form-actions {
            display: flex;
            justify-content: center; /* Centers buttons horizontally */
            gap: 10px; 
        }


        .update-form, .delete-form {
            display: inline;
        }

        .delete-form button {
            padding: 10px 20px;
            border: none;
            color: #fff;
            background-color: #dc3545;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        .delete-form button:hover {
            background-color: #c82333;
        }

        .update-form button {
            padding: 10px 20px;
            border: none;
            color: #fff;
            background-color: #28a745;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        .update-form button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    @include('admin.navbar') 

    

        <div class="div_center">
            @if(session()->has('message'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    {{ session()->get('message') }}
                </div>
            @endif
        </div>

        <div class="container">
        <h2>Edit Profile</h2>

        <!-- User Profiles -->
        @foreach($user as $user)
            <div class="user-profile">
                <h3>Profile Information</h3>
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Username:</strong> {{ $user->username }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>WhatsApp:</strong> {{ $user->whatsapp }}</p>
                <p><strong>Dinas:</strong> {{ $user->dinas }}</p>
                <p><strong>OPD:</strong> {{ $user->opd }}</p>
                <p><strong>Address:</strong> {{ $user->alamat }}</p>

                <!-- Delete Form -->
                <form action="{{url('profil_delete',$user->id)}}" method="POST" class="delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure you want to delete this profile?')">Delete Profile</button>
                </form>

                 <!-- Update Form -->
                 <form action="{{ url('edit_profil', $user->id) }}" method="POST" class="update-form">
                    @csrf
                    @method('PUT') <!-- Use PUT method for updating -->
                    <button type="submit">Update Profile</button>
                </form>
            </div>
        @endforeach
    </div>

    
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.delete-form button').forEach(function(button) {
            button.addEventListener('click', function(ev) {
                ev.preventDefault();
                var form = this.closest('form');

            swal({
                title: "Are you sure you want to delete this?",
                text: "Once deleted, you will not be able to recover this profile!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    window.location.href = urlToRedirect;
                }
            });
        }
    </script>
</body>
</html>
