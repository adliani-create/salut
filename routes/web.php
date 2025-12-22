<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

    // Master Data
    Route::resource('admin/roles', App\Http\Controllers\Admin\RoleController::class, ['as' => 'admin']);
    Route::resource('admin/users', App\Http\Controllers\Admin\UserController::class, ['as' => 'admin']);
    Route::resource('admin/fakultas', App\Http\Controllers\Admin\FakultasController::class, ['as' => 'admin']);
    Route::resource('admin/prodi', App\Http\Controllers\Admin\ProdiController::class, ['as' => 'admin']);
    Route::resource('admin/semester', App\Http\Controllers\Admin\SemesterController::class, ['as' => 'admin']);
});

// Yayasan Routes
Route::middleware(['auth', 'role:yayasan'])->group(function () {
    Route::get('/yayasan/dashboard', function () {
        return view('yayasan.home');
    })->name('yayasan.dashboard');
});

// Staff Routes
Route::middleware(['auth', 'role:staff'])->group(function () {
    Route::get('/staff/dashboard', function () {
        return view('staff.home');
    })->name('staff.dashboard');
});
