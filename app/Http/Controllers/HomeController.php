<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

use illuminate\Support\Facades\Auth;

use App\Models\User;

use App\Models\Tamu;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{

    
    
    
    public function index()
{
   
    if (Auth::check()) {

        $user = Auth::user(); 

        if ($user->usertype == 'user') {

            return view('admin.home');

        } else if ($user->usertype == 'admin') {

            return view('super.index');

        } else if ($user->usertype == 'superadmin') {

            return view('superadmin.index');

        }
    } else {
       
        return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
    }
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
        return view('admin.tamu');
    }

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

    public function uploadss(Request $request)
{
    // Validate the request
    $validator = Validator::make($request->all(), [
        'nama' => 'required|string',
        'alamat' => 'required|string',
        'asal' => 'required|string',
        'keperluan' => 'required|string',
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
    $tamu->asal = $request->input('asal');
    $tamu->keperluan = $request->input('keperluan');
    $tamu->webcamImage = $imagePath;
    $tamu->save();

    return redirect()->route('tamu')->with('success', 'Data berhasil dikirim');
}

public function buku_tamu()
    {
        $tamu = Tamu::all();

        return view('admin.buku_tamu',compact('tamu'));
    }

    public function buku_tamu2()
    {
        $tamu = Tamu::all();

        return view('admin.buku_tamu2',compact('tamu'));
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
}

