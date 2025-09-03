public function show_profil()
    {
        $user = User::all();

        return view('admin.profil',compact('user'));

    }

    public function profil_delete($id)
    {
        $data = User::find($id);

        $user->delete();

        return redirect()->back()->with('message','Profil Berhasil Dihapus');

    }

    public function edit_profil($id)
    {
        $user = User::find($id);
        return view('admin.edit_profile', compact('user'));
   
    }

    public function update_profil(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'whatsapp' => 'required|string|max:255',
            'dinas' => 'required|string|max:255',
            'opd' => 'required|string|max:255',
            'alamat' => 'required|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = User::find($id);
        $user->update($validated);

        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()->route('edit_profil', $id)->with('message', 'Profil berhasil diperbarui!');
    }

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

            <div class="mb-4">
                    <h5>Total Entries by Dinas:</h5>
                    <ul class="list-group">
                        @foreach ($totalAgencies as $opd_id => $count)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $opd_id }} <span class="badge badge-primary badge-pill">{{ $count }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>


                
route::get('/show_profil', [HomeController::class,'show_profil'])->name('show_profil');
route::get('profil_delete/{id}',[HomeController::class,'profil_delete']);
route::get('edit_profil/{id}', [HomeController::class, 'edit_profil'])->name('edit_profil');
route::put('update_profil/{id}', [HomeController::class, 'update_profil'])->name('update_profil');
Route::get('/webcam', function () {
    return view('webcam');
});


Route::get('tamu/{id}/edit', [HomeController::class, 'edit'])->name('tamu_edit');
Route::put('tamu/{id}', [HomeController::class, 'update'])->name('tamu_update');
Route::delete('/tamu/{id}', [HomeController::class, 'hapus'])->name('tamu_hapus');


<div class="form-group">
                                        <label for="opd_id">Tujuan Dinas</label>
                                        <select id="opd_id" name="opd_id" class="form-control">
                                            <option value="" disabled>Select Dinas</option>
                                            @foreach($opd as $item)
                                                <option value="{{ $item->id }}" {{ old('opd_id', $tamu->opd_id) == $item->id ? 'selected' : '' }}>
                                                    {{ $item->dinas }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>



    public function index()
    {
        $usertype = Auth()->user()->usertype;

        if($usertype == 'admin')
        {

        $user = User::all()->count();

        $opd = Opd::all()->count();

        $tamu = Tamu::all()->count();

        return view('super.index',compact('user','opd','tamu'));

        }
        else if($usertype == 'user')

            {

               return view('admin.home');

            } 
        }

    public function show()
    {
        $user = auth()->user();

        $opd = Opd::all();

        return view('super.profil',compact('user','opd'));
    }

    public function edit()
    {
        $user = Auth::user();
        $opd = Opd::all();
        
        if (!$user) {
            return redirect()->route('login')->withErrors('You need to be logged in to edit your profile.');
        }
        return view('super.profil', compact('user','opd'));
    }

    public function update(Request $request)
    {
    $user = Auth::user();

    if (!$user) {
        return redirect()->route('login')->withErrors('You need to be logged in to update your profile.');
    }

    $request->validate([
        'username' => 'required|string|max:255',
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'whatsapp' =>'required|string|regex:/^\d+$/|min:10|max:15',
        'alamat' => 'required|string|max:255',
        'current_password' => 'nullable|string',
        'new_password' => 'nullable|string|confirmed|min:8',
    ]);


    // Jika ada new_password, validasi current_password
    if ($request->filled('new_password') && !$request->filled('current_password')) {
        return redirect()->back()->withErrors([
            'current_password' => 'Current password is required to change the password.'
        ]);
    }

    // Periksa jika current_password diisi dan valid
    if ($request->filled('current_password') && !Hash::check($request->input('current_password'), $user->password)) {
        throw ValidationException::withMessages([
            'current_password' => ['The current password is incorrect.'],
        ]);
    }

    $user->username = $request->input('username');
    $user->name = $request->input('name');
    $user->email = $request->input('email');
    $user->whatsapp = $request->input('whatsapp');
    $user->alamat = $request->input('alamat');
    
    // Update password if a new password is provided
    if ($request->filled('new_password')) {
        $user->password = Hash::make($request->input('new_password'));
    }

    $user->save();

    return redirect()->route('profile.edit')->with('success', 'Profile updated successfully!');
}

public function destroy(Request $request)
{
    // Logic to delete the user profile
    $user = $request->user();
   
    $user->delete();

    // Optionally, log the user out after deletion
    Auth::logout();

    return redirect()->route('home')->with('message', 'Profile deleted successfully.');
}

public function upload(Request $request)
{
   // Validate the request
   $validator = Validator::make($request->all(), [
    'nama' => 'required|string|max:255',
    'alamat' => 'required|string',
    'opd_id' =>'required|exists:opds,id',
    'keperluan' => 'required|string|string|max:100000',
    'webcamImage' => 'nullable|string',
]);

if ($validator->fails()) {
    return response()->json(['errors' => $validator->errors()], 422);
}

// Handle the webcam image
$imagePath = null;
if ($request->has('webcamImage')) {
    $imageData = $request->input('webcamImage');
    $imageData = str_replace('data:image/png;base64,', '', $imageData);
    $imageData = str_replace(' ', '+', $imageData);
    $image = base64_decode($imageData);
    $imageName = 'webcam_capture_' . time() . '.png';
    $imagePath = 'uploads/' . $imageName;
    Storage::disk('public')->put($imagePath, $image);
}

// Create a newGuest record
$tamu = new Tamu();
$tamu->nama = $request->input('nama');
$tamu->alamat = $request->input('alamat');
$tamu->opd_id = auth()->user()->id;
$tamu->dinas = auth()->user()->id;
$tamu->keperluan = $request->input('keperluan');
$tamu->webcamImage = $imagePath;
$tamu->save();

    return redirect()->route('tamu')->with('success', 'Data tamu berhasil dikirim');
}

public function tamu()
{

    $user = auth()->user();

    $authUser = auth()->user();
    
    $opd = Opd::all();

    $tamu = Tamu::where('opd_id', $user->opd_id)->get();
   
    return view('super.entry_tamu', compact('tamu','opd', 'authUser'));
}

public function show_tamu()
    {
        $user = auth()->user();

        $authUser = auth()->user();

        $userOpdId = $user->opd_id;

        $tamu = Tamu::where('opd_id', $authUser)
                ->orWhere('dinas', $user->id) // Assuming 'created_by' is the field storing who created the entry
                ->get();
        $opd = Opd::all() ?? [];

        Log::info('Tamu data retrieved', ['count' => $tamu->count(), 'data' => $tamu]);

        return view('super.show_tamu',compact('tamu','opd', 'authUser'));
    }

    public function delete($id)
    {
        Log::info('Attempting to delete tamu with ID: ' . $id);

        // Find the record by ID and delete it
        $user = auth()->user();

        $tamu = Tamu::find($id);
        if (!$tamu || $tamu->opd !== $user->opd_id) {
            Log::warning('Tamu not found for ID: ' . $id);
            return redirect()->back()->with('message', 'Data tamu tidak ditemukan.');
        }
        $tamu->delete();

        Log::info('Tamu successfully deleted with ID: ' . $id);
        // Redirect or return a response
        return redirect()->back()->with('message', 'Data tamu berhasil dihapus.');
    }

    public function ed_tamu($id)
    {
    $tamu = Tamu::find($id);
    
    $opd = Opd::all();
    
    return view('super.edit_tamu', compact('tamu', 'opd'));
    }

    public function up_tamu(Request $request, $id)
    {
       
        // Find the Tamu by ID
    $tamu = Tamu::find($id);

    // Check if Tamu exists
    if (!$tamu) {
        return redirect()->back()->with('error', 'Tamu not found.');
    }

    // Validate the request data
    $validated = $request->validate([
        'nama' => 'required|string|max:255',
        'alamat' => 'required|string',
        'opd_id' => 'required|exists:opds,id',
        'keperluan' => 'required|string|max:1000',
        'webcamImage' => 'nullable|file|image|max:2048',// For file upload
         ]);

    // Update Tamu record fields
    $tamu->nama = $request->input('nama');
    $tamu->alamat = $request->input('alamat');
    $tamu->opd_id = $request->input('opd_id');
    $tamu->keperluan = $request->input('keperluan');


    // Handle file input (photo)
    if ($request->hasFile('webcamImage')) {
        // Optionally delete old photo if necessary
        if ($tamu->webcamImage && Storage::disk('public')->exists('uploads/' . $tamu->webcamImage)) {
            Storage::disk('public')->delete('uploads/' . $tamu->webcamImage);
        }

        // Store new photo
        $file = $request->file('webcamImage');
        $imageName = 'webcam_capture_' . time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/', $imageName);

        // Update Tamu record with the new file path
        $tamu->webcamImage = $imageName;
        
    }
    
    // Save the updated Tamu record
    $tamu->save();

        return redirect()->back()->with('success', 'Tamu berhasil di update!');
    }
   
}



super controller

public function edit_user(Request $request)
    {
    $user = Auth::user();
    $opd = Opd::all();
    $request->validate([
        'username' => 'nullable|string|max:255',
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'whatsapp' =>'required|string|regex:/^\d+$/|min:10|max:15',
        'alamat' => 'nullable|string|max:255',
        'opd_id' =>'nullable|exists:opds,id',
        'new_password' => 'required|string|confirmed|min:8',
    ]);

    // Tentukan usertype
    $usertype = !empty($request->opd) ? 'admin' : 'user';

    $user = new User();
    $user->name = $request->name;
    $user->username = $request->username;
    $user->email = $request->email;
    $user->alamat = $request->alamat;
    $user->whatsapp = $request->whatsapp;
    $user->opd_id= $request->opd;
    $user->usertype = $usertype; // Pastikan ini tidak null
    if ($request->new_password) {
        $user->password = Hash::make($request->new_password);
    }
    $user->save();

    return redirect()->route()->with('success', 'Profile updated successfully!');
    }


    chart super
    options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Number of Guests'
                    }
                },

                forgot password
                <a href="{{ route('password.request') }}" class="ml-auto mb-0 text-sm">Forgot Password ?</a>
                          

                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Register<i class="fa fa-arrow-right ms-3"></i></a>  

                                    @endif

                                    
                <li class="nav-item"> <a class="nav-link" href="{{ route('pengguna') }}">Users</a></li>

                



          <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
            <div class="d-flex justify-content-between">
                <h4 class="card-title">Diagram Total Tamu</h4>
                <a href="{{ route('buka_tamu') }}" class="text-info">View all</a>
  </div>
  <p class="font-weight-500">Menampilkan seluruh data tamu yang masuk sesuai dinas.</p>
                <canvas id="userAreaPieChart" width="350" height="150"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const labels = @json($labels); // Labels untuk setiap dinas
    const counts = @json($counts); // Jumlah tamu berdasarkan dinas
    const chartColors = @json($chartColors); // Warna untuk setiap dinas

    // Mendapatkan konteks untuk canvas
    const ctxDinas = document.getElementById('dinas-chart').getContext('2d');

    // Membuat Bar Chart untuk asal dinas
    new Chart(ctxDinas, {
        type: 'bar', // Bar chart
        data: {
            labels: labels,
            datasets: [{
                data: counts,
                backgroundColor: chartColors, // Menggunakan warna yang sudah ditetapkan
                borderColor: '#ffffff', // Border putih untuk setiap bar
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top', // Menampilkan legend di atas
                },
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Dinas' // Label untuk sumbu X
                    }
                },
                y: {
                    min: 0,
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah Tamu' // Label untuk sumbu Y
                    }
                }
            }
        },
    });
});

</script>


<div class="row mb-4 px-3">
                                <small class="font-weight-bold">Don't have an account ? <a class="text-danger" href="{{ route('register') }}">Register</a></small>
                            </div>

                            <!-- Edit Guest Modal HTML -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEditModal()">&times;</span>
        <div id="modal-body">
            <!-- Form content here -->
            <form id="editForm" action="" method="POST">
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
                        <option value="{{ $opd->id }}" {{ old('opd' == $tamus->opd_id) == $opd->id ? 'selected' : '' }}>
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
super
<!-- Delete Profile Form -->
                                         
<form action="{{ route('profile.destroy') }}" method="POST" style="margin-top: 20px;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger" style="border-radius: 10px;" onclick="confirmation(event)">Hapus</button>
                         </form>
<script type="text/javascript">
    function confirmation(ev) {
        ev.preventDefault();
        const form = ev.target.closest('form');
        const urlToRedirect = form.action;

        swal({
            title: "Apa kamu yakin menghapus akun ini?",
            text: "Akun yang dihapus tidak bisa kembali!",
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
superadmin
<div class="col-md-6 mb-4 stretch-card transparent">
                  <div class="card card-tale">
                    <div class="card-body">
                      <p class="mb-4">Total User</p>
                      <p class="fs-30 mb-2">{{$users}}</p>
                      <p></p>
                    </div>
                  </div>
                </div>

                <!-- Delete Profile Form -->
 <form action="{{ route('destroy_profil') }}" method="POST" style="margin-top: 20px;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger" onclick="confirmation(event)">Hapus</button>
                         </form>
    
    <script type="text/javascript">
    function confirmation(ev) {
        ev.preventDefault();
        const form = ev.target.closest('form');
        const urlToRedirect = form.action;

        swal({
            title: "Apa kamu yakin menghapus akun ini?",
            text: "Akun yang dihapus tidak bisa kembali!",
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