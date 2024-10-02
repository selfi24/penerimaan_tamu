<?php

use App\Models\Tamu;

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;

use App\Http\Controllers\SuperController;

use App\Http\Controllers\UserController;

use App\Http\Controllers\CaptchaController;

Route::get('/', function () {

    $tamu = Tamu::latest()->take(4)->get();
    return view('admin.home', compact('tamu'));
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


Route::get('login', [CaptchaController::class, 'showLoginForm'])->name('login');
Route::post('login', [CaptchaController::class, 'captchaValidate'])->name('login.post');
Route::get('refreshcaptcha', [CaptchaController::class, 'refreshCaptcha'])->name("captchacontroller.refresh");


route::get('/home', [HomeController::class,'index'])->name('home');
route::get('/adminpage', [HomeController::class,'page'])->middleware('auth','admin');
route::get('/contact', [HomeController::class,'contact'])->name('contact');
route::get('/jadwal', [HomeController::class,'jadwal'])->name('jadwal');
route::get('/get-calendar-data/{year}/{month}', [HomeController::class, 'getCalendarData']);

route::get('/show_profil', [HomeController::class,'show_profil'])->name('show_profil');
route::get('profil_delete/{id}',[HomeController::class,'profil_delete']);
route::get('edit_profil/{id}', [HomeController::class, 'edit_profil'])->name('edit_profil');
route::put('update_profil/{id}', [HomeController::class, 'update_profil'])->name('update_profil');
Route::get('/webcam', function () {
    return view('webcam');
});


route::get('/entry_tamu', [HomeController::class,'tamu'])->name('entry_tamu');
Route::post('/submit-form1', [HomeController::class, 'uploadss']);

route::get('/buku_tamu', [HomeController::class,'buku_tamu'])->name('buku_tamu');
route::get('/buku_tamu2', [HomeController::class,'buku_tamu2'])->name('buku_tamu2');
Route::get('/tamu/{id}', [HomeController::class, 'show'])->name('tamu_show');
Route::get('tamu/{id}/edit', [HomeController::class, 'edit'])->name('tamu_edit');
Route::put('tamu/{id}', [HomeController::class, 'update'])->name('tamu_update');
Route::delete('/tamu/{id}', [HomeController::class, 'hapus'])->name('tamu_hapus');



Route::middleware('auth')->group(function () {
route::get('index', [UserController::class,'index'])->name('index');
Route::get('/profil', [UserController::class, 'show'])->name('profile.show');
Route::get('/profil/edit', [UserController::class, 'edit'])->name('profile.edit');
Route::post('/profil/update', [UserController::class, 'update'])->name('profile.update');
Route::delete('user/profile', [UserController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
route::get('/tamu', [UserController::class,'tamu'])->name('tamu');
Route::post('/submit-form', [UserController::class, 'upload']);
route::get('/show_tamu', [UserController::class,'show_tamu'])->name('show_tamu');
Route::delete('/tamu/{id}', [UserController::class, 'delete'])->name('delete');
Route::get('/tamu/{id}/edit', [UserController::class, 'ed_tamu'])->name('edit.tamu');
Route::post('/up_tamu/{id}', [UserController::class, 'up_tamu'])->name('tamu.update');
});

Route::middleware('auth')->group(function () {
route::get('/superadmin/index', [SuperController::class,'super'])->name('superadmin.index');
Route::get('/show_profil', [SuperController::class, 'show_profil'])->name('show_profil');
Route::get('/edit/profil', [SuperController::class, 'edit_profil'])->name('edit_profil');
Route::post('/update-profile', [SuperController::class, 'updateProfil'])->name('update_profil');
Route::delete('profil/user', [SuperController::class, 'destroy_profil'])->name('destroy_profil');
});

Route::middleware('auth')->group(function () {
Route::get('/opd', [SuperController::class, 'opd'])->name('opd');
Route::post('/add_dinas', [SuperController::class, 'add_dinas']);
route::get('/opd_delete/{id}',[SuperController::class,'opd_delete']);
route::put('/opd/update/{id}',[SuperController::class,'update_opd']);
});

Route::middleware('auth')->group(function () {
Route::get('/user', [SuperController::class, 'user'])->name('user');
Route::get('/users/{id}/edit', [SuperController::class, 'edit'])->name('users.edit');
Route::put('/users/{id}', [SuperController::class, 'up'])->name('users.update');
Route::delete('/users/{id}', [SuperController::class, 'del'])->name('users.destroy');
Route::get('/add_user', [SuperController::class, 'add'])->name('add_user');
Route::get('/user/edit', [SuperController::class, 'edit'])->name('user.edit');
Route::post('/add_user', [SuperController::class, 'store'])->name('users.store');
Route::get('admin/edit/{id}', [SuperController::class, 'admin'])->name('edit_admin');
Route::post('admin/update/{id}', [SuperController::class, 'update_admin'])->name('admin_update');
});

Route::middleware('auth')->group(function () {
Route::get('/pengguna', [SuperController::class, 'pengguna'])->name('pengguna');
Route::put('/users/{id}', [SuperController::class, 'upp'])->name('user.upp');
Route::get('/add_pengguna', [SuperController::class, 'add_pengguna'])->name('add_pengguna');
Route::post('/add_pengguna', [SuperController::class, 'req'])->name('user.req');
Route::delete('/user/{id}', [SuperController::class, 'dell'])->name('user.dell');
});

Route::middleware('auth')->group(function () {
route::get('/enter_tamu', [SuperController::class,'enter_tamu'])->name('enter_tamu');
Route::post('/submit_form', [SuperController::class, 'upload_tamu'])->name('upload_tamu');
route::get('/buka_tamu', [SuperController::class,'buka_tamu'])->name('buka_tamu');
Route::delete('/buka_tamu/{id}', [SuperController::class, 'delete_tamu'])->name('delete_tamu');
Route::get('/buka_tamu/{id}/edit', [SuperController::class, 'edit_tamu'])->name('tamu.edit');
Route::get('/tamu/edit/{id}', [SuperController::class, 'tamu_edit'])->name('tamu_edit');
Route::post('/tamu/update/{id}', [SuperController::class, 'update_tamu'])->name('update_tamu');
});
