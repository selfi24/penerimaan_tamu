<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;


use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('admin.home');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});




route::get('/home', [HomeController::class,'index'])->name('home');

route::get('/adminpage', [HomeController::class,'page'])->middleware('auth','admin');

route::get('/contact', [HomeController::class,'contact'])->name('contact');

route::get('/tamu', [HomeController::class,'tamu'])->name('tamu');

route::get('/show_profil', [HomeController::class,'show_profil'])->name('show_profil');

route::get('profil_delete/{id}',[HomeController::class,'profil_delete']);

route::get('edit_profil/{id}', [HomeController::class, 'edit_profil'])->name('edit_profil');

route::put('update_profil/{id}', [HomeController::class, 'update_profil'])->name('update_profil');

Route::get('/webcam', function () {
    return view('webcam');
});

Route::post('/submit', [HomeController::class, 'uploadss']);

route::get('/buku_tamu', [HomeController::class,'buku_tamu'])->name('buku_tamu');

route::get('/buku_tamu2', [HomeController::class,'buku_tamu2'])->name('buku_tamu2');

Route::get('/tamu/{id}', [HomeController::class, 'show'])->name('tamu_show');

Route::get('tamu/{id}/edit', [HomeController::class, 'edit'])->name('tamu_edit');

Route::put('tamu/{id}', [HomeController::class, 'update'])->name('tamu_update');

Route::delete('/tamu/{id}', [HomeController::class, 'hapus'])->name('tamu_hapus');




route::get('/index', [UserController::class,'index'])->name('index');

// Route to show profile
Route::get('/profil', [UserController::class, 'show'])->name('profile.show');

// Route to show update profile form
Route::get('/profil/edit', [UserController::class, 'edit'])->name('profile.edit');

// Route to handle profile update
Route::post('/profil/update', [UserController::class, 'update'])->name('profile.update');

Route::delete('user/profile', [UserController::class, 'destroy'])->name('profile.destroy');

route::get('/tamu', [UserController::class,'tamu'])->name('tamu');

Route::post('/submit-form', [UserController::class, 'upload']);

route::get('/show_tamu', [UserController::class,'show_tamu'])->name('show_tamu');

Route::delete('/tamu/{id}', [UserController::class, 'delete'])->name('delete');

// Route to display the edit form
Route::get('/tamu/{id}/edit', [UserController::class, 'edit_tamu'])->name('tamu.edit');

// Route to handle the form submission
Route::put('/tamu/{id}', [UserController::class, 'update_tamu'])->name('update_tamu');

// Route to show the form for adding a category
Route::get('/opd', [UserController::class, 'opd'])->name('opd');

// Route to handle the form submission for adding a category
Route::post('/add_dinas', [UserController::class, 'add_dinas']);


route::get('/opd_delete/{id}',[UserController::class,'opd_delete']);

route::put('/opd/update/{id}',[UserController::class,'update_opd']);
