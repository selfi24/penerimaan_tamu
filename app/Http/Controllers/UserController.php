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

class UserController extends Controller
{
    public function index(Request $request)
    {
        $usertype = Auth()->user()->usertype;
    
        if ($usertype == 'admin') {
            $selectedOpdId = Auth()->user()->opd_id; // Dapatkan ID OPD untuk pengguna yang sedang login
            $selectedOpd = Opd::find($selectedOpdId)->dinas;
            $year = $request->input('year', date('Y')); // Dapatkan tahun dari permintaan atau default ke tahun saat ini
    
            // Hitung total tamu untuk OPD yang dipilih
            $tamu = Tamu::where('opd_id', $selectedOpdId)->count();
    
            // Ambil data tamu untuk OPD yang dipilih dan tahun
            $guestData = Tamu::select(DB::raw('MONTH(created_at) as month, COUNT(*) as total'))
                ->whereYear('created_at', $year)
                ->where('opd_id', $selectedOpdId)
                ->groupBy('month')
                ->orderBy('month')
                ->get();
    
            // Siapkan data untuk chart
            $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            $totals = array_fill(0, 12, 0); // Inisialisasi array total untuk 12 bulan
            $years = [];
    
            foreach ($guestData as $data) {
                $totals[$data->month - 1] = (int)$data->total; // Agregasi total untuk bulan
            }
    
            // Mengumpulkan tahun unik dari data tamu
            $guestYears = Tamu::select(DB::raw('YEAR(created_at) as year'))
                ->where('opd_id', $selectedOpdId)
                ->distinct()
                ->pluck('year');
    
            foreach ($guestYears as $guestYear) {
                if (!in_array($guestYear, $years)) {
                    $years[] = $guestYear; // Kumpulkan tahun unik
                }
            }
    
            return view('super.index', compact( 'tamu', 'guestData', 'months', 'totals', 'selectedOpdId', 'selectedOpd', 'years','year'));
        } else if ($usertype == 'user') {
            return view('admin.home');
        }
    }
    
   public function fetchGuestData(Request $request)
{
    $selectedOpdId = Auth()->user()->opd_id; // Dapatkan ID OPD untuk pengguna yang sedang login
    $year = $request->input('year', date('Y')); // Dapatkan tahun dari permintaan

    // Ambil data tamu untuk OPD yang dipilih dan tahun
    $guestData = Tamu::select(DB::raw('MONTH(created_at) as month, COUNT(*) as total'))
        ->whereYear('created_at', $year)
        ->where('opd_id', $selectedOpdId)
        ->groupBy('month')
        ->orderBy('month')
        ->get();

    // Siapkan data untuk respons
    $totals = array_fill(0, 12, 0); // Inisialisasi array total untuk 12 bulan
    foreach ($guestData as $data) {
        $totals[$data->month - 1] = (int)$data->total; // Isi total untuk bulan yang sesuai
    }

    $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

    return response()->json(['totals' => $totals, 'months' => $months]);
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
    'dinas' => 'nullable|string',
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
$tamu->opd_id = $request->input('opd_id');
$tamu->dinas = $request->input('dinas');
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

        $tamu = Tamu::where('opd_id', $user->opd_id)->get();
   
        $opd = Opd::all() ?? [];

        Log::info('Tamu data retrieved', ['count' => $tamu->count(), 'data' => $tamu]);

        return view('super.show_tamu',compact('tamu','opd', 'authUser'));
    }

    public function delete_tamu($id)
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

    $tamu = Tamu::find($id);

    if (!$tamu) {
        return redirect()->back()->with('error', 'Tamu not found.');
    }

    $validated = $request->validate([
        'nama' => 'required|string|max:255',
        'alamat' => 'required|string',
        'dinas' => 'nullable|string',
        'keperluan' => 'required|string|max:1000',
        'webcamImage' => 'nullable|file|image|max:2048',// For file upload
         ]);

    // Update Tamu record fields
    $tamu->nama = $request->input('nama');
    $tamu->alamat = $request->input('alamat');
    $tamu->dinas = $request->input('dinas');
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

        return redirect()->back()->with('success', 'Data tamu berhasil diperbarui!');
    }

    public function getGuestData()
    {
        $admin = Auth::user(); // Assuming you have an authenticated user
        $opd = $user->opd_id; // Get the OPD associated with the logged-in admin
    
        $tamu = Tamu::where('opd_id', $opd)
                       ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
                       ->groupBy('month')
                       ->orderBy('month')
                       ->get();
    
        // Prepare the data for the chart
        $guestData = [];
        foreach ($tamu as $tamu) {
            $guestData[date('F', mktime(0, 0, 0, $tamu->month, 1))] = $tamu->count;
        }
    
        return view('super.main', compact('guestData', 'opd'));
    }
   
}

