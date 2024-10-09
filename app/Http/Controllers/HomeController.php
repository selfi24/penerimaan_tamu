<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

use illuminate\Support\Facades\Auth;

use App\Models\User;

use App\Models\Tamu;

use App\Models\Opd;

use Illuminate\Support\Str;

use Illuminate\Http\JsonResponse;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{   
    public function index()
{
    $tamu = Tamu::latest()->take(4)->get();
    
    if (Auth::check()) {

        $user = Auth::user(); 

        if ($user->usertype == 'user') {

            return view('admin.home', compact('tamu'));

        } else if ($user->usertype == 'admin') {

            return view('super.index');

        } else if ($user->usertype == 'superadmin') {

            return view('superadmin.index');

        }
    } 

    return view('admin.home', compact('tamu'));
}

    public function page()
    {
        return view('adminpage');
    }

    public function contact()
    {
        return view('admin.contact');
    }
    
    public function tamu()
    {

        $user = auth()->user();
    
        $opd = Opd::all();
    
        return view('admin.entry_tamu', compact('opd'));
    }

    public function uploadss(Request $request)
{
    
    $user = auth()->user();
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
    $tamu->dinas = $request->input('dinas');
    $tamu->opd_id = $request->input('opd_id');
    $tamu->keperluan = $request->input('keperluan');
    $tamu->webcamImage = $imagePath;
    $tamu->save();

    return redirect()->route('entry_tamu')->with('success', 'Data berhasil dikirim');
}

public function buku_tamu()
    {
        $tamu = Tamu::paginate(6);

        return view('admin.buku_tamu',compact('tamu'));
    }

    public function show($id)
{
    $tamu = Tamu::find($id);

    return view('admin.tamu_show', compact('tamu'));
}

    public function edit($id)
    {
        $tamu = Tamu::find($id);

        return view('admin.tamu_update', compact('tamu'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'asal' => 'required|string',
            'keperluan' => 'required|string',
            'webcamImage' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $tamu = Tamu::find($id);
        $tamu->nama = $request->input('nama');
        $tamu->alamat = $request->input('alamat');
        $tamu->asal = $request->input('asal');
        $tamu->keperluan = $request->input('keperluan');

        if ($request->hasFile('webcamImage')) {
            // Delete the old image if exists
            if ($tamu->webcamImage) {
                Storage::delete('public/' . $tamu->webcamImage);
            }

            // Store the new image
            $imagePath = $request->file('webcamImage')->store('public');
            $tamu->webcamImage = basename($imagePath);
        }

        $tamu->save();

        return redirect()->route('buku_tamu')->with('success', 'Guest record updated successfully.');
    }

    public function hapus($id)
    {
        // Find the record by ID and delete it
        $tamu = Tamu::findOrFail($id);
        $tamu->delete();

        // Redirect or return a response
        return redirect()->route('buku_tamu')->with('success', 'Entry deleted successfully.');
    }

    public function jadwal()
    {
        return view('admin.jadwal');
    }

    public function getCalendarData($year, $month)
    {
        // Ambil data tamu berdasarkan tahun dan bulan
        $tamu = Tamu::whereYear('created_at', $year)
                     ->whereMonth('created_at', $month + 1) // PHP bulan mulai dari 1
                     ->with('opd')
                     ->get();

        return response()->json($tamu);
    }
}

