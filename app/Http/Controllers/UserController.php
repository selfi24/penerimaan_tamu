<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Log;

use App\Models\User;

use App\Models\Tamu;

use App\Models\Opd;

class UserController extends Controller
{
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
        'whatsapp' => 'required|string|max:20',
        'alamat' => 'required|string|max:255',
        'usertype' => 'required|string|max:10',
        'opd' => 'required|string|max:100',
    ]);

    $user->username = $request->input('username');
    $user->name = $request->input('name');
    $user->email = $request->input('email');
    $user->whatsapp = $request->input('whatsapp');
    $user->alamat = $request->input('alamat');
    $user->usertype = $request->input('usertype');
    $user->opd = $request->input('opd');
    $user->update($request->all());
    $user->save();

    return redirect()->route('profile.edit')->with('message', 'Profile updated successfully!');
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
        'nama' => 'required|string|string|max:255',
        'alamat' => 'required|string',
        'opd' => 'required|string',
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
    $tamu->opd = $request->input('opd');
    $tamu->keperluan = $request->input('keperluan');
    $tamu->webcamImage = $imagePath;
    $tamu->save();

    return redirect()->route('tamu')->with('message', 'Data tamu berhasil dikirim');
}

public function tamu()
{

    $user = auth()->user();
    
    $opd = Opd::all();

    $tamu = Tamu::where('opd', $user->opd)->get();
   
    return view('super.entry_tamu', compact('tamu','opd'));
}

public function show_tamu()
    {
        $user = auth()->user();

        $tamu = Tamu::where('opd', $user->opd)->get();

        $opd = Opd::all() ?? [];

        Log::info('Tamu data retrieved', ['count' => $tamu->count(), 'data' => $tamu]);

        return view('super.show_tamu',compact('tamu','opd'));
    }

    public function delete($id)
    {
        Log::info('Attempting to delete tamu with ID: ' . $id);

        // Find the record by ID and delete it
        $user = auth()->user();

        $tamu = Tamu::find($id);
        if (!$tamu || $tamu->opd !== $user->opd) {
            Log::warning('Tamu not found for ID: ' . $id);
            return redirect()->back()->with('message', 'Data tamu tidak ditemukan.');
        }
        $tamu->delete();

        Log::info('Tamu successfully deleted with ID: ' . $id);
        // Redirect or return a response
        return redirect()->back()->with('message', 'Data tamu berhasil dihapus.');
    }

    public function update_tamu(Request $request, $id)
    {
        $user = auth()->user();
        $tamu = Tamu::find($id);

        if (!$tamu || $tamu->opd !== $user->opd) {
            return redirect()->back()->with('message', 'Anda tidak memiliki izin untuk memperbarui data ini.');
        }

        $tamu->update($request->all());
        return redirect()->back()->with('success', 'Guest updated successfully!');
    }

   
    public function opd()
    {
        $opds = Opd::paginate(7);

        return view('super.opd' ,compact('opds')); // Adjust the view path as needed
    }

    // Store a newly created department in storage
    public function add_dinas(Request $request)
    {
        
        $opd = new Opd;

        $opd->dinas= $request->opd;

        $opd->save();
        // Redirect to the form with a success message
        return redirect()->back()->with('message', 'Dinas added successfully!');
    }


    public function opd_delete($id)
    {
        $opd= Opd::find($id);

        $opd->delete();

        return redirect()->back()->with('success','Dinas berhasil dihapus');
    }

    public function update_opd(Request $request,$id)
    {

        $opd = Opd::find($id);

        

            $opd->dinas = $request->dinas;

            $opd->save();

            return redirect()->back()->with('message', 'Dinas updated successfully!');
        
    }

}

