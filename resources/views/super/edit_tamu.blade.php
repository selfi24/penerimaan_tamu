<!DOCTYPE html>
<html lang="en">
<head>
    @include('super.css')
    <title>Edit Guest</title>
</head>
<body>
    @include('super.navbar')
    @include('super.sidebar')

    <div class="container-fluid">
        <h4 class="card-title">Edit Guest</h4>
        <form action="" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nama">Name</label>
                <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', $tamu->nama) }}" required>
            </div>

            <div class="form-group">
                <label for="opd">Asal Dinas</label>
                <input type="text" name="opd" id="opd" class="form-control" value="{{ old('opd', $tamu->opd) }}" required>
            </div>

            <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" name="alamat" id="alamat" class="form-control" value="{{ old('alamat', $tamu->alamat) }}" required>
            </div>

            <div class="form-group">
                <label for="keperluan">Keperluan</label>
                <textarea name="keperluan" id="keperluan" class="form-control" required>{{ old('keperluan', $tamu->keperluan) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update Guest</button>
        </form>
    </div>

    @include('super.footer')
</body>
</html>
