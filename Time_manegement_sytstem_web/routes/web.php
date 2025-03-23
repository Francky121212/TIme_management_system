<?php
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\isAdmin;



Route::get('/', function () {
    return view('register');
});
Route::get('/dashboard', function () {
    return view('dashboard');
});
Route::get('/success', function () {
    return view('success');
});

Route::get('/login', function () {
    return view('login');
});
Route::get('/notif', [MailController::class, 'Send_mail']);


Route::post('/register', [AuthController::class, 'register']);
Route::post('/admin', [LoginController::class, 'login']);

Route::get('/savedSchedules', function () {
    return view('savedSchedules');
  });
Route::post('/savedSchedules', [AuthController::class, 'index']);