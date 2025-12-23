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

    // Non-Academic Modules
    Route::resource('admin/webinars', App\Http\Controllers\Admin\webinarController::class, ['as' => 'admin']);
    Route::resource('admin/lms-materials', App\Http\Controllers\Admin\LmsMaterialController::class, ['as' => 'admin']);
    Route::resource('admin/trainings', App\Http\Controllers\Admin\TrainingController::class, ['as' => 'admin']);
});

// Yayasan Routes
Route::middleware(['auth', 'role:yayasan'])->group(function () {
    Route::get('/yayasan/dashboard', function () {
        return view('yayasan.home');
    })->name('yayasan.dashboard');
});

// Staff Routes
Route::middleware(['auth', 'role:staff'])->group(function () {
    Route::get('/staff/dashboard', [App\Http\Controllers\Staff\DashboardController::class, 'index'])->name('staff.dashboard');
    
    // Modules
    Route::resource('staff/validation', App\Http\Controllers\Staff\ValidationController::class, ['as' => 'staff']);
    Route::resource('staff/tickets', App\Http\Controllers\Staff\TicketController::class, ['as' => 'staff']);
    Route::post('staff/tickets/{ticket}/reply', [App\Http\Controllers\Staff\TicketController::class, 'reply'])->name('staff.tickets.reply');
    Route::put('staff/tickets/{ticket}/status', [App\Http\Controllers\Staff\TicketController::class, 'updateStatus'])->name('staff.tickets.status');
    Route::resource('staff/materials', App\Http\Controllers\Staff\MaterialController::class, ['as' => 'staff']);
});
