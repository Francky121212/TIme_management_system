<?php
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\isAdmin;
use App\Http\Controllers\ScheduleController;


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

Route::get('/schedules', [ScheduleController::class, 'index'])->name('schedules.index');

Route::post('/schedules', [ScheduleController::class, 'store'])->name('schedules.store');


Route::get('/schedules/{schedule}/edit', [ScheduleController::class, 'edit'])->name('schedules.edit');

Route::put('/schedules/{schedule}', [ScheduleController::class, 'update'])->name('schedules.update');

Route::get('/schedules/pdf', [ScheduleController::class, 'generatePdf'])->name('schedules.pdf');
Route::get('/schedules/excel', [ScheduleController::class, 'exportExcel'])->name('schedules.excel');