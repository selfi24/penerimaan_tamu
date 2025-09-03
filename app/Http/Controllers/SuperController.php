<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Validator;

use Illuminate\Validation\ValidationException;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\DB;

use App\Models\User;

use App\Models\Tamu;

use App\Models\Opd;

class SuperController extends Controller
{
    public function super()
    {
        $admin = User::where('usertype', 'admin')->count();

        $users = User::where('usertype', 'user')->count();

        $user = Opd::all()->count();

        $opdCount = Opd::select('id', DB::raw('count(*) as total'))
                    ->groupBy('id')
                    ->get();

    $opdLabels = [];
    $opdCounts = [];
    $opdColors = [
    '#FFA07A', '#FF7F50', '#FFD700', '#ADFF2F', '#40E0D0',
    '#87CEFA', '#9370DB', '#FF69B4', '#F08080', '#DDA0DD',
    '#E9967A', '#98FB98', '#AFEEEE', '#4682B4', '#FF6347',
    '#FFDAB9', '#CD5C5C', '#66CDAA', '#B0C4DE', '#FFA500',
    '#7B68EE', '#6A5ACD', '#5F9EA0', '#8FBC8F'
    ];

    foreach ($opdCount as $opd) {
        $opdItem = Opd::find($opd->id); // Fetch OPD name
        if ($opdItem) {
            $opdLabels[] = $opdItem->dinas; // OPD names
            $opdCounts[] = $opd->total;    // Count per OPD
            }
    }

        $user = Tamu::all()->count();

        $tamuCounts = Tamu::select('opd_id', DB::raw('count(*) as count'))
        ->groupBy('opd_id')
        ->get();

    $totalAgencies = [];
    $labels = [];
    $counts = [];
    $chartColors = [];

    foreach ($tamuCounts as $index => $item) {
        $opd = Opd::find($item->opd_id); // Ambil nama dinas berdasarkan opd_id
        if ($opd) {
            $labels[] = $opd->dinas; // Nama dinas
            $counts[] = $item->count; // Jumlah tamu
            $chartColors[] = $opdColors[$index]; // Warna yang sudah ditentukan
        }
    }

        $usertype = Auth()->user()->usertype;

        if($usertype == 'superadmin')
        {

        $user = User::all()->count();

        $opd = Opd::all()->count();

        $tamu = Tamu::all()->count();

        return view('superadmin.index',compact('user','admin','users','opd','tamu','labels', 'counts', 'chartColors', 'totalAgencies', 'opdLabels', 'opdCounts', 'opdColors'));

        }
        else if($usertype == 'user')

            {

               return view('admin.home');

            } 
        }

        private function generateRandomColor()
        {
            // Generate random RGB values
            $r = rand(0, 255);
            $g = rand(0, 255);
            $b = rand(0, 255);
            return "rgba($r, $g, $b, 0.6)"; // Return an RGBA color with 60% opacity
        }

        public function show_profil()
    {
        $user = auth()->user();

        return view('superadmin.edit_profil',compact('user'));
    }

    public function edit_profil()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->withErrors('You need to be logged in to edit your profile.');
        }
        return view('superadmin.edit_profil', compact('user'));
    }

    public function updateProfil(Request $request)
    {
    $user = Auth::user();

    // Validate the request data
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users,username,' . $user->id,
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        'alamat' => 'required|string|max:255',
        'whatsapp' => 'required|string|max:20',
        'current_password' => 'nullable|current_password',
        'new_password' => 'nullable|min:8|confirmed',
    ]);

    // Update user information
    $user->name = $request->input('name');
    $user->username = $request->input('username');
    $user->email = $request->input('email');
    $user->alamat = $request->input('alamat');
    $user->whatsapp = $request->input('whatsapp');

    // Check if current password is provided and valid
    if ($request->filled('current_password') && Hash::check($request->input('current_password'), $user->password)) {
        // Update password if a new password is provided
        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->input('new_password'));
        }
    }

    $user->save();

    return redirect()->back()->with('message', 'Profil berhasil diperbarui!');
    }


    public function destroy_profil(Request $request)
    {
    // Logic to delete the user profile
    $user = $request->user();
   
    $user->delete();

    // Optionally, log the user out after deletion
    Auth::logout();

    return redirect()->route('home')->with('message', 'Profil berhasil dihapus.');
    }
   

    public function opd()
    {
    $opds = Opd::paginate(7);

    return view('superadmin.opd' ,compact('opds')); // Adjust the view path as needed
    }

// Store a newly created department in storage
    public function add_dinas(Request $request)
    { 
        $request->validate([
            'opd' => 'required|unique:opds,dinas|max:255', // Pastikan 'opd' unik dalam kolom 'dinas'
        ], [
            'opd.required' => 'Nama OPD tidak boleh kosong.',
            'opd.unique' => 'Nama OPD sudah ada, masukkan nama lain.',
            'opd.max' => 'Nama OPD tidak boleh lebih dari 255 karakter.',
        ]);

    $opd = new Opd;

    $opd->dinas= $request->opd;

    $opd->save();
    // Redirect to the form with a success message
    return redirect()->back()->with('message', 'Dinas berhasil ditambah!');
    }


    public function opd_delete($id)
    {
    $opd= Opd::find($id);

    $opd->delete();

    return redirect()->back()->with('success','Dinas berhasil dihapus');
    }

    public function update_opd(Request $request,$id)
    {
        $request->validate([
            'dinas' => 'required|unique:opds,dinas|max:255',
        ], [
            'dinas.required' => 'Nama OPD tidak boleh kosong.',
            'dinas.unique' => 'Nama OPD sudah ada, masukkan nama lain.',
            'dinas.max' => 'Nama OPD tidak boleh lebih dari 255 karakter.',
        ]);

        $opd = Opd::find($id);

        $opd->dinas = $request->dinas;

        $opd->save();

        return redirect()->back()->with('message', 'Dinas berhasil diperbarui!');
    
    }


    public function user()
    {
    $users = User::where('usertype', 'admin')->paginate(7); // Ensure pagination is used
    
    $opd = Opd::all();
    
    return view('superadmin.user', compact('users', 'opd'));
    }
    
    public function up(Request $request, $id)
    {
        $users = User::find($id);

        
    if (!$users) {
        return redirect()->back()->with('message', 'User tidak ditemukan.');
    }

        $request->validate([
        'name' => 'required|string|max:255',
        'username' => 'nullable|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id,
        'whatsapp' => 'nullable|string',
        'alamat' => 'nullable|string',
        'opd_id' =>'nullable|exists:opds,id',
        'password' => 'nullable|string|min:8|confirmed', // Ensure the password is validated if provided
    ]);
    $user->name = $request->input('name');
    $user->username = $request->input('username');
    $user->email = $request->input('email');
    $user->whatsapp = $request->input('whatsapp');
    $user->alamat = $request->input('alamat');
    $user->opd_id = $request->input('opd');

    // Check if a new password is provided and hash it
    if ($request->filled('password')) {
        $user->password = Hash::make($request->input('password'));
    }

    $users->save();
       

        return redirect()->back()->with('success', 'User berhasil diperbarui.');
    }

    // Method to delete a user
    public function del($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect()->back()->with('message', 'User berhasil dihapus.');
    }

    public function add()
    {
        $user = auth()->user();

        $opd = Opd::all();

        return view('superadmin.add_user',compact('user','opd'));
    }


    public function store(Request $request)
    {
    $user = Auth::user();
    $opd = Opd::all();
    $request->validate([
        'username' => 'nullable|string|max:255',
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'whatsapp' =>'nullable|string|regex:/^\d+$/|min:10|max:15',
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
    
    if (User::where('email', $request->email)->exists()) {
        return redirect()->back()->withErrors(['email' => 'Email sudah terdaftar']);
    }
    $user->alamat = $request->alamat;
    $user->whatsapp = $request->whatsapp;
    $user->opd_id= $request->opd;
    $user->usertype = $usertype; // Pastikan ini tidak null
    if ($request->new_password) {
        $user->password = Hash::make($request->new_password);
    }
    $user->save();

    return redirect()->back()->with('success', 'Admin berhasil ditambah!');
    }


    public function pengguna()
    {
    $users = User::where('usertype', 'user')->paginate(7);

    $opd = Opd::all();
    
    return view('superadmin.pengguna', compact('users' , 'opd'));
    }

    public function upp(Request $request, $id)
    {
        $users = User::find($id);

        $opd = Opd::all();
        
    if (!$users) {
        return redirect()->back()->with('message', 'User tidak ditemukan.');
    }

        $request->validate([
        'name' => 'required|string|max:255',
        'username' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id,
        'whatsapp' => 'required|string',
        'opd_id' =>'nullable|exists:opds,id',
        'alamat' => 'required|string',
        'password' => 'nullable|string|min:8|confirmed', // Ensure the password is validated if provided
    ]);
    Log::info('opd_id:', [$request->opd_id]);
     // Tentukan usertype berdasarkan keberadaan opd
    $usertype = !empty($request->opd) ? 'admin' : 'user';

    $users->name = $request->input('name');
    $users->username = $request->input('username');
    $users->email = $request->input('email');
    $users->whatsapp = $request->input('whatsapp');
    $users->opd_id= $request->input('opd');
    $users->alamat = $request->input('alamat');
    $users->usertype = $usertype;

    // Check if a new password is provided and hash it
    if ($request->filled('password')) {
        $users->password = Hash::make($request->input('password'));
    }

    $users->save();
       

    return redirect()->back()->with('success', 'User berhasil diperbarui.');
    }

    // Method to delete a user
    public function dell($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect()->back()->with('message', 'User berhasil dihapus!');
    }

    public function add_pengguna()
    {
        $user = auth()->user();

        $opd = Opd::all();

        return view('superadmin.add_pengguna',compact('user' , 'opd'));
    }


    public function req(Request $request)
    {
        $user = Auth::user();
        $opd = Opd::all();
        $request->validate([
            'username' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'whatsapp' =>'nullable|string|regex:/^\d+$/|min:10|max:15',
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

    return redirect()->back()->with('success', 'User berhasil ditambah!');
    }


    public function upload_tamu(Request $request)
    {
    // Validate the request
    $validator = Validator::make($request->all(), [
        'nama' => 'required|string|string|max:255',
        'alamat' => 'required|string',
        'dinas' => 'nullable|string',
        'opd_id' =>'required|exists:opds,id',
        'keperluan' => 'required|string|string|max:1000',
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
    $tamu->dinas = $request->input('dinas');
    $tamu->opd_id = $request->input('opd_id');
    $tamu->keperluan = $request->input('keperluan');
    $tamu->webcamImage = $imagePath;
    $tamu->save();

    return redirect()->route('buka_tamu')->with('success', 'Data tamu berhasil ditambah');
    }

    public function enter_tamu()
    {
    $user = auth()->user();
    
    $opd = Opd::all();

    $tamu = Tamu::all();
   
    return view('superadmin.data_tamu', compact('tamu','opd'));
    }

    public function buka_tamu()
    {
        $user = auth()->user();

        $tamus = Tamu::paginate(10);

        $opd = Opd::all() ?? [];

        Log::info('Tamu data retrieved', ['count' => $tamus->count(), 'data' => $tamus]);

        return view('superadmin.buka_tamu',compact('tamus','opd'));
    }

    public function delete_tamu($id)
    {
        $user = auth()->user();

        $tamu = Tamu::find($id);
         
        $tamu->delete();

        return redirect()->back()->with('message', 'Data tamu berhasil dihapus.');
    }

    public function update_tamu(Request $request, $id)
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
        'dinas' => 'nullable|string',
        'opd_id' => 'required|exists:opds,id',
        'keperluan' => 'required|string|max:1000',
        'webcamImage' => 'nullable|file|image|max:2048',// For file upload
         ]);

    // Update Tamu record fields
    $tamu->nama = $request->input('nama');
    $tamu->alamat = $request->input('alamat');
    $tamu->dinas = $request->input('dinas');
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

    // Redirect back with success message
    return redirect()->back()->with('success', 'Data tamu berhasil diperbarui!');
}

    
    public function tamu_edit($id)
    {
    $tamu = Tamu::find($id);
    
    $opd = Opd::all();
    
    return view('superadmin.tamu_update', compact('tamu', 'opd'));
    }
        
    public function admin($id)
    {
    $user = User::find($id);
    
    $opd = Opd::all();
    
    return view('superadmin.edit_admin', compact('user', 'opd'));
    }

    public function new_admin(Request $request, $id)
    {

    // Validate the request data
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'username' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'alamat' => 'required|string|max:255',
        'whatsapp' => 'required|regex:/^\d+$/',
        'opd_id' =>'nullable|exists:opds,id',
        'current_password' => 'nullable|string',
        'new_password' => 'nullable|string|min:8|confirmed',
    ]);
    $user = User::find($id);

    if ($request->current_password && !Hash::check($request->current_password, $user->password)) {
        return back()->withErrors(['current_password' => 'Current password is incorrect.']);
    }

    // Update user information
    $user->name = $request->input('name');
    $user->username = $request->input('username');
    $user->email = $request->input('email');
    $user->alamat = $request->input('alamat');
    $user->whatsapp = $request->input('whatsapp');
    $user->opd_id = $request->input('opd');

    // Check if current password is provided and valid
    if ($request->new_password) {
            $user->password = Hash::make($validatedData['new_password']);
        }

    $user->save();

    return redirect()->route('edit_admin', $user->id)->with('success', 'User berhasil diperbarui!');
    }

    public function new_user($id)
    {
    $user = User::find($id);
    
    $opd = Opd::all();
    
    return view('superadmin.edit_user', compact('user', 'opd'));
    }

    public function up_user(Request $request, $id)
    {
    // Validate the request data
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'username' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'alamat' => 'required|string|max:255',
        'whatsapp' => 'required|regex:/^\d+$/',
        'opd_id' =>'nullable|exists:opds,id',
        'current_password' => 'nullable|string',
        'new_password' => 'nullable|string|min:8|confirmed',
    ]);
    $user = User::find($id);

    if ($request->current_password && !Hash::check($request->current_password, $user->password)) {
        return back()->withErrors(['current_password' => 'Current password is incorrect.']);
    }

    // Update user information
    $user->name = $request->input('name');
    $user->username = $request->input('username');
    $user->email = $request->input('email');
    $user->alamat = $request->input('alamat');
    $user->whatsapp = $request->input('whatsapp');
    $user->opd_id = $request->input('opd');

    // Check if current password is provided and valid
    if ($request->new_password) {
            $user->password = Hash::make($validatedData['new_password']);
        }

    $user->save();

    return redirect()->route('edit_user', $user->id)->with('success', 'User berhasil diperbarui!');
    }

    public function cari(Request $request)
    {
        // Ambil nilai pencarian dari request
    $dinas = $request->dinas;
    $tanggal = $request->created_at;

    // Mulai query untuk model Tamu
    $query = Tamu::query();

    // Filter berdasarkan 'dinas' jika ada
    if ($dinas) {
        $query->where('dinas', 'LIKE', '%' . $dinas . '%');
    }

    if ($request->has('tanggal_awal') && $request->has('tanggal_akhir')) {
        $tanggalAwal = $request->tanggal_awal;
        $tanggalAkhir = $request->tanggal_akhir;

        // Validasi rentang tanggal
        if ($tanggalAwal && $tanggalAkhir) {
            $query->whereBetween('created_at', [$tanggalAwal, $tanggalAkhir]);
        }
    }

    // Ambil hasil query dengan paginate
    $tamus= $query->paginate(10);

    // Ambil semua data OPD
    $opd = Opd::all() ?? [];

    // Log informasi data tamu yang diambil
    Log::info('Tamu data retrieved', ['count' => $tamus->count(), 'data' => $tamus]);
    

    // Kirim data ke view
    return view('superadmin.buka_tamu', compact('tamus', 'opd'));
    }
}
