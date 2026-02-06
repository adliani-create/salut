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
    Route::get('/admin/dashboard', function () {
        return 'Admin Dashboard';
    })->name('admin.dashboard');

    // Master Data
    Route::resource('admin/roles', App\Http\Controllers\Admin\RoleController::class, ['as' => 'admin']);
    Route::resource('admin/users', App\Http\Controllers\Admin\UserController::class, ['as' => 'admin']);
    Route::resource('admin/fakultas', App\Http\Controllers\Admin\FakultasController::class, ['as' => 'admin']);
    Route::resource('admin/prodi', App\Http\Controllers\Admin\ProdiController::class, ['as' => 'admin']);
    Route::resource('admin/semester', App\Http\Controllers\Admin\SemesterController::class, ['as' => 'admin']);
});

// Mitra Routes
Route::middleware(['auth', 'role:mitra'])->group(function () {
    Route::get('/mitra/dashboard', function () {
        return 'Mitra Dashboard';
    })->name('mitra.dashboard');
});

// Affiliator Routes
Route::middleware(['auth', 'role:affiliator'])->group(function () {
    Route::get('/affiliator/dashboard', function () {
        return 'Affiliator Dashboard';
    })->name('affiliator.dashboard');
});
