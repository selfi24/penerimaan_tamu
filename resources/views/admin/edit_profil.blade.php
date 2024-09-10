<!DOCTYPE html>
<html lang="en">
<head>
   

    @include('admin.header')

    <style type="text/css">
        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input, .form-group textarea, .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .form-group button {
            padding: 10px 20px;
            border: none;
            color: #fff;
            background-color: #007bff;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        .form-group button:hover {
            background-color: #0056b3;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }
    </style>
</head>
<body>
    @include('admin.navbar')

    <div class="container">
        <h2>Edit Profil</h2>

        

        <!-- Success Message -->
        @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif

        <!-- Edit Profile Form -->
        <form action="{{ url('update_profil', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="{{ old('username', $user->username) }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="form-group">
                <label for="whatsapp">No WhatsApp</label>
                <input type="text" id="whatsapp" name="whatsapp" value="{{ old('whatsapp', $user->whatsapp) }}" required>
            </div>

            <div class="form-group">
                <label for="dinas">Dinas</label>
                <input type="text" id="dinas" name="dinas" value="{{ old('dinas', $user->dinas) }}" required>
            </div>

            <div class="form-group">
                <label for="opd">OPD</label>
                <input type="text" id="opd" name="opd" value="{{ old('opd', $user->opd) }}" required>
            </div>

            <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea id="alamat" name="alamat" rows="4" required>{{ old('alamat', $user->alamat) }}</textarea>
            </div>

            <div class="form-group">
                <label for="password">Password (leave blank to keep current password)</label>
                <input type="password" id="password" name="password">
            </div>

            <div class="form-group">
                <button type="submit">Update Profil</button>
            </div>
        </form>
    </div>

    @include('admin.footer')
    
</body>
</html>
